<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use App\Models\RmmUsuarioCct;
use App\Http\Traits\AdminTrait;
use App\Http\Traits\AppCastilloTrait;
use App\Http\Traits\AppMacmillanTrait;
use App\Http\Traits\CEDTrait;
use App\Models\RmmUsuarioLicencia;
use App\Models\RegUser;
use App\Models\EntRegistro;

class DashboardController extends Controller
{
    use AdminTrait;
    use AppCastilloTrait;
    use AppMacmillanTrait;
    use CEDTrait;

    public function construye_dashboard($usuario_cct_id){
        
        //Obtenemos los datos por usuario_id
        
        $usuario = DB::select("CALL sp_usuario_test('".$usuario_cct_id."');");
        //dd($usuario);
        if($usuario){
            $usuario_id = $usuario[0]->eu_id;//36852
            $cctUsuario = DB::select("CALL sp_cctUsuario('".$usuario_id."');");
            //dd(Auth::user()->id);

	    session(['usuario_id' => $usuario_id]);
        session(['photoPerfil' => $usuario[0]->photo]);   
        if($cctUsuario == null){
                return view("agregar_cct");
        }

	    //session(['usuario_id' => $usuario_id]);
            session(['cctUsuario'       => $cctUsuario]);
            //session(['photoPerfil'      => $usuario[0]->photo]);
            session(['clave_cct'        => $usuario[0]->clave_cct]);
            session(['usuario_cct_id'   => $usuario[0]->usuario_cct_id]);
            $usuario_cct_id = $usuario[0]->usuario_cct_id; //único

            $cct    = $usuario[0]->clave_cct; //único
            $pais_id = $usuario[0]->pais_id;
            $rol_id = $usuario[0]->rol_id;
            $correo = $usuario[0]->correo;
            $publica_appCastillo = $usuario[0]->publica_appCastillo;
            $publica_appMacmillan = $usuario[0]->publica_appMacmillan;
            $nombre_plataformas = $this->_getPlataformas_cct($cct);//El método _getPlataformas_cct se obtiene del trait AdminTrait
            $response = json_decode($nombre_plataformas->getContent());//se decodifica el json
            $matricula = $usuario[0]->matricula;

            /*
            $mee_tokenaccess = $usuario[0]->tokenredessociales;
            $url_MEE = "https://mee.springernature.com/UserAccessControlService/Account/Redirect/meeportal?contentUnitId=1&accessToken=".$mee_tokenaccess."&refreshToken=";
            */

            if($response->success == true)
            {
            $plataformas = $response->lista;//Se obtienen las plataformas de las adopciones
            //dd($plataformas);
            /*Activación de BL:
            valida si ya se activó al menos una licencia en BL, se valida mediante el IDusuario, si este existe en BL regresa el link de acceso, sino regresa vacío*/
            session(['rol_id' =>$rol_id]);

            if($rol_id == 26 || $rol_id == 1){
                return view("dashboard_mesa_ayuda",compact('rol_id'));
            }


           

            $codigo_licencia = '';
            $activaBL = $this->_ssoBlinkLearning($codigo_licencia,$usuario_cct_id); 
            //print_r($activaBL);
            if( $activaBL->Code == '6' or $activaBL->URL == '' ){ 
                if($activaBL->Code =='3' or $activaBL->Code =='2'){
                    $existeenBL = 1;
                }else{
                    $existeenBL = 0;
                }
            }else{$existeenBL = 1;}
            /*Fin Activación BL*/
            
            //Se valida si la licencia ya se agregó
            $compruebaLicencia = $this->_validaLicenciaActiva($usuario_cct_id);
            
            
            $url = 'https://360.edicionescastillo.com/manager-si/index.php/SsoSI/validarUsuario';

            $response = Http::asForm()->post($url, [
                'email' => $correo,
            ]);

            if ($response=='false'){
                $castillo_id = '';
            }
            else{
                $castillo_id = $response;
            }

            //dd($castillo_id);
            //return view("dashboard", compact('plataformas','compruebaLicencia','existeenBL','publica_appCastillo','publica_appMacmillan','matricula','cct', 'pais_id','usuario_id','usuario_cct_id')); //se envían al dashboard
            return view("dashboard", compact('plataformas','compruebaLicencia','existeenBL','publica_appCastillo','publica_appMacmillan','matricula','cct','pais_id','usuario_id','usuario_cct_id','castillo_id')); //se envían al dashboard

            }else{

            return redirect("dashboard")->with('fail',__('No hemos encontrado un proyecto para su colegio, favor de contactar a su representante.'));

            }
            //dd($usuario);
        }else{

            return redirect("home")->with('fail',__('Ocurrió un problema al intentar guardar algún dato, por favor intente nuevamente.'));
            
        }
        
    }


