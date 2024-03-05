<?php
namespace App\Http\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RmmUsuarioCct;

trait AppCastilloTrait {
   
    public function sendLibrosAppCastillo($usuario_cct_id){
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
            $publica_appCastillo = $data_usuario[0]->publica_appCastillo;

        if($data_usuario){//si tae datos la consulta de RegistroUnico
            //consulto usuario en AppCastillo
            $usuarioAppCastillo = DB::connection('mysql_2')->select("SELECT * FROM tusuario where usuario='".$email."'");
            //dd($usuarioAppCastillo);

            $cctAppCastillo = DB::connection('mysql_2')->select("SELECT * FROM testablecimiento where codigocct='".$clave_cct."'");

            if($cctAppCastillo){
                $idestablecimiento = $cctAppCastillo[0]->idestablecimiento;
            }else{$idestablecimiento = '99999';}
            
        
            if($usuarioAppCastillo){ //existe usuario en App Castillo (Actualiza en App Castillo) y agrega libros
               
                //Actualizo datos en AppCastillo
                $updateAppCastillo = DB::connection('mysql_2')->table('tusuario')->where('usuario', $email)
                ->update([
                    'nombre' => $nombre,
                    'apellido' => $apellidos,
                    'idestablacimiento' => $idestablecimiento,
                    'nivel' => $nivel,
                    'lada' => $lada,
                    'movil' => $telefono
                ]);

                if($publica_appCastillo == 0){//Si no se han enviado adopciones a appCastillo
                    $ru_existenciaLibros = DB::select("SELECT adop_7_id_app_eca from vista_adopciones where cct='".$clave_cct."' and adop_7_id_app_eca <> 0 order by adop_7_id_app_eca asc");
                    if($ru_existenciaLibros){
                        $usuarioAppCastillo = DB::connection('mysql_2')->select("SELECT * FROM tusuario where usuario='".$email."'");
                        $idusuarioECA = $usuarioAppCastillo[0]->idusuario;
                        
                        foreach( $ru_existenciaLibros as $idlibros){

                            DB::connection('mysql_2')->table('tareasusuario')
                            ->insert( 
                            ['idusuario'=>$idusuarioECA, 
                            'idarea'=>$idlibros->adop_7_id_app_eca]);
                        }

                        $rmm_usuario_cct = RmmUsuarioCct::where('id', $usuario_cct_id)->first();
                        $rmm_usuario_cct->publica_appcastillo = 1; //Se agrega 1 para saber que ya se han enviado adopciones a appCastillo por usuario
                        $rmm_usuario_cct->save();
                        
                        return back()->with('success', __('Adopciones agregadas correctamente. Por favor descargue la APP de su preferencia para ver sus contenidos.'));
                    }else{
                        return back()->with('fail', __('Este CCT no tiene adopciones.'));
                    }
                }else{
                    return back()->with('success', __('Ya tiene adopciones en este CCT. Por favor descargue la APP de su pereferencia para ver sus contenidos.'));
                }
             
                }else{//no existe en App Castillo, inserta registro nuevo.

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

                // $insertAppCastillo = 1;
                
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

                    if($insertAppCastillo){
                        $ru_existenciaLibros = DB::select("SELECT adop_7_id_app_eca from vista_adopciones where cct='".$clave_cct."' and adop_7_id_app_eca <> 0 order by adop_7_id_app_eca asc");
                        if($ru_existenciaLibros){
                            $usuarioAppCastillo = DB::connection('mysql_2')->select("SELECT * FROM tusuario where usuario='".$email."'");
                            $idusuarioECA = $usuarioAppCastillo[0]->idusuario;
                            
                            foreach( $ru_existenciaLibros as $idlibros){

                                DB::connection('mysql_2')->table('tareasusuario')
                                ->insert( 
                                ['idusuario'=>$idusuarioECA, 
                                'idarea'=>$idlibros->adop_7_id_app_eca]);
                            }

                            $rmm_usuario_cct = RmmUsuarioCct::where('id', $usuario_cct_id)->first();
                            $rmm_usuario_cct->publica_appcastillo = 1; //Se agrega 1 para saber que ya se han enviado adopciones a appCastillo por usuario
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
    }//fin function sendLibrosAppCastillo

    public function _wsAppCastillo($data){
        /*Función que inserta o actualiza usuarios en AppCastillo, return estado=insert o estado=update */
       //dd($data);
            $usuarioAppCastillo = DB::connection('mysql_2')->select("SELECT * FROM tusuario where usuario='".$data[0]->correo."'");
            //se obtiene el idcct de appCastillo
            $cctAppCastillo = DB::connection('mysql_2')->select("SELECT * FROM testablecimiento where codigocct='".$data[0]->clave_cct."'");
    
            if($cctAppCastillo){
                $idestablecimiento = $cctAppCastillo[0]->idestablecimiento;
            }else{$idestablecimiento = '99999';}


            if(!$usuarioAppCastillo){//no existe en App Castillo, inserta registro nuevo.

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

            // $insertAppCastillo = 1;
            
                $insertAppCastillo = DB::connection('mysql_2')->table('tusuario')
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
                
                return  $respValidaAppCastillo["estado"] ='insert' ;
               
            }else{
               
                $idusuarioECA = $usuarioAppCastillo[0]->idusuario;

                 //Actualizo datos en AppCastillo
                 $updateAppCastillo = DB::connection('mysql_2')->table('tusuario')->where('usuario', $data[0]->correo)
                 ->update([
                     'nombre' => $data[0]->nombres,
                     'apellido' => $data[0]->apellidos,
                     'idestablacimiento' => $idestablecimiento,
                     'nivel' => $data[0]->nivel_educativo,
                     'lada' => $data[0]->lada,
                     'movil' => $data[0]->telefono
                 ]);

                 return  $respValidaAppCastillo["estado"] ='update';
            }
        
        
    }

    public function _wsInsertaLibrosAppCastillo($email, $libros){

        $usuarioAppCastillo = DB::connection('mysql_2')->select("SELECT * FROM tusuario where usuario='".$email."'");
        //dd($usuarioAppCastillo);//si lo muestra
        $idusuarioECA = $usuarioAppCastillo[0]->idusuario;
        $string_libros =  implode(",",$libros);
        //dd($string_libros);
        $existenLibros = DB::connection('mysql_2')->select("SELECT * FROM tareasusuario where idarea in (".$string_libros.") and idusuario=".$idusuarioECA);
        //dd($existenLibros);
        if(!$existenLibros){
            foreach( $libros as $idlibros){
                //echo $idlibros;
    
                $inserta_libros = DB::connection('mysql_2')->table('tareasusuario')
                ->insert( 
                ['idusuario'=>$idusuarioECA, 
                'idarea'=>$idlibros]);
            }

            return true;

        }
               
            return false;

    }

}