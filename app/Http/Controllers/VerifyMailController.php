<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\RegUser;
use Illuminate\Support\Facades\Hash;

class VerifyMailController extends Controller
{
    public function verify($code)
    {
        $user = User::where('confirmation_code', $code)->first();

        if (! $user){
            return redirect('login')->with('success', __('El correo electrónico ya ha sido validado'));
        }else{
            $user->email_verified_at = now();
            $user->confirmation_code = null;
            $user->save();
            return redirect('login')->with('success', __('El correo electrónico ha sido confirmado correctamente'));
        }
    }

    public function recuperaPassword(Request $request){

        $valida = $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email',  $request->email)->first();

        if(!$user){
            return redirect('/password/reset')->with('fail', __('El correo electrónico no existe en nuestro registros'));
        }else{
            $user->email_verified_at = NULL;
            $data['email'] = $request->email;
            $data['confirmation_code'] = Str::random(25);
            $user->confirmation_code = $data['confirmation_code'];
            $user->save();
            Mail::send('emails.recupera_code', $data, function($message) use ($data) {
            $message->to($data['email'] , $data['email'] )->subject('Recupera contraseña');
            });
            return redirect('login')->with('success', __('Hemos enviado un correo para reestablecer su contraseña'));
        } 
    }

    public function introducePassword($code){
        $user = User::where('confirmation_code', $code)->first();
        if(!$user){
            return back()->with('fail', __('Error al actualizar contraseña'));
        }else{
            $email = $user->email;
            return view('auth.passwords.reset',compact("code","email"));
        }
    }

    public function savePassword(Request $request){
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|min:6|same:password',
        ]);
        $email = $request->email;
        $password = $request->password;
        $code =  $request->code;
        $user = User::where('email', $email)->where('confirmation_code',$code)->first();

        if(!$user){
            return back()->with('fail', __('El código de activación ha sido ocupado o caducado.'));
        }else{

            $user -> password = Hash::make($password);
            $user -> email_verified_at = now();
            $user -> confirmation_code = null;
            $user -> save();

            $registro = RegUser::where('correo', $email)->first();
            //dd($registro);
            $registro -> contrasenia_plataforma = $password;
            $registro -> save();

            $actualiza_appcastillo = $this->cambia_password_appcastillo($email,$password);
            return redirect('login')->with('success', __('La nueva contraseña ha sido creada correctamente'));
        }

    }

    
    public function cambia_password_appcastillo($email,$password){
        $existe_usuario = $this->_valida_correo_appcastillo($email);

        if($existe_usuario == true){
            $updateAppCastillo = DB::connection('mysql_2')->table('tusuario')->where('usuario', $email)
            ->update([
                'password' =>md5($password),
                'habilitado' =>1,
                'activado' =>1,
            ]);
            return true;
        }else{
            return false;
        }
    }

    public function _valida_correo_appcastillo($email){
        $usuarioAppCastillo = DB::connection('mysql_2')->select("SELECT * FROM tusuario where usuario='".$email."'");
        if (!$usuarioAppCastillo){
            return false;
        }else{
            return true;
        }
    }

}
