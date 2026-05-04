<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase Candidato
 * Autor: Charol Carrasco
 * Representa información adicional de un candidato
 */
class Candidato extends Model
{
    protected $table = 'candidato';
    protected $primaryKey = 'rut_cantidado';
    public $incrementing = false;

    protected $fillable = [
        'rut_cantidado', 'nombre', 'apellido', 'email', 'profesion'
    ];

    public $timestamps = false;
}
