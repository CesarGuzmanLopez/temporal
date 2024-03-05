<?php
namespace App\Http\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RmmUsuarioCct;

trait AppMacmillanTrait {
   
    public function sendLibrosAppMacmillan($usuario_cct_id){
        $data_usuario = DB::select("CALL sp_usuario_test('".$usuario_cct_id."');");

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
            $publica_appMacmillan = $data_usuario[0]->publica_appMacmillan;

        if($data_usuario){//si tae datos la consulta de RegistroUnico
            //consulto usuario en AppMacmillan
            $usuarioAppMacmillan = DB::connection('mysql_4')->select("SELECT * FROM tusuario where usuario='".$email."'");

            $cctAppMacmillan = DB::connection('mysql_4')->select("SELECT * FROM testablecimiento where codigocct='".$clave_cct."'");

            if($cctAppMacmillan){
                $idestablecimiento = $cctAppMacmillan[0]->idestablecimiento;
            }else{$idestablecimiento = '99999';}
            
        
            if($usuarioAppMacmillan){ //existe usuario en App Macmillan (Actualiza en App Macmillan) y agrega libros
               
                //Actualizo datos en AppMacmillan
                $updateAppMacmillan = DB::connection('mysql_4')->table('tusuario')->where('usuario', $email)
                ->update([
                    'nombre' => $nombre,
                    'apellido' => $apellidos,
                    'idestablacimiento' => $idestablecimiento,
                    'nivel' => $nivel,
                    'lada' => $lada,
                    'movil' => $telefono
                ]);

                if($publica_appMacmillan == 0){//Si no se han enviado adopciones a appMacmillan
                    $ru_existenciaLibros = DB::select("SELECT adop_6_id_app_mpu from vista_adopciones where cct='".$clave_cct."' and adop_6_id_app_mpu <> 0 order by adop_6_id_app_mpu asc");
                    if($ru_existenciaLibros){
                        $usuarioAppMacmillan = DB::connection('mysql_4')->select("SELECT * FROM tusuario where usuario='".$email."'");
                        $idusuarioECA = $usuarioAppMacmillan[0]->idusuario;
                        
                        foreach( $ru_existenciaLibros as $idlibros){

                            DB::connection('mysql_4')->table('tareasusuario')
                            ->insert( 
                            ['idusuario'=>$idusuarioECA,
                            'idarea'=>$idlibros->adop_6_id_app_mpu]);
                        }

                        $rmm_usuario_cct = RmmUsuarioCct::where('id', $usuario_cct_id)->first();
                        $rmm_usuario_cct->publica_appmacmillan = 1; //Se agrega 1 para saber que ya se han enviado adopciones a appCastillo por usuario
                        $rmm_usuario_cct->save();
                        
                        return back()->with('success', __('Adopciones agregadas correctamente. Por favor descargue la APP de su preferencia para ver sus contenidos.'));
                    }else{
                        return back()->with('fail', __('Este CCT no tiene adopciones.'));
                    }
                }else{
                    return back()->with('success', __('Ya tiene adopciones en este CCT. Por favor descargue la APP de su pereferencia para ver sus contenidos.'));
                }
             
               
                }else{//no existe en App Macmillan, inserta registro nuevo.

                    $codigotarjeta="";//codigo de activación por correo
                    $codigorecuperapassword="";//codigo de recuperación de password por correo
                    $fechaActual = date('Y-m-d');
                    $habilitado = 1;//
                    $caduca=NULL;
                    $activado = 1;//
                    $sector = "Privado"; //en App Macmillan esta variable es seleccionada dentro de un combo
                    $cargo = "Docente";
                    $boletin = 0;
                    $phone = "";

                // $insertAppMacmillan = 1;
                
                    $insertAppMacmillan = DB::connection('mysql_4')->table('tusuario')
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

                    if($insertAppMacmillan){
                        $ru_existenciaLibros = DB::select("SELECT adop_6_id_app_mpu from vista_adopciones where cct='".$clave_cct."' and adop_6_id_app_mpu <> 0 order by adop_6_id_app_mpu asc");
                        if($ru_existenciaLibros){
                            $usuarioAppMacmillan = DB::connection('mysql_4')->select("SELECT * FROM tusuario where usuario='".$email."'");
                            $idusuarioECA = $usuarioAppMacmillan[0]->idusuario;
                            
                            foreach( $ru_existenciaLibros as $idlibros){

                                DB::connection('mysql_4')->table('tareasusuario')
                                ->insert( 
                                ['idusuario'=>$idusuarioECA, 
                                'idarea'=>$idlibros->adop_6_id_app_mpu]);
                            }

                            
                        $rmm_usuario_cct = RmmUsuarioCct::where('id', $usuario_cct_id)->first();
                        $rmm_usuario_cct->publica_appmacmillan = 1; //Se agrega 1 para saber que ya se han enviado adopciones a appCastillo por usuario
                        $rmm_usuario_cct->save();
                            
                            return back()->with('success', __('Adopciones agregadas correctamente. Por favor descargue la APP de su pereferencia para ver sus contenidos.'));
                        }

                    }else{
                            return back()->with('fail', __('Ocurrió un problema al agregar sus adopciones.'));
                    }
            }

        }else{
            return back()->with('fail', __('Ocurrió un problema al encontrar sus adopciones.'));
        }
    }//fin function sendLibrosAppMacmillan

