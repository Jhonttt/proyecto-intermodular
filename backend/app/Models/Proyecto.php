<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\JsonUnicode;

class Proyecto extends Model
{
    use HasFactory;

    protected $table = 'proyectos';

    protected $fillable = [
        "nombre",
        "resumen",
        "descripcion",
        "video_url",
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

    //Para enlaces en JSON como "video_public_url"
     protected $appends = ['video_public_url'];

    public function getVideoPublicUrlAttribute(): ?string
    {
        if (!$this->video_url) return null;

        if (preg_match('#^https?://#', $this->video_url)) {
            return $this->video_url;
        }

        $path = ltrim($this->video_url, '/');

        if (!str_starts_with($path, 'proyectos/')) {
            $path = 'proyectos/' . $path;
        }

        return asset('storage/' . $path);
    }
}
