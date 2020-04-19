<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
     protected $fillable = [
        'tipo',
        'serviceskit',
        'cedula',
        'nombres',
        'apellidos',
        'departamento',
        'puesto',
        'localidad',
        'estado',
        'prioridad',
        'supervisor_email',
        'registrado_por',
        'modificado_por',
        'created_at',
        'updated_at'
    ];
}
