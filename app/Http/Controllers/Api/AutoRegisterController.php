<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\CatCct;
use App\Models\RegRol;
use App\Models\RegUser;
use App\Models\AutoRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\MatriculaTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class AutoRegisterController extends Controller
{
    use MatriculaTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $email_unico = User::where('email', $request->email)->first();
        
        if(!$email_unico){
              return response()->json([
                'message' => 1,
                'error' => false,
            ], 200);
        }else{
            return response()->json([
                'message' => 2,
                'error' => false
            ], 200);
        }

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $create_user = AutoRegister::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'email_verified_at' => date('Y-m-d H:i:s')
          ]);
    
          
        $register_user = RegUser::create([
        'correo' => $data['email'],
        'contrasenia_plataforma' => $data['password'],
        'usuario_id' => $create_user->id,//toma el id del usuario que se acaba de crear
        ]);

        //$idCCT = CatCct::where('clave_centro_trabajo',$data['CCT'])->first();
        //$idCCT = DB::table('cat_cct')->get();
        $idCCT = DB::table('cat_cct')->where('clave_centro_trabajo', $data['CCT'])->first();
        
      
        if($idCCT){
            $usuario = RegUser::where('usuario_id',$create_user['id'] )->first();
            $usuario->nombres               = $data['nombres'];
            $usuario->apellidos             = $data['apellidos'];
            $usuario->telefonomovillada     = $data['lada'];
            $usuario->telefonomovil         = $data['telefono'];
            $usuario->pais_id               = $data['pais'];
            $usuario->matricula             = $this->_generaMatricula($data['rol'],$create_user['id']);
            $usuario->terminos_condiciones  =  1;
            $usuario->cct_id = $idCCT->id;
            $usuario->completa_datos = 1;
            $usuario->save();
    
            $rol = RegRol::where('usuario_id', $create_user['id'])->first();
            if($rol){//SI EXISTE EL ROL, SE ACTUALIZA
                $rol->rol_id = $data['rol'];
                $rol->save();
        
                return $rol;
        
              }else{//SI NO EXISTE EL ROL, SE CREA
                //dd($request->input('rol'));
                $register_rol = RegRol::create([
                  'rol_id' => $data['rol'],
                  'usuario_id' => $create_user['id'],
                ]);
            }
    
            return response()->json([
            'message' => $create_user,
            'error' => false
            ], 200);
        }else{
            return response()->json([
                'message' => 'Clave CCT incorrecta',
                'error' => true
                ], 200);
        }

       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AutoRegister  $autoRegister
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
        $email = $request->email;
        $password = $request->password;

        $credentials['email'] = $email;
        $credentials['password'] = $password;
      
        
        if (Auth::attempt($credentials)) {
            
            $user = DB::select("CALL sp_autenticado('".$email."')");
		
	    //$user_registro = DB::select("SELECT * FROM ent_registro WHERE usuario_id = ". $user[0]->eu_id."");
            //dd($user2);
            Session::put('user',$user);
            // dd($request->session()->get('user'));
            dd(Session::all());
            //return view('home');
            if($user[0]->completa_datos == 1){//si ya completo sus datos, se va directamente al dashboard
                
                // return redirect()->route('assemble',['usuario_id'=>$user[0]->eu_id]);
                // return redirect()->route('assemble',[$user[0]->usuario_cct_id]);
            
            }else{//de lo contrario se va a completar datos
                //dd("No pasamos");
                return redirect()->intended('home');
            }
           
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AutoRegister  $autoRegister
     * @return \Illuminate\Http\Response
     */
    public function edit(AutoRegister $autoRegister)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AutoRegister  $autoRegister
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AutoRegister $autoRegister)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AutoRegister  $autoRegister
     * @return \Illuminate\Http\Response
     */
    public function destroy(AutoRegister $autoRegister)
    {
        //
    }
	
	public function guestSignUp(Request $request)
    {
        $data = $request->all();

        $create_user = AutoRegister::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'email_verified_at' => date('Y-m-d H:i:s')
          ]);
    
          
        $register_user = RegUser::create([
        'correo' => $data['email'],
        'contrasenia_plataforma' => $data['password'],
        'usuario_id' => $create_user->id,//toma el id del usuario que se acaba de crear
        ]);

        //$idCCT = CatCct::where('clave_centro_trabajo',$data['CCT'])->first();
        //$idCCT = DB::table('cat_cct')->get();
        $idCCT = DB::table('cat_cct')->where('clave_centro_trabajo', $data['CCT'])->first();
        
      
        if($idCCT){

            $bytes = openssl_random_pseudo_bytes(16);
            $tokenAcceso = str_replace(array('+', '/'), array('-', '_'), base64_encode((openssl_random_pseudo_bytes(16))));

            $usuario = RegUser::where('usuario_id',$create_user['id'] )->first();
            $usuario->nombres               = $data['nombres'];
            $usuario->apellidos             = $data['apellidos'];
            $usuario->telefonomovillada     = $data['lada'];
            $usuario->telefonomovil         = $data['telefono'];
            $usuario->pais_id               = $data['pais'];
            $usuario->matricula             = $this->_generaMatricula($data['rol'],$create_user['id']);
            $usuario->terminos_condiciones  =  1;
            $usuario->cct_id = $idCCT->id;
            $usuario->completa_datos = 1;
            $usuario->tokenredessociales = $tokenAcceso;
            $usuario->save();
    
            $rol = RegRol::where('usuario_id', $create_user['id'])->first();
            if($rol){//SI EXISTE EL ROL, SE ACTUALIZA
                $rol->rol_id = $data['rol'];
                $rol->save();
        
                return $rol;
        
              }else{//SI NO EXISTE EL ROL, SE CREA
                //dd($request->input('rol'));
                $register_rol = RegRol::create([
                  'rol_id' => $data['rol'],
                  'usuario_id' => $create_user['id'],
                ]);
            }
    
            return response()->json([
            'message' => 'https://devservicios.edicionescastillo.com/api/guestLogin/'.$tokenAcceso,
            'error' => false
            ], 200);
        }else{
            return response()->json([
                'message' => 'Clave CCT incorrecta',
                'error' => true
                ], 200);
        }
       
    }
	
	public function guestLogin(Request $request)
    {
        //
        $token = $request->token;

        $guest_user = RegUser::where('tokenredessociales', $token)->first();

        if ($guest_user){

            $email= $guest_user->correo;
            
            if (Auth::loginUsingId($guest_user->usuario_id)) {
                
                $user = DB::select("CALL sp_autenticado('".$email."')");
            
            
            //$user_registro = DB::select("SELECT * FROM ent_registro WHERE usuario_id = ". $user[0]->eu_id."");
                //dd($user2);
                Session::put('user',$user);
                //dd(Session::all());
                //return view('home');
                if($user[0]->completa_datos == 1){//si ya completo sus datos, se va directamente al dashboard
                    
                    // return redirect()->route('assemble',['usuario_id'=>$user[0]->eu_id]);

                    if (Auth::check()) {
                        echo 'The user is logged in...';
                    }
            
                    $user = Auth::user();
                    dd($user);
                    return 'listo';
                
                }else{//de lo contrario se va a completar datos
                    //dd("No pasamos");
                    return redirect()->intended('home');
                }
            
            }
        }
        else{
            return redirect()->route('login');
        }
    }
	
	public function test(Request $request)
    {
        
        if (Auth::check()) {
            echo 'The user is logged in...';
        }

        $user2 = Auth::user();
		$user = $request->user('api');
        print_r($user);
        print_r($user2);
		return 'listo';
	}

    public function ssoPromocion(Request $request)
    {
        
        return $request->email;

        
	}

}
