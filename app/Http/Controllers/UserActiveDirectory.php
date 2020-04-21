<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\UserRepository;
use App\Mail\email;
use App\Mail\MyTestMail;
use PDF;
use Mail;


class UserActiveDirectory extends Controller
{

    public function conn(){

         //----------------------------------------------------
        # CONFIGURACION DE LA CONEXION
        //----------------------------------------------------

       $ad = new \Adldap\Adldap();
        // Create a configuration array.
        $config = [  

        'hosts'    => ['cabuya.om.do', '192.168.1.1'],
        'base_dn'  => 'dc=om,dc=do',
        'username' => 'admwfermin@om.do',
        'password' => '@Amado6998849',

        ];

        // Add a connection provider to Adldap.
        $ad->addProvider($config);
         return $provider = $ad->connect();
        // ----------------------------------------------
            
    }

   /* Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request )
    {
        
        $cn = $this->conn();
        // Retrieve all users (Adldap\Models\User).
        //$results = $search->users()->get();
        $userAD = $cn->search()->find('wfermin');

        // $results = $search->whereHas('cn')->sortBy('cn', 'asc')->paginate(25);

        //$user = $provider->search()->find('ADTest7');

        dd($userAD->getManager());

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear()
    {
        //INICIAMOS LA CONEXION
        $cn = $this->conn();

        //----------------------------------------------------
        //DESANTIVAR USUARIO
        //----------------------------------------------------
        $userAD = $cn->make()->user([
            'cn' => 'ADTest7',
            'samaccountname' =>'ADTest7',
            'sn' => 'Test',
            'givenname' => 'Usr AD7',
            'userprincipalname' =>'ADTest7@viva.com.do',     
            //'base_dn' => 'dc=corp,dc=acme,dc=org'
        ]);     
            //ATRIBUTOS | Cambio el estado (512 - Activo | 514 - Desactivo)

            //POR DEFECTO, EL NUEVO USUARIO SE CREA DESACTIVO
            $userAD ->useraccountcontrol ='544'; // Inicializo el estado para poder cambiarlo
      
            //ASIGNAACION DE LOS ATRIBUTOS    
            $userAD->setFirstAttribute('displayname', 'Juan Perez Martinez');
            $userAD->setFirstAttribute('company', 'Trilogy Dominicana, VIVA');
            $userAD->setFirstAttribute('mail', 'jdoe8@viva.com.do');
            $userAD->setFirstAttribute('department', 'TECNOLOGIA');
            $userAD->setFirstAttribute('description', 'Soporte IT');
            $userAD->setFirstAttribute('title', 'USUARIO DE PRUEBA');
            $userAD->setFirstAttribute('physicaldeliveryofficename', 'PASTEUR');
          
            //ASIGNACION DEL SUPERVISOR ----------------------
            //Buscamos a quien sera el supervisor
            $manager = $cn->search()->find('wfermin');
            //Una vez tenidos el usuario, hacemos al asignacion
            $userAD->setFirstAttribute('manager', $manager);
            //ASIGNACION DEL SUPERVISOR ----------------------

            //VERIFICAR SI EXISTE - si existe retorna falso   
            $userAD->exists; // Returns false.
                   
            if ($userAD->save()) {
            //Una vez confirmado, activamos al usuario
            $userAD ->useraccountcontrol ='512';

              //ENVIAR CORREO DE CREACION
            //   $data['title'] = "NUEVO USUARIO CREADO";
            //   Mail::send('emails.nuevo-usuario', $data, function($message) {
            //     $message->to('wfermin@viva.com.do', 'Receiver Name')
            //             ->subject('Confirmacion de creacion del nuevo usuario');

                    //Mail::to('wfermin@viva.com.do')->send(new email)

                    //$content = PDF::loadView('emails/vista-pdf',compact('userAD'))->output();
 
                    //Storage::disk('public')->put('mi-archivo.pdf', $content);

                
                      
                        // $pdf = PDF::loadView('emails/vista-pdf', compact('userAD'));
                        // $pdf = PDF::loadView('emails/pdf2', compact('userAD'))->setPaper('a4', 'landscape');
                        // return $pdf->download('disney.pdf');
                

                    Mail::to('wfermin@viva.com.do')->send(new \App\Mail\EmailNuevoUser($userAD));
                    // Mail::to('wilfredoferminreyes@gmail.com')->send(new \App\Mail\EmailNuevoUser($userAD));
                   
                   // dd(Mail);

               $userAD->exists; // Returns true.
              };
       
            //   if (Mail::failures()) {
            //      return response()->Fail('Sorry! Please try again latter');
            //    }else{
            //      return response()->success('Great! Successfully send in your mail');
            //    }

           


            dd($userAD->getManager()); 
    

       // dd(($user->getDirty())); // Atributo modificado   

}
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    // public function show($id)
    {
        //

        $cn = $this->conn();
        $userAD = $cn->search()->find('wfermin');

        Mail::to('wfermin@viva.com.do')->send(new \App\Mail\EmailNuevoUser($userAD));

        return redirect('/');

        // dd($userAD->getOriginal()['cn']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function desactivar()
    {
         //INICIAMOS LA CONEXION
         $cn = $this->conn();
        //----------------------------------------------------
        //DESANTIVAR USUARIO
        //----------------------------------------------------

        //Buscarmos el usuario 
        $userAD = $cn->search()->find('ADTest7');     
        //Cambio el estado
        $userAD->updateAttribute('useraccountcontrol','514');
        //Denegamos el acceso
        $userAD->updateAttribute('logonhours',"\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00");
        //Lo muevo a la OU correspondiente
        $newParentOu = $cn->search()->ous()->find('Disabled Accounts');
        $userAD->move($newParentOu);
        //Actualizamos
        $userAD ->update();
        
        dd($userAD->getAttributes());
    }

    public function imprimir(){
          //INICIAMOS LA CONEXION
            $cn = $this->conn();
           //Buscarmos el usuario 
            $userAD = $cn->search()->find('ADTest7');  
            $userAD = PDF::loadView('vista-pdf', $userAD)->save(storage_path('app/public/') . 'archivo.pdf');
    
        // return $pdf->stream('usuario.pdf');
        
   }
    


}
