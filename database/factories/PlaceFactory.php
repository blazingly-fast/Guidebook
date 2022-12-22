<?php

namespace Database\Factories;

use App\Models\Guidebook;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Place>
 */
class PlaceFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition()
	{
		return [
			'id' => $this->faker->uuid(),
			'guidebook_id' => Guidebook::all()->random()->id,
			'title' => $this->faker->unique()->sentence(),
			'description' => $this->faker->unique()->text(),
		];
	}
}
