<?php

namespace App\Http\Controllers;

use App\Models\CatPais;
use App\Models\CatCct;
use App\Models\EntUsuario;
use App\Models\RegUser;
use App\Models\RmmUsuarioCct;
use App\Models\RmmUsuarioAdopcion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Environment\Console;

use App\Http\Traits\AdminTrait;
use App\Http\Traits\AppCastilloTrait;
use App\Http\Traits\AppMacmillanTrait;

class HomeController extends Controller
{

    use AdminTrait;
    use AppCastilloTrait;
    use AppMacmillanTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $paises  = CatPais::all();
        // $estados = CatCct::selectRaw('clave_entidad_federativa,nombre_entidad')
        // ->groupBy('clave_entidad_federativa','nombre_entidad')
        // ->get();

        //dd($estados);
        // $user = RegUser::selectRaw('nombres,apellidos,correo')
        //     ->where('correo',Auth::user()->email)
        //     ->where('habilitado',1)
        //     ->get();

        return view('home', compact('paises'));
    }

    public function getLadas($id)
    {
        $ladas = CatPais::selectRaw('lada')
        ->where('id',$id)
        ->where('activo',1)->get();
        return response()->json([
            'lista' => $ladas,
            'success' => true,
        ]);
    }

    public function getMunicipios($entidad)
    {
        $municipios = CatCct::selectRaw('clave_municipio_delegacion, nombre_municipio_delegacion')
        ->where('clave_entidad_federativa',$entidad)
        ->groupBy('clave_municipio_delegacion', 'nombre_municipio_delegacion')
        ->orderBy('nombre_municipio_delegacion')
        ->get();
        return response()->json([
            'lista' => $municipios,
            'success' => true,
        ]);
    }
    public function getLocalidades($entidad,$municipio)
    {
        $localidades = CatCct::selectRaw('clave_localidad,nombre_localidad')
        ->where('clave_entidad_federativa',$entidad)
        ->where('clave_municipio_delegacion',$municipio)
        ->groupBy('clave_localidad','nombre_localidad')
        ->orderBy('nombre_localidad')
        ->get();
        return response()->json([
            'lista' => $localidades,
            'success' => true,
        ]);
    }

    public function getCcts($entidad,$municipio,$localidad)
    {
        $ccts = CatCct::selectRaw('id, clave_centro_trabajo, nombre_centro_trabajo, nivel_educativo, nombre_turno')
        ->where('clave_entidad_federativa',$entidad)
        ->where('clave_municipio_delegacion',$municipio)
        ->where('clave_localidad',$localidad)
        ->get();
        return response()->json([
            'lista' => $ccts,
            'success' => true,
        ]);
    }

    //Función que valida el cct que introduce el usuario en el paso2 del formulario de registro, el resultado se pasa por ajax
    public function validaCCT($cct)
    {
     
        $find_cct = CatCct::selectRaw('id,clave_centro_trabajo,nexus_cct,nombre_centro_trabajo,nombre_turno,nivel_educativo')
        ->where('clave_centro_trabajo',$cct)
        ->limit(1)->get();

        $adopciones_cct = DB::select("SELECT grado_id,alias_360 FROM vista_adopciones where cct='".$cct."' and grado_id<>''
        group by grado_id, alias_360");
        //dd($find_cct);
        //return $find_cct->isEmpty();

        if($find_cct->isEmpty()==''){//devuelve 1:false o nada si es verdadero
            return response()->json([
                'lista' => $find_cct,
                'success' => true,
            ]);
        }else{
            return response()->json([
                'success' => false,
            ]);
        }  
    }

    //Función que valida un correo en el panel de mesa de ayuda
    public function validaCorreo($correo)
    {
        $find_email= EntUsuario::selectRaw('id')
        ->where('email',$correo)
        ->limit(1)->get();
        //dd($find_cct);
        //return $find_cct->isEmpty();

        if($find_email->isEmpty()==''){//devuelve 1:false o nada si es verdadero
            return response()->json([
                'lista' => $find_email,
                'success' => true,
            ]);
        }else{
            return response()->json([
                'success' => false,
            ]);
        }  
    }

    
   //Función que busca si el cct que ingresó el usuario tiene adopciones y que grados son de acuerdo al nivel educativo
  public function getGrados($usuario_id,$cct){

    //SP que busca en vista_adopciones los grados por cct
        $sp_getGrados     = DB::select("call sp_getGrados('".$cct."')");
    //SP que busca en vista_adopciones TODAS las adopciones por cct
        $sp_getAdopciones = DB::select("call sp_getAdopciones('".$cct."')");
    //SP que indica si ya ha sido asignadas adopciones a un cct del usuario
        $sp_usuario_cct_adopcion = DB::select("call sp_usuario_cct(".$usuario_id.",'".$cct."')");
        //dd($cct);
        //dd($sp_getAdopciones);
    //limites de libros
        $limit_adopciones = $this->_catConfiguracion('adopciones');
        $limit_preescolar = $this->_catConfiguracion('preescolar_1');
        $limit_primaria   = $this->_catConfiguracion('primaria_2');
        $limit_secundaria = $this->_catConfiguracion('secundaria_3');
        $usuario_cct_id = $sp_usuario_cct_adopcion[0]->id_rmm_usuario_cct;
        $cctUsuario = DB::select("CALL sp_cctUsuario('".$usuario_id."');");

        if($sp_getAdopciones && $this->_validaAdopcionesElegir($cct)==true)
        {
            switch ($sp_getAdopciones[0]->niveleducativo_id) {
                case 1:
                    $libros_max_elegir = $limit_preescolar[0]->valor;
                    break;
                case 2:
                    $libros_max_elegir = $limit_primaria[0]->valor;
                    break;
                case 3:
                    $libros_max_elegir = $limit_secundaria[0]->valor;
                    break;
                default:
                    $libros_max_elegir = $limit_adopciones[0]->valor;
                    break;
            }
            
            //Adopciones que si y no se han tomado
            $libros = DB::select("CALL sp_getLibros_cct(".$usuario_id.",'".$cct."');");
            $adopciones_tomadas = 0;
            foreach ($libros as $libro_tomado){
                if($libro_tomado->AdopTomada != ''){
                $adopciones_tomadas +=1;
                } 
            }
            //dd($libros_max_elegir);
             //Si hay adopciones y grados por cct y el número de libros agregados no son todos los permitidos

            if(count($sp_getAdopciones) >= $adopciones_tomadas && $adopciones_tomadas< $libros_max_elegir){

                // $libros = DB::select("CALL sp_getLibros_cct(".$usuario_id.",'".$cct."');");
                $grados = DB::select("select id,concat(clave,'o.') as texto,nombre, grado_semestre_anio from cat_grado_semestre_anio where id in(".$sp_getGrados[0]->grado.")");
               
                return view('adopciones', compact('libros','grados','libros_max_elegir','cct','usuario_cct_id','cctUsuario'));
                }
            else
            {   
                return redirect()->route('assemble',['usuario_id'=>$usuario_cct_id ])->with('success',__('Se agregaron todas las adopciones permitidas a este colegio.'));
            }
        }
        else
        {
            //dd($usuario_cct_id);
            return redirect()->route('assemble',['usuario_id'=>$usuario_cct_id ]);
        }

    
  }



//Función que inserta en rmm_usuario_adopcion las adopciones elegidas por el usuario
  public function insertaAdopciones(Request $request){
    //dd($request);
    $libros = $request->adopcion;
    //SP que busca en vista_adopciones TODAS las adopciones por cct
    $sp_getAdopciones = DB::select("call sp_getAdopciones('".$request->cct."')");
    
    //limites de libros
    $limit_adopciones = $this->_catConfiguracion('adopciones');
    $limit_preescolar = $this->_catConfiguracion('preescolar_1');
    $limit_primaria   = $this->_catConfiguracion('primaria_2');
    $limit_secundaria = $this->_catConfiguracion('secundaria_3');
   
    if($sp_getAdopciones)
    {
        switch ($sp_getAdopciones[0]->niveleducativo_id) {
            case 1:
                $libros_max_elegir = $limit_preescolar[0]->valor;
                break;
            case 2:
                $libros_max_elegir = $limit_primaria[0]->valor;
                break;
            case 3:
                $libros_max_elegir = $limit_secundaria[0]->valor;
                break;
            case 4:
                $libros_max_elegir = $limit_adopciones[0]->valor;
                break;
        }

        if(empty($libros))
        {
        return back()->with('fail',__('No hay libros seleccionados.')); 
        }
        //si la cantidad de libros ingresados es mayor al numero de libros establecidos en cat_configuración, regresa un error
        elseif(count($libros) > $libros_max_elegir)
        {
        return back()->with('fail',__('Puede elegir máximo '.$libros_max_elegir.' libro(s)')); 
        }
        else
        {

            //Busca el cct_id en la vista_cct_nexus(CatCct)
            $find_cct = CatCct::selectRaw('id')->where('clave_centro_trabajo',$request->cct)->limit(1)->get();
            $cct_id = $find_cct[0]->id;
            //Se obtiene el id de la relacion usuario-cct
            $usuario_cct = RmmUsuarioCct::where('usuario_id',Auth::user()->id)->where('cct_id',$cct_id)->first();
            $usuario_cct_id = $usuario_cct->id;
            //Libros separados por comas, seleccionados del formulario
            $idlibros =  implode(",",$libros);

            
            //Se obtienes plataformas por cct
            $plataformas=$this->_getPlataformas_cct($request->cct);
            $str_plataformas = json_decode($plataformas->getContent());
            //dd($str_plataformas);

            /*INSERTA ADOPCIONES EN SERVICIOS*/
            foreach( $libros as $libro){
                $insertaLibro = RmmUsuarioAdopcion::create(
                    [
                        'usuario_cct_id' => $usuario_cct_id,
                        'adopcion_id'    => $libro,
                        'estatus'        => 1,
                        'fechacreacion'  => now()
                    ]
                );
            }
            /*FIN DE INSERTA ADOPCIONES EN SERVICIOS*/

            $inserta_adopciones_cct = $this->_insertaAdopciones_plataforma($str_plataformas->idplataforma,$usuario_cct_id,$idlibros);
            $response = json_decode($inserta_adopciones_cct->getContent());
            if($response->success==true){
                
                return redirect()->route('assemble',['usuario_id'=>$usuario_cct_id]);

            }else{
                /*ELIMINA LAS ADOPCIONES EN SERVICIOS*/
                foreach( $libros as $libro){
                    $deleteLibro = RmmUsuarioAdopcion::where('id',$usuario_cct_id)->where('adopcion_id',$libro)->delete();
                }
                /*FIN ELIMINA ADOPCIONES*/

                return back()->with('fail',__('Ocurrió un error al enviar las adopciones'));
            }

           
        }
    }

    //si la cantidad de libros elegidos es vacio regresa un error
    
  }

  public function _insertaAdopciones_plataforma($plataformas,$usuario_cct_id,$idlibros){
    //dd($usuario_id);

    $libros_seleccionados = DB::select("call sp_librosSeleccionados(".$usuario_cct_id.",'".$idlibros."')");
    $plataformas_array = explode(",", $plataformas);
    $data_usuario =  DB::select("CALL sp_usuario_test('".$usuario_cct_id."')");
    //dd($libros_seleccionados);
    
    foreach( $libros_seleccionados as $seleccionados){
        foreach($plataformas_array as $plataforma){
            switch($plataforma){
                case 6:
                    $adop_6[] = $seleccionados->adop_6_id_app_mpu;
                    break;
                case 7:
                    $adop_7[] = $seleccionados->adop_7_id_app_eca;
                    break;
            }
        }
    }

    foreach($plataformas_array as $plataforma){
        switch($plataforma){
            case 6:
                //ENVIO A APPMACMILLAN
                //dd($adop_6);
                $envio_datos_personales = $this->_wsAppMacmillan($data_usuario);
                //dd($envio_datos_personales);
                $envio_insertaAppCastillo = $this->_wsInsertaLibrosAppMacmillan($data_usuario[0]->correo, $adop_6);
                //dd($envio_insertaAppCastillo);
                
                if($envio_insertaAppCastillo==1 or $envio_insertaAppCastillo==2){
                   $RmmUsuarioCct = RmmUsuarioCct::where('id', $usuario_cct_id)->first();
                   $RmmUsuarioCct->publica_appmacmillan = 1; //Se agrega 1 para saber que ya se han enviado adopciones a appCastillo por usuario
                   $RmmUsuarioCct->save();
                   $response = response()->json([
                    'plataforma' => 'APPMACMILLAN',
                    'success' => true,
                ]);
                }else{
                    $response = response()->json([
                        'plataforma' => 'APPMACMILLAN',
                        'success' => false,
                    ]);
                }
                /*FIN ENVIO A APPMACMILLAN */

                break;
            case 7:

                //ENVIO A APPCASTILLO
                $envio_datos_personales = $this->_wsAppCastillo($data_usuario);
                $envio_insertaAppCastillo = $this->_wsInsertaLibrosAppCastillo($data_usuario[0]->correo, $adop_7);
                //dd($envio_insertaAppCastillo);
                if($envio_insertaAppCastillo==1 or $envio_insertaAppCastillo==2){
                   $RmmUsuarioCct = RmmUsuarioCct::where('id', $usuario_cct_id)->first();
                   $RmmUsuarioCct->publica_appcastillo = 1; //Se agrega 1 para saber que ya se han enviado adopciones a appCastillo por usuario
                   $RmmUsuarioCct->save();
                   $response = response()->json([
                       'plataforma' => 'APPCASTILLO',
                       'success' => true,
                   ]);
                   
                }else{
                   $response = response()->json([
                       'plataforma' => 'APPCASTILLO',
                       'success' => false,
                   ]);
                }
                /*FIN ENVIO A APPCASTILLO */
                
                break;
        }

    }
    
    return $response;

  }
   
}
