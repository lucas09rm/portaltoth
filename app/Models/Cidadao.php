<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cidadao extends Model
{
    protected $fillable = [
        'id',
        'estado_civil',
        'sexo',
        'data_moradia',
        'data_nascimento',
    ];

    use HasFactory;
}
