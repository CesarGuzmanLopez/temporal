<?php
namespace App\Http\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait CEDTrait {
   
   //*Login CED */

   public function _authCED( $email, $password){

    $url ='https://maestros.edicionescastillo.com/api/public/index.php/ignore/v1/loginSSO';

    $headers = array('Content-Type: application/json');


    $params = array('email'=>$email,'password'=>$password);
    
    $params = json_encode($params);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_POST, TRUE);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_TIMEOUT,10);
    
    $output = curl_exec($curl);
    curl_close($curl);	
    
    $response = json_decode($output);
    $url = "https://maestros.edicionescastillo.com/#/auth/sso/" . $response->message;
//dd($response);       
    
    return $response;
    
}

public function _activaLicenciaCED($codigo_licencia,$usuario_cct_id){// formulario Activa Licencia
    
    //$licencia_valida = $this->_addLicencia($request->nueva_licencia,$request->usuario_id);
    $usuario =  DB::select("CALL sp_usuario_test('".$usuario_cct_id."')");
    $response = $this->_validaUsuarioAppCastillo2($usuario_cct_id);
    $token =$response->message;
    //dd($response);
    $urlToken = "https://maestros.edicionescastillo.com/#/auth/sso/" . $response->message;
    //$token = $this->_ssoCED($request->usuario_id,1);
    //$urlToken = "https://maestros.edicionescastillo.com/#/auth/sso/" . $token;
    //dd($token);
    
    //$usuarioCED = $this->_buscarUsuarioCED($usuario[0]->correo);
    //$licencia = $this->_buscarLicenciaCED($request->nueva_licencia);

    if($response->error == false){
        $usuarioCED = $response->id;
    
        $licencia = $this->_buscarLicenciaCED($codigo_licencia);
        if(empty($licencia)){
            //dd($urlToken);
            $respuestaLicencia["code"] =0 ;
            $respuestaLicencia["mensaje"] = "Licencia no encontrada o ya utilizada" ;
            return $respuestaLicencia;
        }else{
            $licenciaID = $licencia[0]->id;
            $url = 'https://maestros.edicionescastillo.com/api/public/index.php/api/v1/licenses/burnlicenses2';
            //$url = 'https://maestros.edicionescastillo.com/api/public/index.php/ignore/v1/licensesOpen/burnlicenses';
            $headers = array('Content-Type: application/json','x-token: '.$token);
            //dd($headers);
            $params = array('idUser'=> $usuarioCED, 'id'=> $licenciaID);
            $params = json_encode($params);
                
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_POST, TRUE);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_TIMEOUT,10);
            $output = curl_exec($curl);
            curl_close($curl);
            //var_dump($url);
            //var_dump($params);

            //echo("Error");
            //var_dump($output);

            $response = json_decode($output);
            //echo '<br>';
            //echo $url;
            $respuestaLicencia["code"] =1;
            $respuestaLicencia["mensaje"] = "Licencia agregada" ;
            return $respuestaLicencia;
        }
    }else{
        $respuestaLicencia["code"] =0;
        $respuestaLicencia["mensaje"] = "Error al agregar la licencia" ;
        return $respuestaLicencia;
    }
    
    
    

    //dd($licencia_valida);
    //return $licencia_valida;

}

public function _buscarUsuarioCED($email){
    $url = 'https://maestros.edicionescastillo.com/api/public/index.php/ignore/v1/sso/user/find';
    $headers = array('Content-Type: application/json');
    $params = array();
    $params = json_encode($params);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_POST, TRUE);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_TIMEOUT,10);
    $output = curl_exec($curl);
    curl_close($curl);

    $response = json_decode($output);

    $totalUsuarios = count($response);
    $idUsuarioCED = 0;
    

    for($i = 0; $i<$totalUsuarios ;$i++){
        if($response[$i]->email == $email ){
            $idUsuarioCED = $response[$i]->id;
        }
    }   

    return $idUsuarioCED;
}