    public function agregarCct(Request $request){

       // $usuarioCCT= RmmUsuarioCct::where('usuario_id', $request->usuario_id)->first();

       $usuarioCCT= RmmUsuarioCct::where([
            ['usuario_id', $request->usuario_id],
            ['cct_id', $request->id_cct],
       ])->first();

        $usuario_cct_total = DB::select("CALL sp_cctUsuario('". $request->usuario_id."');");
      

      if(empty($usuario_cct_total) ){
        $completa_datos = EntRegistro::where('usuario_id',  $request->usuario_id)->first();
        $completa_datos->completa_datos = 1;
        $completa_datos->save();
      }


       if($usuarioCCT){
            //dd($usuarioCCT->estatus);

            if($usuarioCCT->estatus == 1){
                return back()->with('fail',__('El usuario ya cuenta con ese CCT, el usuario no puede tener un CCT duplicado'));
            }else{
                
                //PREGUNTAR
                $usuarioActualizarCCT= RmmUsuarioCct::where('id', $usuarioCCT->id)->first();
                $usuarioActualizarCCT -> estatus =  1;
                $usuarioActualizarCCT -> save();
            }
        }else{
            
            RmmUsuarioCct::create(
                [
                    'usuario_id' => $request->usuario_id,
                    'cct_id' => $request->id_cct,
                    'estatus' => 1,
                    'fechacreacion' => date('Y-m-d H:i:s')
                ]
            );
        }

        if(isset($request->correo_existe)){
            return back()->with('success',__('CCT agregado correctamente'));
        }else{
            return redirect()->route('assemble',['usuario_id'=>$request->usuario_id]);
        }

        //dd($usuarioCCT);

        /*
        if(isset($request->correo_existe)){
            
            return back();
        }else{

            RmmUsuarioCct::create(
                [
                    'usuario_id' => $request->usuario_id,
                    'cct_id' => $request->id_cct,
                    'estatus' => 1,
                    'fechacreacion' => date('Y-m-d H:i:s')
                ]
            );

            return redirect()->route('assemble',['usuario_id'=>$request->usuario_id]);
        }*/

       

    }

    public function loginCED($usuario_id){
        //dd("loginCED");        dd($usuario_id);
        $response = $this->_validaUsuarioAppCastillo2($usuario_id);
        $url = "https://maestros.edicionescastillo.com/#/auth/sso/" . $response->message;
        //dd($url);        
        return response()->json([

            'urlCED' => $url,
            'success' => true,
        ]);
        //return redirect()->away($url);
    }