    public function _wsAppMacmillan($data){
        /*Función que inserta o actualiza usuarios en AppMacmillan, return estado=insert o estado=update */
        //dd($data[0]->correo);
       
            $usuarioAppMacmillan = DB::connection('mysql_4')->select("SELECT * FROM tusuario where usuario='".$data[0]->correo."'");
            //se obtiene el idcct de appMacmillan
            $cctAppMacmillan = DB::connection('mysql_4')->select("SELECT * FROM testablecimiento where codigocct='".$data[0]->clave_cct."'");
    
            if($cctAppMacmillan){
                $idestablecimiento = $cctAppMacmillan[0]->idestablecimiento;
            }else{$idestablecimiento = '99999';}


            if(!$usuarioAppMacmillan){//no existe en App Macmillan, inserta registro nuevo.

                $codigotarjeta="";//codigo de activación por correo
                $codigorecuperapassword="";//codigo de recuperación de password por correo
                $fechaActual = date('Y-m-d');
                $habilitado = 1;//
                $caduca=NULL;
                $activado = 1;//
                $sector = "Privado"; //en App Macmillan esta variable es seleccionada dentro de un combo
                $cargo = "Docente";
                $boletin = 0;
                $phone = "";

            // $insertAppMacmillan = 1;
            
                $insertAppMacmillan = DB::connection('mysql_4')->table('tusuario')
                ->insert(
                ['usuario'          =>$data[0]->correo,
                'password'          =>md5($data[0]->contrasenia_plataforma),
                'nombre'            =>$data[0]->nombres,
                'apellido'          =>$data[0]->apellidos,
                'idestablacimiento' =>$idestablecimiento,
                'codigotarjeta'     =>$codigotarjeta,
                'codigorecuperapassword'=>$codigorecuperapassword,
                'alta'              =>$fechaActual,
                'habilitado'        =>$habilitado,
                'caduca'            =>$caduca,
                'activado'          =>$activado,
                'nivel'             =>$data[0]->nivel_educativo,
                'sector'            =>$sector,
                'cargo'             =>$cargo,
                'lada'              =>$data[0]->lada,
                'boletin'           =>$boletin,
                'movil'             =>$data[0]->telefono,
                'phone'             =>$phone]);
                
                return  $respValidaAppMacmillan["estado"] ='insert' ;
               
            }else{
               
                $idusuarioECA = $usuarioAppMacmillan[0]->idusuario;

                 //Actualizo datos en AppMacmillan
                 $updateAppMacmillan = DB::connection('mysql_4')->table('tusuario')->where('usuario', $data[0]->correo)
                 ->update([
                     'nombre' => $data[0]->nombres,
                     'apellido' => $data[0]->apellidos,
                     'idestablacimiento' => $idestablecimiento,
                     'nivel' => $data[0]->nivel_educativo,
                     'lada' => $data[0]->lada,
                     'movil' => $data[0]->telefono
                 ]);

                 return  $respValidaAppMacmillan["estado"] ='update';
            }
        
        
    }

    public function _wsInsertaLibrosAppMacmillan($email, $libros){

        $usuarioAppMacmillan = DB::connection('mysql_4')->select("SELECT * FROM tusuario where usuario='".$email."'");
        if($usuarioAppMacmillan){

            $idusuarioMPU = $usuarioAppMacmillan[0]->idusuario;
            $string_libros =  implode(",",$libros);
            $existenLibros = DB::connection('mysql_4')->select("SELECT * FROM tareasusuario where idarea in (".$string_libros.") and idusuario=".$idusuarioMPU);

            if(!$existenLibros){
                foreach( $libros as $idlibros){
                    //echo $idlibros;
                    $inserta_libros = DB::connection('mysql_4')->table('tareasusuario')
                    ->insert( 
                    ['idusuario'=>$idusuarioMPU, 
                    'idarea'=>$idlibros]);
                }

                return 1;//inserta libros

            }else{

                return 2;//no se insertaron para no duplicar
            }
                
        }else{

                return 0;

        }
        
    }
   
    

}