<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase Postulacion
 * Autor: Charol Carrasco
 * Representa la postulación de un candidato a una oferta laboral
 */
class Postulacion extends Model
{
    protected $table = 'postulaciones';
    protected $primaryKey = 'id_postulacion';
    public $incrementing = true;

    protected $fillable = [
        'id_oferta', 'rut_candidato', 'fecha_postulacion', 'estado', 'comentario', 'ultima_actualizacion'
    ];

    public $timestamps = false;

    // Relación inversa con oferta
    public function oferta()
    {
        return $this->belongsTo(OfertasLaborales::class, 'id_oferta', 'id_oferta');
    }
}
