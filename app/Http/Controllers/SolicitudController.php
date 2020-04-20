<?php

namespace App\Http\Controllers;

use Illuminate\Http\Requestinput;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use responseresponseIlluminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\DB;

use App\Solicitud;
use App\Departamento;
use App\Localidad;
use Auth;
use App\user;


class SolicitudController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getSolicitudes(){
        return Solicitud::where('registrado_por',Auth::user()->username)->orderBy('created_at', 'desc')->get();
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

     public function infoSolicitud($id){

        return Solicitud::findOrFail($id);
     }

    public function postIngreso(Request $request)
    {   
        $this->validate($request, [
            'cedula' =>  'required',
            'primer_nombre' => 'required',
            'primer_apellido' => 'required',
            'departamento' => 'required',
            'puesto' => 'required',
            'localidad' => 'required',
            'supervisor' => 'required|email',
        ]);    

            
            
            
            $cedula =  $request['cedula'];
            $nombres = $request['primer_nombre'].' '.$request['segundo_nombre'];
            $apellidos = $request['primer_apellido'].' '.$request['segundo_apellido'];
            $puesto = $request['puesto'];
            $localidad = $request['localidad'];
            $supervisor_email = $request['supervisor'];
            // 'registrado_por' => Auth::user()->username ,
           
           $detalles_solicititud ='CEDULA :'.' '.$cedula.' | '.'NOMBRE :'.' '.$nombres.' '.$apellidos.' | '.'PUESTO :'.' '.$puesto.' | '.'SUPERVISOR :'.' '.$supervisor_email.' | '.'LOCALIDAD :'.' '.$localidad;


          $Urs ='http://servicekit.viva.com.do/servlets/RequestServlet?';
      

            // Parametros
            $query =[
                              
            'operation' => 'AddRequest',
            // VALIACION AL SISTEMA SISTEMA
            'username' => env('SERVICESKIT_USERNAME'),
            'password' => env('SERVICESKIT_PASSWORD'),
            // -------------------

            //  DATOS A COMPLETAR POR EL FORMULARIO   


            'requester' =>  Auth::user()->name,
            'createdby' =>  Auth::user()->name,
            // DESCRIPCION DE LA SOLICITUD 
                // DESCRIPCION DE LA SOLICITUD 
            'description' =>$detalles_solicititud ,

            // VALORES DE LA PLANTILLA
            // 'subject' => 'Solicitudes de Accesos y/o Administración de Empleados',
            'subject' => 'Creacion Nuevo Usuario de Dominio',
            'shortdescription' => '',
            'requesttemplate' => '2001 Accesos y Administracion de Usuarios',
            'service' => '002 Solicitudes de Empleados',
            'category' => 'Solicitudes De Acceso',
            'subcategory' => 'Administracion De Usuarios',
            'item' => 'Nuevo Usuario',
            'site' => 'Viva',
            'group'=> 'IT-OPS-STI',
            // 'technician' => 'sti', //--> Si coloco como tecnico STI esta ira intercambiando las solicitudes a los tecnicos disponnibles
            'technician' => 'Wilfredo Fermin Reyes',

            ];
 

            $response = (Http::retry(3, 100)->get($Urs, $query));

            $extraerEntero = preg_replace('/[^0-9]+/', '', $response);

            $resultado = Str::limit($extraerEntero, 5,''); 

        return Solicitud::create([
        
            'tipo' =>  1,
            'prioridad' =>'normal',
            'serviceskit' =>  $resultado,
            'cedula' =>  $request['cedula'],
            'nombres' => $request['primer_nombre'].' '.$request['segundo_nombre'],
            'apellidos' => $request['primer_apellido'].' '.$request['segundo_apellido'],
            'departamento' => $request['departamento'],
            'puesto' => $request['puesto'],
            'localidad' => $request['localidad'],
            'supervisor_email' => $request['supervisor'],
            'registrado_por' => Auth::user()->username ,
            'modificado_por' => Auth::user()->username , 
        ]);

        // return 'ok';
    }


