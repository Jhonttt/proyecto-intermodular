<?php

namespace Database\Factories;

use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProyectoFactory extends Factory {
    protected $model = Proyecto::class;

    public function definition(): array {
        return [
            'user_id'      => User::factory(),
            'nombre'       => fake()->sentence(3),
            'resumen'      => fake()->sentence(10),
            'descripcion'  => fake()->paragraph(3),
            'video_url' => $video = fake()->randomElement(['hola.mp4', 'demo.mp4', 'presentacion.mp4']),
            'video_thumbnail' => 'proyectos/thumbnails/' . str_replace('.mp4', '_thumb.jpg', $video),
            'ciclo'        => fake()->randomElement(['DAW', 'DAM', 'ASIR', 'AF', 'AD', 'AUT']),
            'anio'         => fake()->randomElement(['2022/2023', '2023/2024', '2024/2025', "2025/2026"]),
            'alumnos'      => fake()->randomElements([
                'Juan Pérez',
                'Ana López',
                'Carlos Ruiz',
                'Marta Díaz',
                'Pedro Sánchez',
                'Laura García',
                'David Martín',
                'Sofía Torres'
            ], fake()->numberBetween(1, 3)),
            'documentos'   => fake()->randomElements([
                'memoria.pdf',
                'manual_usuario.pdf',
                'documentacion_tecnica.pdf',
                'presentacion.pptx',
                'diagrama_bd.pdf',
                'manual_instalacion.pdf'
            ], fake()->numberBetween(1, 3)),
            'tags'         => fake()->randomElements([
                'laravel',
                'angular',
                'react',
                'vue',
                'php',
                'javascript',
                'typescript',
                'mysql',
                'api-rest',
                'crud',
                'docker',
                'python'
            ], fake()->numberBetween(2, 5)),
            'checked'      => false,
            'observaciones' => null,
        ];
    }

    public function verificado(): static {
        return $this->state([
            'checked'      => true,
            'observaciones' => fake()->randomElement([
                'Entrega correcta',
                'Muy buen trabajo',
                'Proyecto aprobado',
                null
            ])
        ]);
    }
}
