<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    protected $fillable = [
        'id',
        'data_moradia',
        'data_nascimento',
    ];

    use HasFactory;
}