    public function test()
    {
        
            // TRABAJANDO  CON GUZZLE 6
            // http://docs.guzzlephp.org/en/stable/request-options.html?highlight=format
   
        // $client = new Client([
                // Base URI is used with relative requests
        //         'base_uri' => 'http://servicekit.viva.com.do/servlets/RequestServlet?',
                // You can set any number of default request options.
        //             'timeout'  => 10.0,
                   
        //         ]);

        //         $response = $client->request('GET', 'http://servicekit.viva.com.do/servlets/RequestServlet?', ['query' =>  [
        //                         'operation' => 'GetRequestDetails',
        //                        // USURIOS DE ACCESO AL SISTEMA
                                    // 'username' => env('SERVICESKIT_USERNAME'),
                                    // 'password' => env('SERVICESKIT_PASSWORD'),
        //                         'workOrderID' => '35824',
                    
        //                         ]
        //         ]);
        //     dd(json_decode($response->getBody()->getContents()));

            // dd($response->getBody()->getContents());
            // dd($response->getBody());
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // TRABAJANDO CON CON EL CLIENTE HTTP DE LARAVEL
            // https://laravel.com/docs/7.x/http-client
  
            // Url base
            $Urs ='http://servicekit.viva.com.do/servlets/RequestServlet?';
     
            // Parametros
            $query =[
                                // ---Buscar
                                // 'operation' => 'GetRequestDetails',
                                // ---Agregar
                                'operation' => 'AddRequest',
                                // ---UpdateRequest
                                // 'operation' => 'UpdateRequest',
                                // ---Eliminar
                                // 'operation' => 'DeleteRequest',
                                // ---Agregar Nota
                                // 'operation'= >'AddNotes'


                                // USURIOS DE ACCESO AL SISTEMA
                                'username' => env('SERVICESKIT_USERNAME'),
                                'password' => env('SERVICESKIT_PASSWORD'),
                                // -------------------

                                //  DATOS A COMPLETAR POR EL FORMULARIO   
                               
                                'requester' =>  Auth::user()->name,
                                'createdby' =>  Auth::user()->name,
                                // DESCRIPCION DE LA SOLICITUD 
                                'description' =>'<pre>
                                                <h2 align="center">DETALLES DEL NUEVO USUARIO SOLICITADO</h2> 
                                                <DIV align="left">
                                                <hr style="width:65%;">
                                                | COMPLETO                  | <strong>Luis Gonzalez Matias</strong>                            
                                                | CEDULA O PASAPORTE        | <strong>001-152699-8</strong>                                    
                                                | PUESTO                    | <strong>Analista de Sistemas</strong>                            
                                                | DEPARTAMENTO              | <strong>Tecnologia</strong>                                      
                                                | SUPERVISOR                | <strong>Pablo Ortega Lopez</strong>                              
                                                | LOCALIDAD                 | <strong>Julio Verne</strong>                              
                                                <hr style="width:65%;">
                                                </DIV>
                                                 </pre>
                                                 ',

                                // VALORES DE LA PLANTILLA
                                // 'subject' => 'Solicitudes de Accesos y/o Administración de Empleados',
                                'subject' => 'Creacion Nuevo Usuario de Dominio',
                                'shortdescription' => '',
                                'requesttemplate' => '2001 Accesos y Administracion de Usuarios',
                                'service' => '002 Solicitudes de Empleados',
                                'category' => 'Solicitudes De Acceso',
                                'subcategory' => 'Administracion De Usuarios',
                                'item' => 'Nuevo Usuario',
                                'site' => 'Viva',
                                'group'=> 'IT-OPS-STI',
                                // 'technician' => 'sti', //--> Si coloco como tecnico STI esta ira intercambiando las solicitudes a los tecnicos disponnibles
                                'technician' => 'Wilfredo Fermin Reyes',

            ];


            $response = (Http::retry(3, 100)->get($Urs, $query));

            $extraerEntero = preg_replace('/[^0-9]+/', '', $response);

            $resultado = Str::limit($extraerEntero, 5,'');
           
            // $resultado = ereg_replace(“[^0-9]”, “”, $response);

            // $response->getStatusCode();

            // $response->headers(Http::retry(3, 100)->get($Urs, $query));
        //    dd ($resultado);
            // dd($response->getBody()->getContents());
            // dd(($response->getBody()->getContents()));

       
                // ($response->input('workOrderID'));

            
            //  dd()->json();

            //  $user = Auth::user()->name;
            // dd($user);

    }


}
