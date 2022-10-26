<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaga extends Model
{
    protected $fillable = [
        'titulo',
        'profissao',
        'texto',
        'area',
        'tag_id',
        'user_id',
        'imagem',
    ];
    
    use HasFactory;
}
