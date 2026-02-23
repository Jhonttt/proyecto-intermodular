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
        "video_url",
        "video_thumbnail",
        "ciclo",
        "anio",
        "alumnos",
        "documentos",
        "tags",
        "checked",
        "observaciones",
        "user_id",
    ];

    protected $casts = [
        "alumnos" => JsonUnicode::class,
        'documentos' => JsonUnicode::class,
        'tags' => JsonUnicode::class,
        'checked' => 'boolean',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    //Para enlaces en JSON como "video_public_url"
    protected $appends = [
        'video_public_url',
        'documentos_public'
    ];

    public function getVideoPublicUrlAttribute(): ?string {
        if (!$this->video_url) return null;

        if (preg_match('#^https?://#', $this->video_url)) {
            return $this->video_url;
        }

        $path = ltrim($this->video_url, '/');

        if (!str_starts_with($path, 'proyectos/')) {
            $path = 'proyectos/videos/' . $path;
        }

        return asset('storage/' . $path);
    }

    public function getDocumentosPublicAttribute(): array {
        if (empty($this->documentos) || !is_array($this->documentos)) {
            return [];
        }

        return collect($this->documentos)->map(function ($doc) {
            $path = ltrim($doc, '/');

            if (!str_starts_with($path, 'proyectos/')) {
                $path = 'proyectos/documentos/' . $path;
            }

            return [
                'name' => basename($path),
                'url'  => asset('storage/' . $path),
            ];
        })->toArray();
    }
}
