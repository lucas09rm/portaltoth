<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denuncia extends Model
{
    protected $fillable = [
        'id',
        'data_chegada',
        'data_inauguracao',
        'resumo',
    ];
    
    use HasFactory;
}
