<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model {
    use HasFactory;

    protected $table = 'proyectos';

    protected $fillable = [
        "nombre",
        "resumen",
        "descripción",
        "curso",
        "alumnos",
        "video_url",
        "documentos",
        "tags",
        "checked",
        "observaciones",
    ];

    protected $casts = [
        'documentos' => 'array',
        'tags' => 'array',
        'checked' => 'boolean',
    ];
}
