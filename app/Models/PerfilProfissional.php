<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilProfissional extends Model
{
    protected $fillable = [
        'user_id',
        'profissao',
        'area',
        'escolaridade',
        'disponivel',
        'texto',
    ];

    use HasFactory;
}