    public function getSsoRequest($sso,$usuario_cct_id)
    {
        
    if($sso == "BlinkLearning"){
        /*
        (1): Acceso generado correctamente
        (2): Acceso generado correctamente para usuario existente pero licencia no válida para el tipo de usuario indicado  Cadena de texto numérica, no regresa URL
        (3): Acceso generado correctamente para usuario existente pero licencia ya consumida - no trae URL
        (4): Acceso generado correctamente para usuario existente pero licencia emitidapara un centro diferente del centro al que pertenece el usuario
        (5): Acceso generado correctamente para usuario existente pero código de licencia no existente en Blink 
        (6): Acceso generado correctamente para usuario nuevo
        (0): Error general acceso
        (-1): Usuario/clave incorrectos */
        $codigo_licencia ='';
        $respuesta = $this->_ssoBlinkLearning($codigo_licencia,$usuario_cct_id);
        if($respuesta->Code == 0 or $respuesta->Code == -1 or  $respuesta->URL == '' ){
        return back()->with('fail','['.$respuesta->Code.']. '.$respuesta->Description);
        }else{
        return redirect()->away($respuesta->URL);
        }
    }

	if($sso == 'CED'){
        //dd("CED");
        //$respuesta = $this->_ssoCED($usuario_id, 2);
	    //return redirect()->away($respuesta);
	    $response = $this->_validaUsuarioAppCastillo2($usuario_cct_id);
        $url = "https://maestros.edicionescastillo.com/#/auth/sso/" . $response->message;
	    //dd($url);        
	    return redirect()->away($url);
        
	}

    if($sso == 'MarometaDigCO'){
        $respuesta = $this->_ssoMarometaDigCo($usuario_cct_id);
        if($respuesta!=false){
            return redirect()->away($respuesta);
        }else{
            return redirect("dashboard")->with('fail',__('No hemos encontrado un proyecto para su colegio Colombia, favor de contactar a su representante.'));
        }
        
    }

    if($sso == 'wikidsMx'){
        $respuesta = $this->_ssowikids($usuario_cct_id);
        if($respuesta!=false){
            return redirect()->away($respuesta);
        }else{
            return redirect("dashboard")->with('fail',__('No hemos encontrado un proyecto para su CCT, favor de contactar a su representante.'));
        }
        
    }
}

public function _ssoMarometaDigCo($usuario_cct_id){

    $usuario = DB::select("CALL sp_usuario_test('".$usuario_cct_id."');");
    $cct       = $usuario[0]->clave_cct;
    $matricula = $usuario[0]->matricula;
    $licencia  = $usuario[0]->codigo_licencia;

    $url_grado1 = "https://marometadigital.edicionescastillo.co/apps/md-01/index.html";
    $url_grado2 = "https://marometadigital.edicionescastillo.co/apps/md-02/index.html";
    $url_grado3 = "https://marometadigital.edicionescastillo.co/apps/md-03/index.html";

    ///$url_grado3 = "https://najar.co/dev/md-col/apps/md-03/index.html";

    //MDK3T23ZZZZZ

    if( substr($licencia,0,2) == 'MD' )
    {
       
        $validaLicenciaMD = $this->_validaLicenciaMarometaDigCo($licencia);
        //dd($validaLicenciaMD);
        if($validaLicenciaMD == true){

            //El grado se obtiene de la licencia.
            //Grado 1
            switch(substr($licencia,3,1)){
                case 1: $url = $url_grado1;
                break;
                case 2: $url = $url_grado2;
                break;
                case 3: $url = $url_grado3;
                break;
            }

            $ent_registro = RmmUsuarioCct::where('id', $usuario_cct_id)->first();

            if($ent_registro->publica_marometaDigital == 1){
                $firsttime = '';
            }else{
                $ent_registro->publica_marometaDigital = 1; //Se agrega 1 para saber que ya se envío la licencia de MD
                $ent_registro->save();
                $firsttime = '&forceact';
            }
            
            
            return $url.'?actid='.$licencia.'&userid='.$matricula.$firsttime;
        }

    }else{
            return false;
    }


}

public function _ssowikids($usuario_cct_id){

    $usuario = DB::select("CALL sp_usuario_test('".$usuario_cct_id."');");
    $cct       = $usuario[0]->clave_cct;
    $matricula = $usuario[0]->matricula;
    $licencia  = $usuario[0]->codigo_licencia;

    $url_grado1 = "https://wikids.edicionescastillo.com/apps/wk-01/index.html";
    $url_grado2 = "https://wikids.edicionescastillo.com/apps/wk-02/index.html";
    $url_grado3 = "https://wikids.edicionescastillo.com/apps/wk-03/index.html";
    $url_grado4 = "https://wikids.edicionescastillo.com/apps/wk-04/index.html";
    $url_grado5 = "https://wikids.edicionescastillo.com/apps/wk-05/index.html";
    $url_grado6 = "https://wikids.edicionescastillo.com/apps/wk-06/index.html";

    ///$url_grado3 = "https://najar.co/dev/md-col/apps/md-03/index.html";

    //MDK3T23ZZZZZ

    if( substr($licencia,0,2) == 'WK' )
    {
       
        $validaLicenciaMD = $this->_validaLicenciaWikids($licencia);
        //dd($validaLicenciaMD);
        if($validaLicenciaMD == true){

            //El grado se obtiene de la licencia.
            //Grado 1
            switch(substr($licencia,3,1)){
                case 1: $url = $url_grado1;
                break;
                case 2: $url = $url_grado2;
                break;
                case 3: $url = $url_grado3;
                break;
                case 4: $url = $url_grado4;
                break;
                case 5: $url = $url_grado5;
                break;
                case 6: $url = $url_grado6;
                break;
            }

            $ent_registro = RmmUsuarioCct::where('id', $usuario_cct_id)->first();

            if($ent_registro->publica_marometaDigital == 1){
                $firsttime = '';
            }else{
                $ent_registro->publica_marometaDigital = 1; //Se agrega 1 para saber que ya se envío la licencia de MD
                $ent_registro->save();
                $firsttime = '&forceact';
            }
            
            
            return $url.'?actid='.$licencia.'&userid='.$matricula.$firsttime;
        }

    }else{
            return false;
    }


}

public function _validaLicenciaMarometaDigCo($codigo_licencia){

    $licenciaMarometaDigCo = DB::connection('mysql_3')->select("SELECT * FROM code where code='".$codigo_licencia."'");
    if($licenciaMarometaDigCo){
        return true;
    }else{
        return false;
    }

    //dd($licenciaMarometaDigCo);
}

public function _validaLicenciaWikids($codigo_licencia){

    $licenciaWikids = DB::connection('mysql_4')->select("SELECT * FROM code where code='".$codigo_licencia."'");
    if($licenciaWikids){
        return true;
    }else{
        return false;
    }
}

