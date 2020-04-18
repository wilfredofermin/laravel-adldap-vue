<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Solicitud;
use App\Departamento;
use App\Localidad;

use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    //

 public function getSolicitudes(){

       $getSolicitudes=Solicitud::latest()->get();
        return response()->json($getSolicitudes);
   }
   
   public function getDepartamentos(){

       $departamento=Departamento::where('status',true)->get();
        return response()->json($departamento);
   }

   public function getLocalidad(){

       $localidad=Localidad::latest()->get();
        return response()->json($localidad);
   }


   public function getPuestos(Request $request){
      // $puestos = Puesto::where(departamento_id, 3)->get();

      // return $puestos = DB::table('puestos')->where('departamento_id', '=',3 )->get();
      return $puestos = DB::table('puestos')->where('departamento_id', '=',$request->departamento_id )->get();

   }

}
