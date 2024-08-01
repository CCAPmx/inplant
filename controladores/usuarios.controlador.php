<?php

date_default_timezone_set('America/Mexico_City');
class ControladorUsuarios
{
 
    static public function ctrTablaUsuarios()
    {
        $respueta= ModeloUsuarios::MdltablaUsuarios();
        return $respueta;
    }

	static public function ctrIngresoUsuario()
	{

		if (isset($_POST["txtPass"])) {

		
            $encriptar = crypt($_POST["txtPass"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

			$tabla = "usuarios";

			$item = "usuario";
			$valor = $_POST["txtMail"];

			$respuesta = ModeloUsuarios::MdlMostrarUsuariosmod($tabla, $item, $valor);

			if ($respuesta == 0) {
				echo '<br>
				<div class="col-12">
					<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong> Usuario No Registrado.
					</div>
				</div>';
			} else {



		


				if($respuesta["usuario"] == $_POST["txtMail"] && $respuesta["password"] ==  $encriptar ){
				
                    if($respuesta["estado"] == 1){
                        $_SESSION["iniciarSesion"] = "ok";
                        $_SESSION["id"] = $respuesta["id"];
                        $_SESSION["nombre"] = $respuesta["nombre"];
                        $_SESSION["tipouser"] = $respuesta["tipouser"];
                        $_SESSION["notificacion"] = $respuesta["notificacion"];
						$_SESSION["tipousuarionivel"] = $respuesta["tipousuarionivel"];
                        $_SESSION["tipousuarionombre"] = $respuesta["tipousuarionombre"];
						$_SESSION["u_clientes"] = $respuesta["u_clientes"];
						$_SESSION["fkEmpresa"] = $respuesta["fkEmpresa"];
						$_SESSION["Razon_social"] = $respuesta["Razon_social"];
						$_SESSION["direccion_fiscal"] = $respuesta["direccion_fiscal"];
						$_SESSION["pkuser"] = $respuesta["pkuser"];
						$_SESSION["usuario"] = $respuesta["usuario"];
						$_SESSION["produccion"] = $respuesta["produccion"];
						$_SESSION["mantenimiento"] = $respuesta["mantenimiento"];
						$_SESSION["bodega"] = $respuesta["bodega"];
						$_SESSION["maquinas"] = $respuesta["maquinas"];
						
						
						if ($_SESSION["tipousuarionivel"]<>4){
							$_SESSION["pk"] = $respuesta["pk"];
							$_SESSION["RFC"] = $respuesta["RFC"];
						}else{
							$_SESSION["pk"] ="";
							$_SESSION["RFC"] = "";
						}
						
						$_SESSION['time'] = time();

						$hostlersant = 'https://fms.lersan.com/fmi/data/v1/databases/Lersan/sessions';
						$usernamelersant = 'WEB_data';
						$passwordlersant = 'hyx9Hxw7YkHvZTEk';
						$payloadNamelersant='';
						$tokenlersant = get_token($hostlersant,$usernamelersant,$passwordlersant,$payloadNamelersant);
						$_SESSION["lersant"] = $tokenlersant;
		
						$hostccap = 'https://fms.lersan.com/fmi/data/v1/databases/CCAP/sessions';
						$usernameccap = 'WEB_data';
						$passwordccap = 'hyx9Hxw7YkHvZTEk';
						$payloadNameccap='';
						$tokenccap = get_token($hostccap,$usernameccap,$passwordccap,$payloadNameccap);
						$_SESSION["ccap"] = $tokenccap;
						

						if ($respuesta["tipouser"]==='SuperUsuario'){
							echo '<script>
								window.location ="inicio";
                            </script>';
						}else if($respuesta["tipouser"]==='Cliente Jefe'){
							echo '<script>
							window.location ="dashclientes";
							</script>';
						}

                     
                    }else{
                    // echo '<br>
                    //     <div class="col-12">
                    //         <div class="alert alert-danger alert-dismissible">
                    //         <button type="button" class="close" data-dismiss="alert">&times;</button>
                    //         <strong>Error!</strong> El Usuario No Se Encuentra Registrado.
                    //         </div>
                    //     </div>';

                        echo '<script>
                            alert("El Usuario No Se Encuentra Registrado.");
                        </script>';
                    }

					
				} else {

					// echo '<br>
                    //             <div class="col-12">
                    //                 <div class="alert alert-danger alert-dismissible">
                    //                 <button type="button" class="close" data-dismiss="alert">&times;</button>
                    //                 <strong>Error!</strong> El Usuario y/o Contraseña Incorrecto.
                    //                 </div>
                    //             </div>';
                    echo '<script>
                            alert("El Usuario y/o Contraseña Incorrecto.");
                    </script>';
				}
			}
		}
	}

    static public function ctrCbmtipouser()
    {
        $respuesta = ModeloUsuarios::MdlCombo();
        return $respuesta ; 
    }

    static public function ctrInsert($tabla, $datosInsert)
	{
		if (isset($datosInsert["pk"])) {
			$datos = array(
				"pk" => $datosInsert["pk"],
				"usuario" => $datosInsert["usuario"],
				"nombre" => $datosInsert["nombre"],
				"fkEmpresa" => $datosInsert["fkEmpresa"],
				"activo" => $datosInsert["activo"],
				"fkTipo" => $datosInsert["fkTipo"],
				"produccion" => $datosInsert["produccion"],
				"mantenimiento" => $datosInsert["mantenimiento"],
				"bodega" => $datosInsert["bodega"],
				"maquinas" => $datosInsert["maquinas"],
				"password" => $datosInsert["password"],
				"device" => $datosInsert["device"],
				"cambiodispositivo" => $datosInsert["cambiodispositivo"],
				"cambiopassword" => $datosInsert["cambiopassword"],
				"tipousuarionombre" => $datosInsert["tipousuarionombre"],
				"tipousuarionivel" => $datosInsert["tipousuarionivel"],
				"token" => $datosInsert["token"],
				"telefono" => $datosInsert["telefono"],
				"lada" => $datosInsert["lada"],
				"telefono_app" => $datosInsert["telefono_app"],
				"nivel_alarmas" => $datosInsert["nivel_alarmas"],
				"ext_cargarGranalla" => $datosInsert["ext_cargarGranalla"],
				"ext_cargarpiezas" => $datosInsert["ext_cargarpiezas"],
				"ext_altapartes" => $datosInsert["ext_altapartes"],
				"ext_vidautil" => $datosInsert["ext_vidautil"],
				"ext_entradas" => $datosInsert["ext_entradas"],
				"ext_salidas" => $datosInsert["ext_salidas"],
				"fotos" => $datosInsert["fotos"],
				"u_clientes" => $datosInsert["u_clientes"],
				"ext_preparacion" => $datosInsert["ext_preparacion"],
				"ext_granallado" => $datosInsert["ext_granallado"],
				"ext_calidad" => $datosInsert["ext_calidad"],
				"vagones" => $datosInsert["vagones"]
			);
			$respuesta = ModeloUsuarios::mdlIngresarUsuario($tabla, $datos);
			return $respuesta;
		}
	}

	static public function ctrUpdate($tabla, $datosUpdate)
	{
		if (isset($datosUpdate["pk"])) {
			$datos = array(
				"id" => $datosUpdate["id"],
				"pk" => $datosUpdate["pk"],
				"usuario" => $datosUpdate["usuario"],
				"nombre" => $datosUpdate["nombre"],
				"fkEmpresa" => $datosUpdate["fkEmpresa"],
				"activo" => $datosUpdate["activo"],
				"fkTipo" => $datosUpdate["fkTipo"],
				"produccion" => $datosUpdate["produccion"],
				"mantenimiento" => $datosUpdate["mantenimiento"],
				"bodega" => $datosUpdate["bodega"],
				"maquinas" => $datosUpdate["maquinas"],
				"password" => $datosUpdate["password"],
				"device" => $datosUpdate["device"],
				"cambiodispositivo" => $datosUpdate["cambiodispositivo"],
				"cambiopassword" => $datosUpdate["cambiopassword"],
				"tipousuarionombre" => $datosUpdate["tipousuarionombre"],
				"tipousuarionivel" => $datosUpdate["tipousuarionivel"],
				"token" => $datosUpdate["token"],
				"telefono" => $datosUpdate["telefono"],
				"lada" => $datosUpdate["lada"],
				"telefono_app" => $datosUpdate["telefono_app"],
				"nivel_alarmas" => $datosUpdate["nivel_alarmas"],
				"ext_cargarGranalla" => $datosUpdate["ext_cargarGranalla"],
				"ext_cargarpiezas" => $datosUpdate["ext_cargarpiezas"],
				"ext_altapartes" => $datosUpdate["ext_altapartes"],
				"ext_vidautil" => $datosUpdate["ext_vidautil"],
				"ext_entradas" => $datosUpdate["ext_entradas"],
				"ext_salidas" => $datosUpdate["ext_salidas"],
				"fotos" => $datosUpdate["fotos"],
				"u_clientes" => $datosUpdate["u_clientes"],
				"ext_preparacion" => $datosUpdate["ext_preparacion"],
				"ext_granallado" => $datosUpdate["ext_granallado"],
				"ext_calidad" => $datosUpdate["ext_calidad"],
				"vagones" => $datosUpdate["vagones"]
			);
			$respuesta = ModeloUsuarios::mdlIngresarUsuario($tabla, $datos);
			return $respuesta;
		}
	}


	static public function MostrarInfouser($tabla, $item, $valor)
	{
		if (isset($item)) {

			$respuesta = ModeloUsuarios::MdlMostrarInfouser($tabla, $item, $valor);

			return $respuesta;
		}
	}
 
}

function get_token($host,$username,$password,$payloadName) {
	$additionalHeaders = '';
	$ch = curl_init($host);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $additionalHeaders));
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadName);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch); // Execute the cURL statement
	curl_close($ch); // Close the cURL connection
	$json_token = json_decode($result, true);
	$token_received = $json_token['response']['token'];
	return($token_received);

};



