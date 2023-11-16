<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use JsonException;
use Soher\Work\Domain\Status;

class WorkFactory extends Factory
{
    /**
     * @throws JsonException
     */
    public function definition(): array
    {
        return [
            'client_id' => User::all('id')->random()->id,
            'title' => fake()->realText(50),
            'location' => fake()->address,
            'description' => fake()->paragraph(5),
            'skills' => fake()->randomElements(['Mecanica', 'Electrica', 'Plomeria', 'Carpinteria', 'Herreria'], 2),
            'budget' => fake()->randomNumber(2),
            'deadline' => fake()->date,
            'status' => Status::OPEN->value,
            'photo' => '/storage/images/' . fake()->image('public/storage/images', 640, 480, null, false),
            'created_at' => fake()->dateTime
        ];
    }
}
