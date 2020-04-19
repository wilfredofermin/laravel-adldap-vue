<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Solicitud;
use App\Departamento;
use App\Localidad;
use Auth;
use App\user;
use Illuminate\Http\Request;

class SolicitudController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getSolicitudes(){
     $getSolicitudes=Solicitud::where('registrado_por',Auth::user()->username)->get();
        return response()->json($getSolicitudes);
    //    $getSolicitudes=Solicitud::latest()->get();
    //     return response()->json($getSolicitudes);

   }
   
   public function getDepartamentos(){

       $departamento=Departamento::where('activo',true)->get();
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

    public function postIngreso(Request $request)
    {   
        $this->validate($request, [
            'cedula' =>  'max:11|min:11',
            'primer_nombre' => 'required|max:30',
            'primer_apellido' => 'required|max:30',
            'departamento' => 'required',
            'puesto' => 'required',
            'localidad' => 'required',
            'supervisor' => 'required|email',
        ]);

        return Solicitud::create([
        
            'tipo' =>  1,
            'prioridad' =>'normal',
            'serviceskit' =>  20212,
            'cedula' =>  $request['cedula'],
            'nombres' => $request['primer_nombre'].' '.$request['segundo_nombre'],
            'apellidos' => $request['primer_apellido'].' '.$request['segundo_apellido'],
            'departamento' => $request['departamento'],
            'puesto' => $request['puesto'],
            'localidad' => $request['localidad'],
            'supervisor_email' => $request['supervisor'],
            'registrado_por' => Auth::user()->username ,
            'modificado_por' => '', 
        ]);

        // return 'ok';
    }


    // DB::table('solicituds')->insert([
    //         'Tipo' => '1',
    //         'serviceskit' => '20206',
    //         'cedula' => '00112960026',
    //         'nombres' =>'Pedro B.',
    //         'apellidos' => 'Lopez Bermudez',
    //         'departamento' =>'Tecnologia',
    //         'puesto' => 'Programador',
    //         'localidad' => 'Julio Verne',
    //         'prioridad' =>'normal',
    //         'supervisor_email'     => 'smardonado@viva.com.do',
    //         'registrado_por'     => 'uprueba',
    //         'modificado_por'     => '', 
           
    //     ]);


}
