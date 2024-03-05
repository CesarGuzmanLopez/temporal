<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

use App\Models\User;
use App\Models\RegUser;
use App\Models\RegRol;
use App\Models\RmmUsuarioCct;

use App\Http\Traits\MatriculaTrait;


class RegisterController extends Controller
{
    use MatriculaTrait;
    //Ver pagina de registro
    public function registration()
    {
        return view('auth.register');
    }

    //validacion del registro
    public function postRegistration(Request $request)
    {  
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|min:6|same:password',
        ]);

         //Validar si el correo introducido existe
          $email_unico = User::where('email', $request->email)->first();

        if(!$email_unico)
        {
          $data = $request->all();
          $check = $this->create($data);
          //dd($check);  

          //se ejecuta el evento Registered, que es el encargado de enviar el correo electrónico
          //event(new Registered($check));

          //envia el código de confirmación
          return redirect("login")->with('success',__('Hemos enviado un correo para validar tu cuenta de email.'));
        
        }else{
          return back()->with('fail',__('El email que intentas registrar ya ha sido ocupado.'));
        }
        
    }

     //Crear nuevo usuario
    public function create(array $data)
    {
      //dd($data);
      $data['confirmation_code'] = Str::random(25);
      $create_user = User::create([
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'confirmation_code' => $data['confirmation_code']
      ]);

      Mail::send('emails.confirmation_code', $data, function($message) use ($data) {
        $message->to($data['email'], $data['email'])->subject('Confirme su correo electrónico');
      });

      
      $register_user = RegUser::create([
        'correo' => $data['email'],
        'contrasenia_plataforma' => $data['password'],
        'usuario_id' => $create_user->id,//toma el id del usuario que se acaba de crear
      ]);

        return $create_user;
    }

    public function postEditPaso1(Request $request)
    {
      
      //BUSCA EN LA TABLA ent_registro EL USUARIO_ID
      $usuario = RegUser::where('usuario_id', $request->input('usuario_id'))->first();
      //dd($usuario);
      
      //ACTUALIZA LOS DATOS COMPLEMENTARIOS
      $usuario->nombres               = $request->input('first-name');
      $usuario->apellidos             = $request->input('last-name');
      $usuario->telefonomovillada     = $request->input('lada-phone');
      $usuario->telefonomovil         = $request->input('mobile-phone');
      $usuario->pais_id               = $request->input('country');
      $usuario->matricula             = $this->_generaMatricula($request->input('rol'),$request->input('usuario_id'));
      $usuario->terminos_condiciones  =  $request->input('privacy_policy');
      $usuario->save();
      //dd($request->input('usuario_id'));
      
      //BUSCA EN LA TABLA rmm_usuario_rol EL USUARIO_ID
      $rol = RegRol::where('usuario_id', $request->input('usuario_id'))->first();
      //dd($rol);
      
      if($rol){//SI EXISTE EL ROL, SE ACTUALIZA
        $rol->rol_id = $request->input('rol');
        $rol->save();

        return $rol;

      }else{//SI NO EXISTE EL ROL, SE CREA
        //dd($request->input('rol'));
        $register_rol = RegRol::create([
          'rol_id' => $request->input('rol'),
          'usuario_id' => $request->input('usuario_id'),
        ]);

        return $register_rol;

      }
      
    }

    public function postEditPaso2(Request $request)
    {
      
      //si el idcct existe
      if($request['id_cct'])
      {

        $register_cct= RmmUsuarioCct::create([//inserta registro nuevo cuando valida su cct
          'usuario_id' =>$request['usuario_id'],
          'cct_id' => $request['id_cct'],
          'estatus' => 1,
          'fechacreacion' =>now(),
        ]);
        //dd($usuario);
        $ent_registro = RegUser::where('usuario_id', $request->input('usuario_id'))->first();
        $ent_registro->completa_datos = 1;//Paso 2 completado
        $ent_registro->save();//se guarda el id en ent_registro

        return redirect()->route('assemble',['usuario_id'=>$request->input('usuario_id')]);
      }
      else//sino
      {
        return redirect()->route("dashboard")->with('fail','Hubo un problema al guardar el CCT');
      }
    }
    
  
}
