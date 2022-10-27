<?php

namespace Database\Factories;

use App\Enums\DestinationStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Destination>
 */
class DestinationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $statuses = DestinationStatus::getValues();
        $index = array_rand($statuses);

        return [
            'url' => fake()->unique()->url(),
            'alias' => 'tinyurl.com/'.substr(fake()->uuid(), 0, 8),
            'status' => $statuses[$index],
        ];
    }
}
