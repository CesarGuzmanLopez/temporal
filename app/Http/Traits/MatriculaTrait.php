<?php
namespace App\Http\Traits;
use Illuminate\Support\Facades\DB;

trait MatriculaTrait {
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
      //se separa por caa coma encontrada para generar elementos que eliminar en el array
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
          'success' => true,
        ]);
      }else{
        return response()->json([
          'success' => false,
        ]);
      }
     
      //dd($nombre_plataformas);
     
    }

    public function _validaLicenciaActiva($usuario_id){

     /*Valida si ya existe una licencia activa de BL*/ 
     $existeLicencia =  DB::select("SELECT * FROM rmm_usuario_licencia where usuario_propietario_id=".$usuario_id);
     if($existeLicencia){ $licencia = 1; }else{  $licencia = 0;}
     /*fin validacion licencia activa BL*/
     return $licencia;
    }

    

}