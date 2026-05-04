<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase Usuario
 * Autor: Charol Carrasco
 * Representa un usuario del sistema de selección de personal
 */
class Usuario extends Model
{
    protected $table = 'usuario';
    protected $primaryKey = 'rut_usuario';
    public $incrementing = false;

    protected $fillable = [
        'rut_usuario', 'nombre', 'apellido', 'email', 'password', 'rol'
    ];

    public $timestamps = false;

    // Relación con ofertas (si es reclutador)
    public function ofertas()
    {
        return $this->hasMany(OfertasLaborales::class, 'rut_usuario', 'rut_usuario');
    }

    // Relación con postulaciones (si es candidato)
    public function postulaciones()
    {
        return $this->hasMany(Postulacion::class, 'rut_candidato', 'rut_usuario');
    }
}
