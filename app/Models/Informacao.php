<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informacao extends Model
{
    protected $fillable = [
        'tag_id',
        'user_id',
        'texto',
        'titulo',
        'imagem',
    ];

    use HasFactory;
}
