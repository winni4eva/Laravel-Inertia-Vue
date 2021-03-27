<?php

namespace Tests\Models;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

	public function test_rating_returns_the_average_rating()
    {
        $company = Company::factory()->create();

        $company->ratings()->create(['user_id' => 1, 'rating' => 1]);
        $company->ratings()->create(['user_id' => 2, 'rating' => 4]);

        $this->assertSame(2.5, $company->rating);
    }

    public function test_ratingCount_returns_the_count()
    {
        $company = Company::factory()->create();

        $company->ratings()->create(['user_id' => 1, 'rating' => 1]);
        $company->ratings()->create(['user_id' => 2, 'rating' => 5]);

        $this->assertSame(2, $company->ratingCount);
    }

    public function test_ratingAverage_returns_null_if_none_exists()
    {
        $company = Company::factory()->create();

        $this->assertSame(null, $company->rating_average);
    }

    public function test_ratingCount_returns_0_if_none_exists()
    {
        $company = Company::factory()->create();

        $this->assertSame(0, $company->ratingCount);
    }

    public function test_userRating_returns_loggin_users_rating()
    {
        $company = Company::factory()->create();
        $user = User::factory()->create();

        $company->ratings()->create([
            'user_id'   => $user->id,
            'rating'    => 4
        ]);
        $this->actingAs($user);

        $this->assertSame(4, $company->userRating);
    }

}
