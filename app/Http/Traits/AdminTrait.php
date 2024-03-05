<?php

namespace App\Http\Traits;
use App\Models\CatCct;
use App\Models\EntRegistro;
use App\Models\RmmUsuarioAdopcion;
use App\Models\RmmUsuarioCct;
use Illuminate\Support\Facades\DB;

trait AdminTrait {
    // public function index() {
    //     // Fetch all the students from the 'student' table.
    //     $student = Student::all();
    //     return view('welcome')->with(compact('student'));
    // }

    public function _generaMatricula($rol,$id_usuario)
    {

      $rol_clave    = DB::table('cat_rol')->where('id', $rol )->value('clave');
      $siglas       = "GM";
      $anio         = date("y");//2 digitos
      $tipo_usuario = $rol_clave;
      $usuario_id   = $id_usuario;
      $longitud     = 5;
      $string       = substr(str_repeat(0, $longitud).$usuario_id, - $longitud);
      $matricula    = $siglas.$anio.$tipo_usuario.$string;

      return $matricula;
    }

    public function _getPlataformas_cct($cct)
    {
      //dd($cct);
      //obtiene de las adopciones a que plataformas corresponden
      $adopciones = DB::select("CALL sp_plataformas('".$cct."')");
      //se separa por caDa coma encontrada para generar elementos que eliminar en el array
      //dd($adopciones);
      if($adopciones[0]->plataformas!=NULL){
        //dd($adopciones);
        $array = explode(",", $adopciones[0]->plataformas);
        $fmt_plataformas = array_unique($array);
        $string_plataforma =  implode(",",$fmt_plataformas);
        //dd($string_plataforma);
        $nombre_plataformas = DB::select("select * from cat_plataforma where id in (".$string_plataforma.") and activo = 1 ");
        //dd($nombre_plataformas);
        return response()->json([
          'lista' => $nombre_plataformas,
          'idplataforma' => $string_plataforma,
          'success' => true,
        ]);
      }else{
        return response()->json([
          'success' => false,
        ]);
      }
     
      //dd($nombre_plataformas);
     
    }
 

public function _wsInsertaGuias($usuario_id, $libros){

  $data_usuario  =  DB::select("CALL sp_usuario_test('".$usuario_id."')");
  $string_libros =  implode(",",$libros);
 
            $id         = $data_usuario[0]->eu_id;//entidad_usuario_id: ID QUE OBTIENE MATRICULA, CCT Y LICENCIA
            $nombre     = $data_usuario[0]->nombres;
            $apellidos  = $data_usuario[0]->apellidos;
            $email      = $data_usuario[0]->correo;
            $rol        = $data_usuario[0]->clave;
            $matricula  = $data_usuario[0]->matricula;
            $lada       = $data_usuario[0]->lada;
            $telefono   = $data_usuario[0]->telefono;
            $clave_cct  = $data_usuario[0]->clave_cct;
            $nivel      = $data_usuario[0]->nivel_educativo;
            $contrasenia = $data_usuario[0]->contrasenia_plataforma;

                  
          $jsonData = [
              "user_login" => $email,
              "user_nicename" => $email,
              "user_email" => $email,
              "display_name"=> $nombre.' '.$apellidos,
              "user_meta"=>[
                  "cct"=> $clave_cct,
                  "telefono"=> $telefono,
                  "nivel"=> $nivel,
                  "rol"=> $rol,
                  "first_name" => $nombre,
                  "last_name" => $apellidos,
                  "giap_id_servicios"=> $id,
                  "giap_sso" => base64_encode($contrasenia),
                  "guias" => $string_libros,
              ]
          ];

          $jsonDataEncode = json_encode($jsonData);
         
          return $jsonDataEncode;

}



  public function _validaLicenciaActiva($usuario_cct_id){

      /*Valida si ya existe una licencia activa de BL*/ 
      $existeLicencia =  DB::select("SELECT * FROM rmm_usuario_licencia where usuario_cct_id=".$usuario_cct_id);
      if($existeLicencia){ $licencia = 1; }else{  $licencia = 0;}
      /*fin validacion licencia activa BL*/
      return $licencia;
  }



  public function _catConfiguracion($parametro){

      $configuracion = DB::select("SELECT * FROM cat_configuracion WHERE parametro='".$parametro."'");
      return $configuracion;
  }


  public function _borrarCct($id_usuario_cct, $usuario_correo,$usuario_id ){

      $usuario_cct= RmmUsuarioCct::where('id', $id_usuario_cct)->first();
      $cct = CatCct::where('id',$usuario_cct->cct_id)->first();
      $usuario_cct->publica_appcastillo = 0;
      $usuario_cct->publica_appmacmillan = 0;
      $usuario_cct->publica_marometadigital = 0;
      $usuario_cct->estatus = 0;
      $usuario_cct->save();

      $usuiario_adopcion = RmmUsuarioAdopcion::where([
        'usuario_cct_id' => $id_usuario_cct
      ]);
    
      $adopciones = DB::select("SELECT adop_7_id_app_eca, cct from vista_adopciones where cct='".$cct->clave_centro_trabajo."' order by adop_7_id_app_eca asc");
     
     $usuarioAppCastillo = DB::connection('mysql_2')->select("SELECT * FROM tusuario where usuario='".$usuario_correo."'");

      $usuiario_adopcion = RmmUsuarioAdopcion::where('usuario_cct_id', $id_usuario_cct)->delete();
      
      if($usuarioAppCastillo!=null){
          foreach($adopciones as $adopcion){
              $cct_appCastillo =DB::connection('mysql_2')->select("DELETE FROM tareasusuario where idusuario='".$usuarioAppCastillo[0]->idusuario."' AND idarea='".$adopcion->adop_7_id_app_eca."' AND id_colegio='".$adopcion->cct."'");
          }
      }

      $usuario_cct_total = RmmUsuarioCct::where([
        'usuario_id' => $usuario_id,
        'estatus' => 1
      ]);

      $usuario_cct_total = DB::select("CALL sp_cctUsuario('".$usuario_id."');");
      

      if(empty($usuario_cct_total) ){
        $completa_datos = EntRegistro::where('usuario_id', $usuario_id)->first();
        $completa_datos->completa_datos = 0;
        $completa_datos->save();
      }

      
    
      return back()->with('success',__('Se ha eliminado el cct del usuario'));
  }

  public function _validaAdopcionesElegir($cct){

   //Se obtienes plataformas por cct
   $plataformas=$this->_getPlataformas_cct($cct);
   $str_plataformas = json_decode($plataformas->getContent());
   $array = explode(",",$str_plataformas->idplataforma);
  
   //dd($array);
   //Solo valida elegir adopciones para appcastillo(7) y appmacmillan(6)
   //dd(in_array("6", $array));
    if(in_array("6", $array) || in_array("7", $array)){
      return true;
    }else{
      return false;
    }
  }

}