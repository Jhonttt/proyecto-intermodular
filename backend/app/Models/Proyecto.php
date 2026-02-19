<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\JsonUnicode;

class Proyecto extends Model {
    use HasFactory;

    protected $table = 'proyectos';

    protected $fillable = [
        "nombre",
        "resumen",
        "descripcion",
        "ciclo",
        "anio",
        "alumnos",
        "documentos",
        "tags",
        "checked",
        "observaciones",
    ];

    protected $casts = [
        "alumnos" => JsonUnicode::class,
        'documentos' => JsonUnicode::class,
        'tags' => JsonUnicode::class,
        'checked' => 'boolean',
    ];
}
