<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
     protected $fillable = [
        'tipo',
        'serviceskit',
        'identidad',
        'nombres',
        'nombre_completo',
        'apellidos',
        'departamento',
        'puesto',
        'localidad',
        'correo_electronico',
        'telefono',
        'nota',
        'estado',
        'prioridad',
        'supervisor',
        'solicitante_usuario',
        'solicitante_nombre', 
        'modificado_por',
        'created_at',
        'updated_at'
    ];

    // protected $primaryKey = 'identidad';
}