public function _buscarLicenciaCED($key){

    $url = 'https://maestros.edicionescastillo.com/api/public/index.php/ignore/v1/licensesOpen/find';
    $headers = array('Content-Type: application/json');
    $params = array('key'=> $key);
    $params = json_encode($params);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_POST, TRUE);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_TIMEOUT,10);
    $output = curl_exec($curl);
    curl_close($curl);

    $response = json_decode($output);
    //dd($response);
    
    $idUserCED = $response;

    return $idUserCED;


}

/**Validar Usuario Castillo2 */
public function _validaUsuarioAppCastillo2($usuario_cct_id){
    //dd("Entre".$usuario_id);

    $data_usuario = DB::select("CALL sp_usuario_test('".$usuario_cct_id."');");
    //dd($data_usuario);
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
        $pwd_plataforma = $data_usuario[0]->contrasenia_plataforma;
        $publica_appCastillo = $data_usuario[0]->publica_appCastillo;
    //dd($email);
    $usuarioAppCastillo = DB::connection('mysql_2')->select("SELECT * FROM tusuario where usuario='".$email."'");
    //dd($usuarioAppCastillo);
    if(empty($usuarioAppCastillo)){
    	
        $cctAppCastillo = DB::connection('mysql_2')->select("SELECT * FROM testablecimiento where codigocct='".$clave_cct."'");

        if($cctAppCastillo){
            $idestablecimiento = $cctAppCastillo[0]->idestablecimiento;
        }else{$idestablecimiento = '99999';}
        

        $codigotarjeta="";//codigo de activación por correo
        $codigorecuperapassword="";//codigo de recuperación de password por correo
        $fechaActual = date('Y-m-d');
        $habilitado = 1;//
        $caduca=NULL;
        $activado = 1;//
        $sector = "Privado"; //en App Castillo esta variable es seleccionada dentro de un combo
        $cargo = "Docente";
        $boletin = 0;
        $phone = "";

        $insertAppCastillo = DB::connection('mysql_2')->table('tusuario')
                ->insert(
                ['usuario'          =>$email,
                'password'          =>md5($pwd_plataforma),
                'nombre'            => $nombre,
                'apellido'          =>$apellidos,
                'idestablacimiento' =>$idestablecimiento,
                'codigotarjeta'     =>$codigotarjeta,
                'codigorecuperapassword'=>$codigorecuperapassword,
                'alta'              =>$fechaActual,
                'habilitado'        =>$habilitado,
                'caduca'            =>$caduca,
                'activado'          =>$activado,
                'nivel'             =>$nivel,
                'sector'            =>$sector,
                'cargo'             =>$cargo,
                'lada'              =>$lada,
                'boletin'           =>$boletin,
                'movil'             =>$telefono,
                'phone'             =>$phone]);

                //Crear libro al CED

                //Id appCastillo
                //idarea = 100

        $usuarioAppCastillo = DB::connection('mysql_2')->select("SELECT * FROM tusuario where usuario='".$email."'");

        DB::connection('mysql_2')->table('tareasusuario')
                    ->insert( 
                    ['idusuario'=>$usuarioAppCastillo[0]->idusuario, 
                    'idarea'=>100]);


        $respuesta = $this->_authCED($email,$pwd_plataforma);
                //dd($respuesta);
        return($respuesta);
    }else{
        //dd("Ya existe");

        //Para asignarle un libro al usuario en caso que no tenga ningun libro asignar; ingreso al CED
        $libro100 = DB::connection('mysql_2')->select("SELECT * FROM tareasusuario where idusuario='".$usuarioAppCastillo[0]->idusuario." AND idarea = 100'");

        if(empty($libro100)){
            DB::connection('mysql_2')->table('tareasusuario')
                            ->insert( 
                            ['idusuario'=>$usuarioAppCastillo[0]->idusuario, 
                            'idarea'=>100]);
        }
        
        $respuesta = $this->_authCED($email,$pwd_plataforma);
        //dd($respuesta);            
        return($respuesta);
    }
    
}
/**Fin validar Usuario Castillo2 */


}
