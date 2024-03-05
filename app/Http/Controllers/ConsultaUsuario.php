<?php

namespace App\Http\Controllers;

use App\Models\CatCct;
use App\Models\CatRol;
use App\Models\EntUsuario;
use App\Models\EntRegistro;
use Illuminate\Http\Request;
use App\Models\RmmUsuarioCct;
use App\Models\RmmUsuarioRol;
use App\Http\Traits\AdminTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Spatie\SimpleExcel\SimpleExcelWriter;
use App\Http\Controllers\VerifyMailController;

class ConsultaUsuario extends Controller
{

    use AdminTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){


        $data['roles'] = CatRol::all();
        $data['query2'] = 0;

        return view('consulta_usuario',$data);
    }

    public function editarUsuarioDatos($usuario_id, $cct_actual){


        
        $usuario_registro= EntRegistro::where('usuario_id', $usuario_id)->first();
        $cctUsuario =  DB::select("CALL sp_cctUsuario('".$usuario_id."');");
        
        //dd($usuario_registro);
        
        $usuarioData['id'] = $usuario_registro->id;
        $usuarioData['nombres'] = $usuario_registro->nombres;
        $usuarioData['apellidos'] = $usuario_registro->apellidos;
        $usuarioData['pais'] = $usuario_registro->pais_id;
        $usuarioData['telefono'] = $usuario_registro->telefonomovil;
        $usuarioData['matricula'] = $usuario_registro->matricula;
        $usuarioData['path_photo'] = $usuario_registro->path_photo;
        $usuarioData['cctUsuario'] = $cctUsuario;

        $id= $usuario_registro->id;
        $nombres= $usuario_registro->nombres;
        $apellidos = $usuario_registro->apellidos;
        $pais= $usuario_registro->pais_id;
        $telefono= $usuario_registro->telefonomovil;
        $matricula= $usuario_registro->matricula;
        $path_photo= $usuario_registro->path_photo;
        $cct_actual = $cct_actual;
       
        

        return view('editar_usuario',compact('cctUsuario','id','nombres','apellidos','pais','telefono','matricula','path_photo','cct_actual'));
        //return view("editar_usuario", compact('usuario_id','usuarioData'));
    }

    /*
    function base64_to_jpeg( $base64_string, $output_file ) {
        $ifp = fopen( $output_file, "wb" ); 
        fwrite( $ifp, base64_decode( $base64_string) ); 
        fclose( $ifp ); 
        return( $output_file ); 
    }*/

    function base64_to_jpeg($base64_string, $output_file) {
        // open the output file for writing
        $ifp = fopen( $output_file, 'wb' ); 
    
        // split the string on commas
        // $data[ 0 ] == "data:image/png;base64"
        // $data[ 1 ] == <actual base64 string>
        $data = explode( ',', $base64_string );
    
        // we could add validation here with ensuring count( $data ) > 1
        fwrite( $ifp, base64_decode( $data[ 0] ) );
    
        // clean up the file resource
        fclose( $ifp ); 
    
        return $output_file; 
    }
    
    

    public function editarFotoUsuario(Request $request){

        session()->forget('photoPerfil');
        $id = $request->idUsuarioEdit;
        $matricula = $request->matriculaEdit;
       
        //$imagen = $request->file('imagen');
        
        /*
        $bin = base64_decode($request->bl);
        $size = getimagesizefromstring($bin);*/

        $img = $request->bl;
        $img = str_replace('data:image/png;base64,', '', $request->bl);
        $data = base64_decode($img);

        $nombreImagen = $matricula."."."png";
        
        $imagenServidor = Image::make($data);
        $imagenPath = public_path('app-assets/images/profile/user-uploads').'/'.$nombreImagen;
        $imagenServidor->save($imagenPath);

        
       
        
        
        $usuario= EntRegistro::where('id', $id)->first();
        $usuario -> path_photo = $nombreImagen;
        $usuario -> save();

        session(['photoPerfil' => $nombreImagen]);
        return back()->with('success',__('Datos del usuario se han actualizado'));
   
    }


    public function searchUsuario(Request $request){

        $tipo_consulta = $request->usuario_completo;


        if($tipo_consulta == 1){
            
                $query2 = RmmUsuarioCct::with('ent_usuario', 'cct')
                ->where('estatus',1)


                ->whereHas('ent_usuario',function($q) use ($request){
                    if(!empty($request->email)){
                        //dd($request->serie);
                            $q->where('email',$request->email);
                    }
                    if(!empty($request->nombre)){
                        //dd($request->serie);
                        $q->whereHas('registro',function($q) use ($request){
                            $q->where('nombres',$request->nombre);
                        });
                    }

                    if(!empty($request->apellidos)){
                        //dd($request->serie);
                        $q->whereHas('registro',function($q) use ($request){
                            $q->where('apellidos',$request->apellidos);
                        });
                    }

                    if(!empty($request->rol)){
                        //dd($request->serie);
                        $q->whereHas('user_rol',function($q) use ($request){
                            $q->whereHas('rol',function($q) use ($request){
                                $q->where('id',$request->rol);
                            });
                        });
                    }

                })
                ->with(['ent_usuario' => function($q){

                    $q->select('id', 'email');

                    $q->select('id')
                    ->with(['registro' => function($q){ $q->select(); }]);


                    $q->select('id')
                    ->with(['user_rol' => function($q) { 
                        $q->select()
                        ->with(['rol' => function($q) {
                            $q->select('id', 'nombre','clave');
                        }]);
                    }]);

                }])
                ->whereHas('cct',function($q) use ($request){
                    if(!empty($request->cct)){
                        //dd($request->serie);
                            $q->where('clave_centro_trabajo',$request->cct);
                    }
                })
                ->with(['cct' => function($q){
                    $q->select('id', 'clave_centro_trabajo');
                }]);


        }else{
            $nombre= '';
            $apellidos= '';
            $email = '';

            if(!empty($request->nombre)){
                $nombre = $request->nombre;
            }
            if(!empty($request->apellidos)){
                $apellidos = $request->apellidos;
        
            }
            if(!empty($request->email)){
                $email = $request->email;
           
            }
            

            $query2 = EntUsuario::with('registro')
            
            ->whereHas('registro',function($q) use ($request){

                if(!empty($request->nombre)){
                    $q->where('nombres',$request->nombre);
                }

                if(!empty($request->apellidos)){
                    $q->where('apellidos',$request->apellidos);
                }

                if(!empty($request->email)){
                    $q->where('correo',$request->email);
                }

                $q->where('completa_datos',0);

            });
            
            /*
            $query2 = EntRegistro::where(
                function($q) use ($request){
                    

                    if(!empty($request->nombre)){
                        //dd($request->serie);
                        
                            $q->where('nombres',$request->nombre);
                    }
                    if(!empty($request->apellidos)){
                        
                        //dd($request->serie);
                            $q->where('apellidos',$request->apellidos);
                    }
                    if(!empty($request->email)){
                       
                        //dd($request->serie);
                            $q->where('correo',$request->email);
                    }
                }
            )->where('completa_datos',0);
                */
        }

        
        $query =    RmmUsuarioRol::with('rol','user')

        ->whereHas('rol',function($q) use ($request){
            if(!empty($request->rol)){
                //dd($request->serie);
                    $q->where('id',$request->rol);
            }
        })
        ->with(['rol' => function($q){
 
            $q->select('id', 'nombre','clave');

        }])   

        ->whereHas('user',function($q) use ($request){
        
            if(!empty($request->nombre)){
                //dd($request->serie);
                $q->whereHas('registro',function($q) use ($request){
                    $q->where('nombres',$request->nombre);
                });
            }

            if(!empty($request->apellidos)){
                //dd($request->serie);
                $q->whereHas('registro',function($q) use ($request){
                    $q->where('apellidos',$request->apellidos);
                });
            }

            if(!empty($request->email)){
                //dd($request->serie);
                $q->whereHas('registro',function($q) use ($request){
                    $q->where('correo',$request->email);
                });
            }

            $q->whereHas('registro',function($q) use ($request){
                $q->whereHas('user_cct',function($q) use($request){
                    $q->where('estatus',1);
                });
            });

            if(!empty($request->cct)){
                //dd($request->serie);
                $q->whereHas('registro',function($q) use ($request){
                    $q->whereHas('user_cct',function($q) use($request){
                        $q->whereHas('cct',function($q) use ($request){
                            $q->where('clave_centro_trabajo',$request->cct);
                        });
                    });
                });
            }
            
        })
        //TRAEMOS LOS DATOS DEPENDIENDO DE LOS PARAMETROS DE ISBN ENVIADOS
        ->with(['user' => function($q){
            /*
            $q->select('id')
            ->with(['registro' => function($q){ $q->select(); }]);*/

            /*
            $q->select('id')
            ->with(['registro' => function($q) { 
                $q->select()
                ->with(['cct' => function($q) { $q->select('id', 'clave_centro_trabajo'); }]);
            }]);*/

            $q->select('id')
            ->with(['registro' => function($q) { 
                $q->select()
                ->with(['user_cct' => function($q) {
                    $q->select()
                    ->with(['cct' => function($q) {
                        $q->select('id', 'clave_centro_trabajo');
                    }]);
                }]);
            }]);

        }])   ;

        $queryTotal = $query2->get();
        
        $query2 = $query2->paginate(10);

        
        $query2->appends($request->all());

        $data['roles'] = CatRol::all();
        $data['query2']       = $query2;
        $data['queryTotal']       = $queryTotal;
        $data['tipo_consulta'] = $tipo_consulta;
        session()->flashInput($request->input());
        return view('consulta_usuario', $data);

    }

    public function exportarUsuario(Request $request){

        $data = json_decode($request->queryTotal);

        SimpleExcelWriter::create('php://output', 'csv');

        $writer = SimpleExcelWriter::streamDownload('ConsultaUsuarios.xlsx');

        foreach($data as $item){
            $cct = " - ";
            if($item->cct != NULL){
                $cct = $item->user->registro->cct->clave_centro_trabajo;
            }
            $writer
            ->addRow([
                'Correo' => $item->user->registro->correo,
                'Nombres' => $item->user->registro->nombres,
                'Apellidos' => $item->license->license_type->apellidos,
                'Fecha de registro' => $item->user->registro->apellidos,
                'Rol' => $item->rol->nombre,
                'CCT' => $cct
            ]);

            $writer->toBrowser();

            return back()->withInput();
        }


    }

    public function editarUsuario(Request $request){
        
        

        $id = $request->idUsuarioEdit;
        $nombres = $request->nombreEdit;
        $apellidos = $request->apellidosEdit;
        $pais = $request->paisEdit;
        $telefono = $request->telefonoEdit;
        $matricula = $request->matriculaEdit;



        $usuario= EntRegistro::where('id', $id)->first();
        $usuario -> nombres =  $nombres;
        $usuario -> apellidos = $apellidos;
        $usuario -> pais_id = 138;
        $usuario -> telefonomovil = $telefono;
        
        $usuario -> save();

        /*
        $id = $request->idUsuarioEdit;
        $nombres = $request->nombreEdit;
        $apellidos = $request->apellidosEdit;
        $correo = $request->emailEdit;

        $usuario= EntRegistro::where('id', $id)->first();
        $usuario -> nombres =  $nombres;
        $usuario -> apellidos = $apellidos;
        $usuario -> correo = $correo;
        $usuario -> save();*/

        return back()->with('success',__('Datos del usuario se han actualizado'));
    }

    public function editarPasswordUsuario(Request $request){

        //FALTA ACTUALIZAR EN ENT_REGISTRO 
       
        $id = $request->idUsuarioEditPassword;
        $correo = $request->correo;
        $password = $request->password;


        $this->validate($request,[
            'password' => 'required | confirmed | min:8'
        ]);

        $verifyMailController = new VerifyMailController;
        //$verifyMailController->cambia_password_appcastillo($correo,$password);

        $usuario= EntRegistro::where('id', $id)->first();
        //dd($usuario->usuario_id);
        $usuario -> contrasenia_plataforma =  $password;
        $usuario -> save();

        
        $usuario_ent = EntUsuario::where('id', $usuario->usuario_id )->first();
        $usuario_ent -> password =  Hash::make($password);
        $usuario_ent -> save();

        return back()->with('success',__('La password del usuario se ha actualizado'));
    }

    public function eliminarCct(Request $request){

        $id_usuario_cct = $request->id_usuario_cct;
        $usuario_correo = $request->usuario_correo;
        $usuario_id = $request->usuario_id;

       
        $this->_borrarCct($id_usuario_cct,$usuario_correo,$usuario_id );
        return back()->with('success',__('Se ha eliminado el cct del usuario'));
    }
}
