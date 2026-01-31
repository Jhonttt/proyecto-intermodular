<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model {
    protected $table = "proyectos";

    protected $fillable = [
        "nombre",
        "resumen",
        "descripción",
        "curso",
        "alumnos",
        "video_url",
        "checked",
        "observaciones",
    ];
}