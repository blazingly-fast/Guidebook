<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guidebook>
 */
class GuidebookFactory extends Factory
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
			'user_id' => User::all()->random()->id,
			'title' => $this->faker->unique()->sentence(),
			'description' => $this->faker->unique()->text(),
		];
	}
}
