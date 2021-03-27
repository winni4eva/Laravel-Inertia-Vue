<?php

namespace Tests\Http\Controllers;

use App\Http\Controllers\CompanyController;
use App\Models\Company;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;


class CompanyControllerTest extends TestCase
{

    use RefreshDatabase;

	public function testIndex()
	{
        Company::factory()->count(5)->create();

        $result = $this->getJson(route("companies.index"));


        $result->assertStatus(Response::HTTP_OK);
        $result->assertJsonCount(5, 'data');
	}

	public function test_index_default_paginates_to_10()
    {
        Company::factory()->count(20)->create();

        $result = $this->getJson(route("companies.index"));


        $result->assertStatus(Response::HTTP_OK);
        $result->assertJsonCount(10, 'data');
        $result->assertJsonFragment(['total' => 20]);
    }

    public function test_index_returns_based_on_name_search()
    {
        Company::factory()->count(20)->create();
        Company::factory()->create(['name' => 'Test Name']);

        $result = $this->getJson(route("companies.index") . '?name=Test');


        $result->assertStatus(Response::HTTP_OK);
        $result->assertJsonCount(1, 'data');
        $result->assertJsonFragment(['total' => 1]);
        $result->assertJsonFragment(['name' => 'Test Name']);
    }

    public function test_index_returns_based_on_minimum_rating()
    {
        $user = User::factory()->isAdmin()->create();
        Company::factory()->count(20)->create()->each(function ($company) use($user) {
            $company->ratings()->create(
                [
                    'rating' => random_int(1, 3),
                    'user_id' => $user->id
                ]
            );
        });
        Company::factory()->count(5)->create()->each(function ($company) use($user) {
            $company->ratings()->create(
                [
                    'rating' => 5,
                    'user_id' => $user->id
                ]
            );
        });

        $result = $this->getJson(route("companies.index") . '?rating_min=4');

        $result->assertStatus(Response::HTTP_OK);
        $result->assertJsonCount(5, 'data');
        $result->assertJsonFragment(['total' => 5]);
    }

    public function test_index_returns_based_on_max_rating()
    {
        $user = User::factory()->isAdmin()->create();
        Company::factory()->count(5)->create()->each(function ($company) use($user) {
            $company->ratings()->create(
                [
                    'rating' => random_int(1, 3),
                    'user_id' => $user->id
                ]
            );
        });
        Company::factory()->count(20)->create()->each(function ($company) use($user) {
            $company->ratings()->create(
                [
                    'rating' => 5,
                    'user_id' => $user->id
                ]
            );
        });

        $result = $this->getJson(route("companies.index") . '?rating_max=4');

        $result->assertStatus(Response::HTTP_OK);
        $result->assertJsonCount(5, 'data');
        $result->assertJsonFragment(['total' => 5]);
    }

    public function test_admin_can_store_a_new_company()
    {
        $user = User::factory()->isAdmin()->create();
        $company = Company::factory()->make()->only(['name', 'phone', 'url', 'email']);

        $this->assertDatabaseMissing('companies', $company);

        $response = $this->actingAs($user)->postJson(route('companies.store', ['manager' => $user->id]), $company);
        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertDatabaseHas('companies', $company);
    }

    public function test_non_admin_can_not_store_a_new_company()
    {
        $user = User::factory()->create();
        $company = Company::factory()->make()->toArray();
        unset($company['ratings']);
        $this->assertDatabaseMissing('companies', $company);

        $response = $this->actingAs($user)->postJson(route('companies.store', ['manager' => $user->id]), $company);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
        $this->assertDatabaseMissing('companies', $company);
    }

    public function test_admin_can_update_a_company()
    {
        $user = User::factory()->isAdmin()->create();
        $oldCompany = Company::factory()->create()->only(['id','name', 'phone', 'url', 'email']);
        $newCompany = Company::factory()->make()->only(['name', 'phone', 'url', 'email']);

        $this->assertDatabaseHas('companies', $oldCompany);
        $this->assertDatabaseMissing('companies', $newCompany);

        $response = $this->actingAs($user)->putJson(route('companies.update', [$oldCompany['id'], $user->id]), $newCompany);

        $response->assertStatus(Response::HTTP_FOUND);
        $this->assertDatabaseHas('companies', $newCompany);
        $this->assertDatabaseMissing('companies', $oldCompany);
    }

    public function test_non_admin_can_not_update_a_company()
    {
        $user = User::factory()->create();
        $oldCompany = Company::factory()->create()->only(['id','name', 'phone', 'url', 'email']);

        $newCompany = Company::factory()->make()->only(['name', 'phone', 'url', 'email']);

        $this->assertDatabaseHas('companies', $oldCompany);
        $this->assertDatabaseMissing('companies', $newCompany);

        $response = $this->actingAs($user)->putJson(route('companies.update', [$oldCompany['id'], $user->id]), $newCompany);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
        $this->assertDatabaseMissing('companies', $newCompany);
        $this->assertDatabaseHas('companies', $oldCompany);
    }

    public function test_admin_can_delete_a_company()
    {
        $user = User::factory()->isAdmin()->create();
        $company = Company::factory()->create()->only(['id','name', 'phone', 'url', 'email']);

        $this->assertDatabaseHas('companies', $company);
    
        $response = $this->actingAs($user)->deleteJson(route('companies.destroy', $company['id']));

        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseMissing('companies', $company);
    }

    public function test_non_admin_can_not_delete_a_company()
    {
        $user = User::factory()->create();
        $company = Company::factory()->create()->only(['id','name', 'phone', 'url', 'email']);

        $this->assertDatabaseHas('companies', $company);
       
        $response = $this->actingAs($user)->deleteJson(route('companies.destroy', $company['id']));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $this->assertDatabaseHas('companies', $company);
    }
}
