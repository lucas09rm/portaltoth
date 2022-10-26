<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postagem extends Model
{
    protected $fillable = [
        'titulo',
        'texto',
        'ativo',
        'user_id',
        'tag_id',
        'imagem',
    ];

    use HasFactory;
}
