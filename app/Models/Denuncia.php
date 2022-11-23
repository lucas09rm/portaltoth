<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denuncia extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'postagem_id',
        'analise',
        'ativo',
    ];
    
    use HasFactory;
}