 /*CED */
// 1 -> Con activacion de licencia
    //2 -> Continuar hacia el CED

    /*
public function _ssoCED($usuario_id, $tipo){
        
        $url = 'https://maestros.edicionescastillo.com/api/public/index.php/ignore/v1/sso/validate';
        $usuario =  DB::select("CALL sp_usuario_test('".$usuario_id."')");
        
       // dd($usuario);
        $email = $usuario[0]->correo;

        $headers = array('Content-Type: application/json');
        $params = array('email'=>$email);

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
        echo $email;
        $response = json_decode($output);
        dd($output);
	
        if(!$response->error){
            
            $url = 'https://maestros.edicionescastillo.com/api/public/index.php/ignore/v1/sso/user';
            echo("No existre");
            $id_roles = 7;
            $password = $usuario[0]->contrasenia_plataforma;
            $status = 1;
            $origin = 1;

            $headers = array('Content-Type: application/json');
            $params = array('email'=> $email, 'id_roles'=>$id_roles,'password'=>$password,'status' => $status ,'origin'=>$origin,);
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

            var_dump($params);
            var_dump($output);
            $response = json_decode($output);
            $respuesta = $this->_authCED($email, $usuario[0]->contrasenia_plataforma);
            return $respuesta;

        }else{
            //$respuesta = $this->_ssoCED($email, $usuario[0]->contrasenia_plataforma);
            $respuesta = $this->_authCED($email, $usuario[0]->contrasenia_plataforma);
            return $respuesta;
        }
    }


*/


   


