<?php

namespace Database\Seeders;

use App\Models\Proyecto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProyectoSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        Proyecto::create([
            "nombre" => "Gestor de Tareas Web",
            "resumen" => "Aplicación CRUD para gestionar tareas académicas",
            "descripción" => "Proyecto desarrollado con Laravel y Angular que permite crear, editar y eliminar tareas con autenticación.",
            "curso" => "DAW 2º",
            "alumnos" => "Juan Pérez, Ana López",
            "video_url" => "https://youtube.com/watch?v=demo1",
            "checked" => true,
            "observaciones" => "Entrega correcta"
        ]);

        Proyecto::create([
            "nombre" => "Sistema de Reservas",
            "resumen" => "Plataforma para reservar aulas",
            "descripción" => "Sistema con panel admin, control de disponibilidad y API REST.",
            "curso" => "DAW 2º",
            "alumnos" => "Carlos Ruiz, Marta Díaz",
            "video_url" => "https://youtube.com/watch?v=demo2",
            "checked" => false,
            "observaciones" => null
        ]);

        Proyecto::create([
            "nombre" => "Blog educativo",
            "resumen" => "Blog con panel de administración",
            "descripción" => "CRUD de posts, categorías y usuarios con roles.",
            "curso" => "DAW 2º",
            "alumnos" => "Lucía Torres",
            "video_url" => "https://youtube.com/watch?v=demo3",
            "checked" => true,
            "observaciones" => "Buen diseño UI"
        ]);
        Proyecto::create([
            "nombre" => "Gestor de Inventario",
            "resumen" => "Aplicación para controlar stock de productos",
            "descripción" => "Sistema web con control de inventario, alertas de stock mínimo y panel administrativo desarrollado en Laravel.",
            "curso" => "DAW 2º",
            "alumnos" => "Pedro Sánchez, Laura Gómez",
            "video_url" => "https://youtube.com/watch?v=demo4",
            "checked" => false,
            "observaciones" => "Pendiente de revisión funcional"
        ]);

        Proyecto::create([
            "nombre" => "Plataforma de Cursos Online",
            "resumen" => "Campus virtual con vídeos y evaluaciones",
            "descripción" => "Aplicación SPA con Angular y API REST en Laravel para gestión de cursos, lecciones y progreso del alumno.",
            "curso" => "DAW 2º",
            "alumnos" => "Diego Martín, Sara Navarro",
            "video_url" => "https://youtube.com/watch?v=demo5",
            "checked" => true,
            "observaciones" => "Muy buena organización del código"
        ]);

        Proyecto::create([
            "nombre" => "Foro de Soporte Técnico",
            "resumen" => "Foro para consultas y respuestas entre usuarios",
            "descripción" => "Sistema de preguntas y respuestas con roles, votaciones y moderación implementado con Laravel Blade.",
            "curso" => "DAW 2º",
            "alumnos" => "Elena Ruiz, Marcos Vidal",
            "video_url" => "https://youtube.com/watch?v=demo6",
            "checked" => false,
            "observaciones" => null
        ]);
    }
}
