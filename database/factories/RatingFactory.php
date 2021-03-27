<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RatingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rating::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'rating' => random_int(0, config('app.maxRating')),
            'user_id' => User::factory()->create()->id,
            'company_id' => Company::factory()->create()->id,
        ];
    }
}