   /*BLINK*/
   public function _ssoBlinkLearning($codigo_licencia,$usuario_cct_id){
    
    //Desarrollo
    //$url='https://blinkwpre.blinklearning.com/ws/WsSSO/wsSSO.php';
    //Producción
    $url='https://www.blinklearning.com/ws/WsSSO/wsSSO.php';
    

    $usuario =  DB::select("CALL sp_usuario_test('".$usuario_cct_id."')");

        $id          = $usuario[0]->eu_id;
        $nombre      = $usuario[0]->nombres;
        $apellidos   = $usuario[0]->apellidos;
        $email       = $usuario[0]->correo;
        $rol         = $usuario[0]->clave;
        if($codigo_licencia == ''){//si no es la primera licencia que se agrega
            $licencia = $usuario[0]->codigo_licencia;
        }else{
            $licencia = $codigo_licencia;
        }
        $contrasenia = $usuario[0]->contrasenia_plataforma;
    
        //dd($licencia);
        
    //accesos producción
    $usuario ="l4k7CtRB";
    $password ="S8WgGAT9";

    //accesos desarrollo
    //$usuario ="0sIzOshg";
    //$password ="Ia2AlJAj";

    $xml = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:sso="http://www.blinklearning.com/sso/">
                <soap:Header>
                    <sso:WSEAuthenticateHeader>
                        <sso:User>'.$usuario.'</sso:User>
                        <sso:Password>'.$password.'</sso:Password>
                    </sso:WSEAuthenticateHeader>
                </soap:Header>
                <soap:Body>
                    <sso:RequestAccess>
                        <sso:Id>'.$id.'</sso:Id>
                        <sso:Name>'.$nombre.'</sso:Name>
                        <sso:Surname>'.$apellidos.'</sso:Surname>
                        <sso:Email>'.$email.'</sso:Email>
                        <sso:PwsSHA1>'.sha1($contrasenia).'</sso:PwsSHA1>
                        <sso:UserType>'.$rol.'</sso:UserType>
                        <sso:Licenses>
                        <sso:License>'.$licencia.'</sso:License>
                        </sso:Licenses>
                    </sso:RequestAccess>
                </soap:Body>
            </soap:Envelope>';

    $send_context = stream_context_create(array(
        'http' => array(
        'method' => 'POST',
        'header' => 'Content-Type: application/soap+xml',
        'content' => $xml
        )
    ));
    $output = file_get_contents($url, false, $send_context);
    $xmls = simplexml_load_string($output);
    $namespaces = $xmls->getNameSpaces(true);
    $response = $xmls->children($namespaces['env'])->children($namespaces['ns1'])->RequestAccessResponse->RequestAccessResult;
    //dd($response);
    return $response;
    }

    public function activaLicencia(Request $request){// formulario Activa Licencia
        //dd($request);

        $licencia_valida = $this->_addLicencia($request->nueva_licencia,$request->usuario_cct_id);
        $licencia_valida =$this->_activaLicenciaCED($request->nueva_licencia,$request->usuario_cct_id);
        //$licencia_valida =$this->activaLicenciaCED($request->nueva_licencia,$request->usuario_id);
        //dd($licencia_valida);
        return $licencia_valida;

    }

