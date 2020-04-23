<?php

namespace App\Http\Controllers;

use Illuminate\Http\Requestinput;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use responseresponseIlluminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\DB;
use Adldap\Laravel\Facades\Adldap;
use Illuminate\Support\Arr;

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


    // ----------------------------------------------------------------------------------------------------
    // PATICIONES BASE DE DATOS LOCAL
    // ----------------------------------------------------------------------------------------------------
    public function getSolicitudes(){
        return Solicitud::where('registrado_por',Auth::user()->username)->orderBy('created_at', 'desc')->get();
   }
   
   public function getDepartamentos(){
       $departamento=Departamento::where('activo',true)->get();
        return response()->json($departamento);
   }

   public function getLocalidad(){
       return Localidad::latest()->get();
   }

   public function getPuestos(Request $request){
      return $puestos = DB::table('puestos')->where('departamento_id', '=',$request->departamento_id )->get();
   }

    public function infoSolicitud($id){

    return Solicitud::findOrFail($id);

    }


 // ----------------------------------------------------------------------------------------------------
 // PETICIONES AL ACTIVE DIRECTORY
 // ----------------------------------------------------------------------------------------------------
     public function getEmpleado(){

        //  dd(\Request::get('q'));

         if($buscar = \Request::get('q')){

       return  Adldap::search()->findByOrFail('samaccountname', $buscar);
        //  return Adldap::search()->where('userprincipalname', $buscar)->getQuery();
        //  return Adldap::findByDn($buscar,'dc=om,dc=do' );

        //  $search->findByDn('cn=John Doe,dc=corp,dc=org');
            
            // return $resultado->toJson();
         }

     }

