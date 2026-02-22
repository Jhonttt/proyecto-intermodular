<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory {
    protected $model = User::class;

    public function definition(): array {
        return [
            'name'            => fake()->name(),
            'email'           => fake()->unique()->safeEmail(),
            'password'        => Hash::make('1234'),
            'rol'             => 'usu',
            'activo'          => true,
            'proyecto_subido' => false,
        ];
    }

    public function admin(): static {
        return $this->state(['rol' => 'admin']);
    }

    public function inactivo(): static {
        return $this->state(['activo' => false]);
    }

    public function conProyecto(): static {
        return $this->state(['proyecto_subido' => true]);
    }
}