    public function _addLicencia($codigo_licencia,$usuario_cct_id){
        //Comprueba si existe la licencia en ent_licencia
        $existeLicencia =  DB::select("SELECT * FROM ent_licencia where codigo_licencia='".$codigo_licencia."' and habilitado = 1");
        //dd($existeLicencia);
        if($existeLicencia){ //si existe, guarda el id de la licencia en rmm_usuario_licencia

            $licencia_valida = RmmUsuarioLicencia::where('licencia_id', $existeLicencia[0]->id)->where('estatus', 'No asignado')->first();
            if($licencia_valida){
                $licencia_valida -> usuario_cct_id = $usuario_cct_id;
                $licencia_valida -> estatus = 'asignado';
                $licencia_valida -> fechaactivacion = now();
                $licencia_valida -> save();
                //Valida usuario, registra usuario y agrega licencia al CED
                $this->_activaLicenciaCED($codigo_licencia,$usuario_cct_id);
                $this->_ssoBlinkLearning($codigo_licencia,$usuario_cct_id);
                return redirect()->route('assemble',['usuario_id'=>$usuario_cct_id])->with('success',__('La licencia '.$codigo_licencia.' se ha agregado con éxito.'));

            }else{
                
                $this->_ssoBlinkLearning($codigo_licencia,$usuario_cct_id);//se valida la licencia por si hay diferencias de activación entre la base de servicios y BL
                return redirect()->route('assemble',['usuario_id'=>$usuario_cct_id])->with('fail',__('La licencia '.$codigo_licencia.' ya ha sido asignada.'));
            }
            
            //Valida usuario, registra usuario y agrega licencia al CED
            $this->activaLicenciaCED($codigo_licencia,$usuario_cct_id);
            
        }else{ //sino regresa al dashboard y notifica al usuario
            //dd($usuario_cct_id);
            return redirect()->route('assemble',['usuario_id'=>$usuario_cct_id])->with('fail',__('La licencia '.$codigo_licencia.' no se encuentra registrada o habilitada.'));
        }

    }
   /* FIN BLINK*/

  
   /*360 MACMILLAN */
    public function getSsoRequestMacmillan(Request $request){//recibo token y retorno valores a 360

        $response = explode('_', $request->token);
        $usuario_cct_id = $response[1];
        //$usuario =  DB::select("SELECT * FROM ent_registro WHERE matricula='".$response[0]."'");
    
        if($usuario_cct_id){

            $data_usuario =  DB::select("CALL sp_usuario_test('".$usuario_cct_id."')");
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

            /*$sp_usuario_cct_adopcion = DB::select("call sp_usuario_cct(".$id.",'".$clave_cct."')");

            foreach ($sp_usuario_cct_adopcion as $adopciones) {
                $libros[] = $adopciones->adopcion_id;
            }
            $string_adop_id =  implode(",",$libros);
            $libros_seleccionados = DB::select("call sp_librosSeleccionados(".$usuario_cct_id.",'".$string_adop_id."')");

            foreach( $libros_seleccionados as $seleccionados){
                
                if($seleccionados->adop_4_id_360_mpu != '0')
                {
                    $adop_360[] = $seleccionados->adop_4_id_360_mpu;
                }

            }*/

                    
            $jsonData = [
                "user_login" => $email,
                "user_nicename"=> $email,
                "user_email"=> $email,
                "display_name"=> $nombre.' '.$apellidos,
                "user_meta" => [
                        "360mc_id_servicios"=> $id,
                        "first_name"=> $nombre,
                        "last_name"=> $apellidos,
                        "cct"=> $clave_cct,
                        "telefono"=> $telefono,
                        "nivel"=> $nivel,
                        "rol"=> $rol,
                        "360mc_sso"=> base64_encode($contrasenia),
                        /*"360adop" => $adop_360*/
                ]
            ];
            
            $jsonDataEncode = json_encode($jsonData);
           
            return $jsonDataEncode;

       }else{
            return redirect("dashboard")->with('fail',__('Ocurrió un problema al intentar enviar la información.'));
        }
        
    }
   /*FIN 360 MACMILLAN */

   /*360 CASTILLO */
   public function getSsoRequestCastillo(Request $request){//recibo token y retorno valores a 360

    $response = explode('_', $request->token);
    $usuario_cct_id = $response[1];
    //dd($usuario_cct_id);
    //$usuario =  DB::select("SELECT * FROM ent_registro WHERE matricula='".$request->token."'");

    if($usuario_cct_id){

        $data_usuario =  DB::select("CALL sp_usuario_test('".$usuario_cct_id."')");
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

       /* $sp_usuario_cct_adopcion = DB::select("call sp_usuario_cct(".$id.",'".$clave_cct."')");
        //dd($sp_usuario_cct_adopcion);

        foreach ($sp_usuario_cct_adopcion as $adopciones) {
            $libros[] = $adopciones->adopcion_id;
        }
        $string_adop_id =  implode(",",$libros);
        $libros_seleccionados = DB::select("call sp_librosSeleccionados(".$usuario_cct_id.",'".$string_adop_id."')");

        foreach( $libros_seleccionados as $seleccionados){
            
            if($seleccionados->adop_5_id_360_eca != '0')
            {
                $adop_360[] = $seleccionados->adop_5_id_360_eca;
            }

        }*/


        
        $jsonData = [
            "user_login" => $email,
            "user_nicename"=> $email,
            "user_email"=> $email,
            "display_name"=> $nombre.' '.$apellidos,
            "user_meta" => [
                    "360mc_id_servicios"=> $id,
                    "first_name"=> $nombre,
                    "last_name"=> $apellidos,
                    "cct"=> $clave_cct,
                    "telefono"=> $telefono,
                    "nivel"=> $nivel,
                    "rol"=> $rol,
                    "360mc_sso"=> base64_encode($contrasenia),
                   /* "360adop" => $adop_360*/
            ]
        ];
        
        $jsonDataEncode = json_encode($jsonData);
       
        return $jsonDataEncode;

   }else{
        return redirect("dashboard")->with('fail',__('Ocurrió un problema al intentar enviar la información.'));
    }
    
}
/*FIN 360 CASTILLO*/


