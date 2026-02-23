<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class JsonUnicode implements CastsAttributes {
  public function get(Model $model, string $key, mixed $value, array $attributes): mixed {
    if (empty($value)) {
      return [];
    }

    $decoded = json_decode($value, true);

    return is_array($decoded) ? $decoded : [];
  }

  public function set(Model $model, string $key, mixed $value, array $attributes): mixed {
    return json_encode($value, JSON_UNESCAPED_UNICODE);
  }
}
