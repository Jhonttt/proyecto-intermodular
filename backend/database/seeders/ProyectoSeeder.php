<?php

namespace Database\Seeders;

use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProyectoSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $juan = User::where('email', 'juan@test.com')->first();
        $luis = User::where('email', 'luis@test.com')->first();

        Proyecto::create([
            "user_id" => $juan->id,
            "nombre" => "Gestor de Tareas Web",
            "resumen" => "Aplicación CRUD para gestionar tareas académicas",
            "descripcion" => "Proyecto desarrollado con Laravel y Angular que permite crear, editar y eliminar tareas con autenticación.",
            "video_url" => "hola.mp4",
            "ciclo" => "DAW 2º",
            "anio" => "2024/2025",
            "alumnos" => ["Juan Pérez", "Ana López"],
            "documentos" => ["memoria.pdf", "manual_usuario.pdf"],
            "tags" => ["laravel", "angular", "crud", "autenticación"],
            "checked" => true,
            "observaciones" => "Entrega correcta"
        ]);
        $juan->update(["proyecto_subido" => true]);

        Proyecto::create([
            "user_id" => $luis->id,
            "nombre" => "Sistema de Reservas",
            "resumen" => "Plataforma para reservar aulas",
            "descripcion" => "Sistema con panel admin, control de disponibilidad y API REST.",
            "video_url" => "hola.mp4",
            "ciclo" => "DAW 2º",
            "anio" => "2023/2024",
            "alumnos" => ["Carlos Ruiz", "Marta Díaz"],
            "documentos" => ["documentacion_tecnica.pdf", "presentacion.pptx"],
            "tags" => ["api-rest", "laravel", "reservas", "admin-panel"],
            "checked" => false,
            "observaciones" => null
        ]);
        $luis->update(["proyecto_subido" => true]);
    }
}