    public function getSsoRequestGuias(Request $request){

        $usuario =  DB::select("SELECT * FROM ent_registro WHERE matricula='".$request->token."'");
    
        if($usuario){

            $data_usuario =  DB::select("CALL sp_usuario_test('".$usuario[0]->usuario_id."')");
            $id           = $data_usuario[0]->eu_id;//entidad_usuario_id: ID QUE OBTIENE MATRICULA, CCT Y LICENCIA
            $nombre       = $data_usuario[0]->nombres;
            $apellidos    = $data_usuario[0]->apellidos;
            $email        = $data_usuario[0]->correo;
            $rol          = $data_usuario[0]->clave;
            $matricula    = $data_usuario[0]->matricula;
            $lada         = $data_usuario[0]->lada;
            $telefono     = $data_usuario[0]->telefono;
            $clave_cct    = $data_usuario[0]->clave_cct;
            $nivel        = $data_usuario[0]->nivel_educativo;
            $contrasenia  = $data_usuario[0]->contrasenia_plataforma;

            //sp_usuario_cct('".$usuario[0]->usuario_id."', '15PPR3731K')

            $guias = DB::select("SELECT adop_15_role_guias,adop_7_id_app_eca from vista_adopciones where cct='".$clave_cct."' and adop_15_role_guias <> '0' order by adop_15_role_guias asc");
            //$guias = array_fetch($guias, 'adop_15_role_guias');
            if(!$guias){
                return redirect("dashboard")->with('fail',__('No existen adopciones para el envío a Castillo te Acompaña.'));
            }else{

                foreach( $guias as $guia){
                    $adop_guias[] =  $guia->adop_15_role_guias;
                    $adop_appcast[] = $guia->adop_7_id_app_eca;
                }
                        
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
                        "guias" => $adop_guias,
                    ]
                ];
    
                $jsonDataEncode = json_encode($jsonData);

                $this->_wsAppCastillo($data_usuario);
                $this->_wsInsertaLibrosAppCastillo($email, $adop_appcast);
               
                return $jsonDataEncode;

            }
            
        }
        else
        {
            return redirect("dashboard")->with('fail',__('Ocurrió un problema al intentar enviar la información.'));
        }


    }

    public function moduloEscuelas($cct,$castillo_id){

        return view('schools',['cct' => $cct, 'pais_id' => 31, 'castillo_id'=>$castillo_id]);
    
    }

    /* FIN SSO GUIAS*/
    
    /* Función cuando el usuario acciona guias sin haber activado adopciones en appCastillo*/
   /* public function validaGuias_appCastillo($idusuario){
        
            $data = DB::select("CALL sp_usuario_test('".$idusuario."');");
            //dd($data);
            $estado = $this->_wsAppCastillo($data);
            $guias = DB::select("SELECT adop_15_role_guias,adop_7_id_app_eca from vista_adopciones where cct='".$data[0]->clave_cct."' and adop_15_role_guias <> '0' order by adop_15_role_guias asc");
            //$guias = array_fetch($guias, 'adop_15_role_guias');
            if(!$guias){
                return redirect("dashboard")->with('fail',__('No existen adopciones para el envío a Castillo te Acompaña.'));
            }else{

                foreach( $guias as $guia){
                    $adop_guias[] =  $guia->adop_15_role_guias;
                    $adop_appcast[] = $guia->adop_7_id_app_eca;
                }

                $libros=$this->_wsInsertaLibrosAppCastillo($data[0]->correo, $adop_appcast);
                //dd($libros);
                $ent_registro = RegUser::where('usuario_id', $idusuario)->first();
                $ent_registro->publica_appCastillo = 1; //Se agrega 1 para saber que ya se han enviado adopciones a appCastillo por usuario
                $ent_registro->save();
                return back()->with('success', __('Adopciones agregadas correctamente. Por favor de click en el botón de guías nuevamente'));
    
            }
    }*/

}