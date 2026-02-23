<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        User::create([
            "name" => "Periko",
            "email" => "periko@test.com",
            "password" => Hash::make("1234"),
            "rol" => "admin",
            "activo" => true,
        ]);
        User::create([
            "name" => "Juan",
            "email" => "juan@test.com",
            "password" => Hash::make("1234"),
            "rol" => "usu",
            "activo" => true,
        ]);
        User::create([
            "name" => "Luis",
            "email" => "luis@test.com",
            "password" => Hash::make("1234"),
            "rol" => "usu",
            "activo" => false,
        ]);
        User::create([
            "name" => "Marta",
            "email" => "marta@test.com",
            "password" => Hash::make("1234"),
            "rol" => "admin",
            "activo" => false,
        ]);

        // 5 admins aleatorios
        User::factory()->admin()->count(5)->create();

        // 20 alumnos sin proyecto
        User::factory()->count(20)->create();

        // 15 alumnos con proyecto (se marcan aquí, el proyecto lo crea ProyectoSeeder)
        User::factory()->conProyecto()->count(15)->create();

        // 10 alumnos con proyecto pendiente
        User::factory()->conProyecto()->count(10)->create();
    }
}
