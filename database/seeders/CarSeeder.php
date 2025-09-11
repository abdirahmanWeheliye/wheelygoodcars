<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $users = User::all();

        Car::factory()->count(250)->make()->each(function ($car) use ($users) {
            $car->user_id = $users->random()->id;
            $car->save();
        });
    }
}