// ----------------------------------------------------------------------------------------------------
// PATICIONES AL SESRVICEKIT - MANAGEENGINE
// ----------------------------------------------------------------------------------------------------

    public function postIngreso(Request $request)
    {   
        $this->validate($request, [
            'cedula' =>  'required',
            'primer_nombre' => 'required',
            'primer_apellido' => 'required',
            'departamento' => 'required',
            'puesto' => 'required',
            'localidad' => 'required',
            'supervisor' => 'required',
        ]);    

            // try {
               
            // ------------------------------------------------------
            // SERVICESKIT
            // ------------------------------------------------------
            // CONVERTIMOS LOS VALORES PARA PODER INCLUIRLO EN EL FORMULARIO
            $cedula =  $request['cedula'];
            $nombres = $request['primer_nombre'].' '.$request['segundo_nombre'];
            $apellidos = $request['primer_apellido'].' '.$request['segundo_apellido'];
            $nombrecompleto = $nombres.' '.$apellidos;
            $puesto = $request['puesto'];
            $localidad = $request['localidad'];
            $supervisor = $request['supervisor'];

            // ------------------------------------------------------
            // BUSQUEDA DE DATOS PARA GUARDAR EN LA TABLA DE SOLICITUDES
            // ------------------------------------------------------
            // BUSCAR POR EL ID EL DEPARTAMETNO
            //  $departamento = $request['departamento'];
            $buscar_departamento = Departamento::findOrFail($request['departamento']);
            $departamento = $buscar_departamento -> nombre ;

            // // BUSCAR EL NOBRE DE SUPERVISOR EN EL ACTIVE DIRECTORY
            $buscar_supervisor = Adldap::search()->findByOrFail('samaccountname',$request['supervisor']);
            // $buscar_supervisor = Adldap::search()->findByOrFail('userprincipalname',  $request['supervisor']);
             $supervisor_nombre = Arr::first($buscar_supervisor->name);
            


            // $supervisor_email = $request['supervisor'];
            // 'registrado_por' => Auth::user()->username ,
           
            $detalles_solicititud ='CEDULA :'.' '.$cedula.' | '.'NOMBRE :'.' '.$nombrecompleto.' | '.'PUESTO :'.' '.$puesto.' | '.'DEPARTAMENTO :'.''.$departamento.' | '.'LOCALIDAD :'.' '.$localidad.' | '.'SUPERVISOR :'.' | '.$supervisor_nombre ;
            $subject = 'NUEVO INGRESO :'.' '.$nombrecompleto; 
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
            'subject' => $subject ,
            'shortdescription' => $supervisor_nombre,
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
            // AQUI OPTENEMOS LA RESPUESTA RECIBIDA DEL SERVIDOR - SERVICESKT
            $response = (Http::retry(3, 100)->get($Urs, $query));

            // DEBIDO A QUE EL RESULTADO VIEN DENTRO DE UNA CADENA, DEBEMOS SACAR ESE VALOR
            $extraerEntero = preg_replace('/[^0-9]+/', '', $response);
            // DEBIDO A QUE EL VALOR SE REPITE, LIMITAMOS
            $serviceskit_id = Str::limit($extraerEntero, 5,''); 

            // DESPUES DE OBTENER EL RESULTADO LO ASIGNAMOS CON EL CODIGO DE SERVICESKIT MAS ABAJO

                return Solicitud::create([
                    'tipo' =>  1,
                    'prioridad' =>'normal',
                    'serviceskit' =>  $serviceskit_id,
                    'identidad' =>   $cedula,
                    'nombres' => $nombres,
                    'apellidos' => $apellidos,
                    'nombre_completo' =>$nombrecompleto,
                    'departamento' => $departamento,
                    'puesto' => $puesto,
                    'localidad' => $localidad,
                    'supervisor' => $supervisor_nombre,
                    'registrado_por' => Auth::user()->username ,
                    'modificado_por' => Auth::user()->username , 
                ]);


        // } catch (\Exception $e) {

        //     return 'No se pudo completar';
            
        //     }

    }


    public function deleteSalida($id)
        {
          
            // BUSCAR EL NOBRE DE SUPERVISOR EN EL ACTIVE DIRECTORY
            $empleado = Adldap::search()->findByOrFail('samaccountname', $id);

            // Arr::first -> Obtengo el primaer valor de una matriz
            $usuario = Arr::first($empleado->samaccountname);
            $nombrecompleto = Arr::first($empleado ->name);
            $puesto = Arr::first($empleado ->description) ;
            $departamento = Arr::first($empleado ->department);
            $localidad = Arr::first($empleado->physicaldeliveryofficename) ;
            $supervisor_nombre = Arr::first($empleado ->manager);
            $correo_electronico = Arr::first($empleado -> userprincipalname);
            $telefono = Arr::first($empleado ->telephonenumber);

            // ENVIO DE DATOS A SERVICESKIT
            

            // $supervisor_email = $request['supervisor'];
            // 'registrado_por' => Auth::user()->username ,
           
            $detalles_solicititud ='USUARIO:'.' '.$usuario.' | '.'NOMBRE :'.' '.$nombrecompleto.' | '.'PUESTO :'.' '.$puesto.' | '.'DEPARTAMENTO :'.''.$departamento.' | '.'LOCALIDAD :'.' '.$localidad;
            $subject = 'SALIDA DE EMPLEADO :'.' '.$nombrecompleto; 
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
            'subject' => $subject ,
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
            // AQUI OPTENEMOS LA RESPUESTA RECIBIDA DEL SERVIDOR - SERVICESKT
            $response = (Http::retry(3, 100)->get($Urs, $query));

            // DEBIDO A QUE EL RESULTADO VIEN DENTRO DE UNA CADENA, DEBEMOS SACAR ESE VALOR
            $extraerEntero = preg_replace('/[^0-9]+/', '', $response);
            // DEBIDO A QUE EL VALOR SE REPITE, LIMITAMOS
            $serviceskit_id = Str::limit($extraerEntero, 5,''); 

            // DESPUES DE OBTENER EL RESULTADO LO ASIGNAMOS CON EL CODIGO DE SERVICESKIT MAS ABAJO

                return Solicitud::create([
                    'tipo' =>  2,
                    'prioridad' =>'alta',
                    'serviceskit' =>  $serviceskit_id,
                    'identidad' => $usuario,
                    'nombre_completo' =>$nombrecompleto,
                    'departamento' => $departamento,
                    'correo_electronico' => $correo_electronico,
                    'telefono' => $telefono,
                    'puesto' => $puesto,
                    'localidad' => $localidad,
                    'supervisor' => $supervisor_nombre,
                    'registrado_por' => Auth::user()->username ,
                    'modificado_por' => Auth::user()->username , 
                ]);
            
        }

    public function postSalida(Request $request)
    {   
            // CONVERTIMOS LOS VALORES PARA PODER INCLUIRLO EN EL FORMULARIO
            $usuario =  $request['salida_usuario'];
            $nombrecompleto = $request['salida_Nombres'];
            $puesto = $request['salida_puesto'];
            $localidad = $request['salida_localidad'];
            $supervisor_email = $request['salida_supervisor'];
            // 'registrado_por' => Auth::user()->username ,
           
            $detalles_solicititud ='USUARIO :'.' '.$usuario.' | '.'NOMBRE :'.' '.$nombrecompleto.' | '.'PUESTO :'.' '.$puesto.' | '.'SUPERVISOR :'.' '.$supervisor.' | '.'LOCALIDAD :'.' '.$localidad;
            $subject = 'SALIDA DE EMPLEADO :'.' '.$nombrecompleto; 

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
            'subject' => $subject ,
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
            // AQUI OPTENEMOS LA RESPUESTA RECIBIDA DEL SERVIDOR - SERVICESKT
            $response = (Http::retry(3, 100)->get($Urs, $query));

            // DEBIDO A QUE EL RESULTADO VIEN DENTRO DE UNA CADENA, DEBEMOS SACAR ESE VALOR
            $extraerEntero = preg_replace('/[^0-9]+/', '', $response);
            // DEBIDO A QUE EL VALOR SE REPITE, LIMITAMOS
            $resultado = Str::limit($extraerEntero, 5,''); 
            // DESPUES DE OBTENER EL RESULTADO LO ASIGNAMOS CON EL CODIGO DE SERVICESKIT MAS ABAJO
        return Solicitud::create([
            'tipo' =>  2,
            'prioridad' =>'alta',
            'serviceskit' =>  $resultado,
            'identidad' =>  $request['identidad'],
            'nombres' => $request['primer_nombre'].' '.$request['segundo_nombre'],
            'apellidos' => $request['primer_apellido'].' '.$request['segundo_apellido'],
            'nombre_completo' => $request['primer_nombre'].' '.$request['segundo_nombre'].' '.$request['primer_apellido'].' '.$request['segundo_apellido'],
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
        

            // ACTIVE DIRECTORY FUNCIONALIDADES


                // username' => 'samaccountname',
                // 'name' => 'cn',
                // 'apellidos' => 'sn',
                // 'nombres' => 'givenname',
                // 'correo' => 'userprincipalname',
                // 'puesto' => 'title',
                // 'departamento' => 'department',
                // 'oficina' => 'physicaldeliveryofficename',
                // 'supervisor' => 'manager',
                // 'compania' => 'company',
                // 'telefono' => 'telephonenumber',

            // $users = $this->ldap->search()->users()->get();
            // $user = Adldap::search()->users()->find('wfermin');
            // $search->select(['cn', 'samaccountname', 'telephone', 'mail']);
            // admwfermin@om.do



            

            $buscar_supervisor = Adldap::search()->findByOrFail('samaccountname','uprueba');

            $first = Arr::first($buscar_supervisor->name);
            // $buscar_supervisor = Adldap::search()->findByOrFail('userprincipalname',  $request['supervisor']);
           dd($empleado);

            //  $results = Adldap::search()->find('admwfermin');
                        // Adldap::search()->findByOrFail('samaccountname',  $request['supervisor'])->select('name');
            //  $buscarfirst_departamento = Departamento::findOrFail(3);

            //  $results = Adldap::search()->findByOrFail('userprincipalname', 'admwfermin@om.do');

            // dd($buscar_departamento->nombre);

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
