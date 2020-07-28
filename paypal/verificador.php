<?php
    $idEspectaculo = $_REQUEST['idEspectaculo'];
    
    if ($idEspectaculo== null || $idEspectaculo=="" || $idEspectaculo=='0')
    {
         header('Location: pantallaError.php');
    }
    //echo "id espectaculo: ".$idEspectaculo."<br>valor transaccion: ".$valorTransaccion."<br>Nombre producto: ".$nombreProducto;
?>


<?php
    //print_r($_GET); // Imprime valor de token

    // $ClientID="Ac8wN2B7UvaIIK_FYkGr6JWy9_zII_Jtfrpx_zqs1z8Yrh9GqtxgerAZ8cTqznNjX8sdpTS8qfnw21fc"; // para pruebas
    // $Secret="EDdQHa0SnINkXy7eYRSqzCT5qv9FjkkgM68nGOrbdqsFehpzlhSM5ouAW9TovMu4WsFY1GuLnpG3Ygoc"; // para pruebas
    $ClientID="AVaNsxw5yj0CKf9vfNo0Nnx-slAracjCnT_HGlopLT8mY9-kUbXdbx8d8WBYbKKhf6kAFPaNHM823kS6"; // para producción
    $Secret="EIuaMlOcrUT6pEjJtP9Ni3yvLQTyDao5g8UB4KS22VfiXCfGk7iOQwEnVquzSsOJbVl6QvrNuIQ3lrQ4"; // para producción

    $Login=curl_init("https://api.paypal.com/v1/oauth2/token"); // para producción
    //$Login=curl_init("https://api.sandbox.paypal.com/v1/oauth2/token"); // para pruebas
    
    curl_setopt($Login,CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($Login,CURLOPT_RETURNTRANSFER,TRUE);
    curl_setopt($Login,CURLOPT_USERPWD,$ClientID.":".$Secret);

    curl_setopt($Login,CURLOPT_POSTFIELDS,"grant_type=client_credentials"); // solicita info via POST

    $Respuesta=curl_exec($Login);

    $objRespuesta=json_decode($Respuesta);
    
    $AccesToken =$objRespuesta->access_token;
    //print_r($AccesToken);
    //print_r($Respuesta);

    // Desplegar info dle pago
    //$venta=curl_init("https://api.sandbox.paypal.com/v1/payments/payment/".$_GET['paymentID']); // Para pruebas
    $venta=curl_init("https://api.paypal.com/v1/payments/payment/".$_GET['paymentID']); // para producción
    curl_setopt($venta,CURLOPT_HTTPHEADER,array("Content-Type: application/json","Authorization: Bearer ".$AccesToken));//enviar paramtros y acces token

    curl_setopt($venta,CURLOPT_RETURNTRANSFER,TRUE);

    $RespuestaVenta =curl_exec($venta);

    //print_r($RespuestaVenta);

    // Pasar respuesta de venta a objeto
    $objDatosTransaccion = json_decode($RespuestaVenta);
    //print_r($objDatosTransaccion);
?>



<?php 
    $IDtransaccion = $objDatosTransaccion->transactions[0]->related_resources[0]->sale->id;//
    $monto = $objDatosTransaccion->transactions[0]->amount->total; //
    $idPago = $objDatosTransaccion->id; //
    $fechaCreacionPago = $objDatosTransaccion->transactions[0]->related_resources[0]->sale->create_time; 
    $fechaUpdatePago = $objDatosTransaccion->transactions[0]->related_resources[0]->sale->update_time; //
    $formaPago = $objDatosTransaccion->transactions[0]->related_resources[0]->sale->payment_mode; //
    $cart = $objDatosTransaccion->cart; 
    $correoPaga = $objDatosTransaccion->payer->payer_info->email; //
    $nombreCuentaPaypal = $objDatosTransaccion->payer->payer_info->first_name; // 
    $apellidoCuentaPaypal = $objDatosTransaccion->payer->payer_info->last_name; //
    $payerID = $objDatosTransaccion->payer->payer_info->payer_id; 
    $pais = $objDatosTransaccion->payer->payer_info->country_code; 
    $telefono = $objDatosTransaccion->payer->payer_info->phone; 
    $custom = $objDatosTransaccion->transactions[0]->custom; 
?> 

<?php
/*Insertar en la BD*/
/*INSERT INTO `transaccion` (`idTransaccion`, `runComprador`, `codigoTransaccion`, `fechaTransaccion`, `espectaculo_idEspectaculo`, `notification_token`, `receiver_id`, `bank`, `payer_name`, `payer_email`, `responsible_user_email`, `payment_method`, `valorTransaccion`, `orderID`, `billingToken`, `intent`, `objetoPaypal`) VALUES (NULL, '123', '123', '123', '123', '123', '123', '123', '13', '123', '123', '123', '123', '123', '123', '123', '123');*/
    try
    {
        $servername = "190.107.177.34";
        $username = "producto_Samuel";
        $password = "*XN5GXmkn(-N";
        $dbname = "producto_cultura";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Falló conexión: " . $conn->connect_error);
        }
            
        $sql ="INSERT INTO `transaccion` 
        (`idTransaccion`, `runComprador`, `codigoTransaccion`, 
        `fechaTransaccion`, `espectaculo_idEspectaculo`, `notification_token`, 
        `receiver_id`, `bank`, `payer_name`, 
        `payer_email`, `responsible_user_email`, `payment_method`, 
        `valorTransaccion`, `orderID`, 
        `intent`, `IDtransaccionREAL`) 
        VALUES 
        (NULL, 'paypal', '".$_REQUEST['idRandom']."', 
        '".$fechaUpdatePago."', '$idEspectaculo', '".$AccesToken."', 
        'CPT', 'BancoDefaultPaypal', '".$nombreCuentaPaypal." ".$apellidoCuentaPaypal."', 
        '".$correoPaga."', 'responsible_user_emailPaypal', '".$formaPago."', 
        '".$monto."', '".$idPago."',
        'intentPaypal','".$IDtransaccion."');";
                
        if ($conn->query($sql) === TRUE) {

            //file_put_contents("php://stderr", "La query fue: ".$sql.PHP_EOL);
            //file_put_contents("php://stderr", "Registro agregado".PHP_EOL);
        } 
        else {
            //file_put_contents("php://stderr", "ERROR ENTRO AL ELSE".PHP_EOL);
            // echo "Error: " . $sql . "<br>" . $conn->error;
            header('Location: pantallaError.php');
        }

        $conn->close();
    }

    catch(Exception $e)
    {
        echo('<script> alert("Error al conectar BD"); </script>');
    }
?>



<!DOCTYPE html>
			<html lang="en">
				<head>
					<meta charset="utf-8">
					<meta http-equiv="X-UA-Compatible" content="IE=edge">
					<meta name="viewport" content="width=device-width, initial-scale=1">
					<meta name="description" content="">
					<meta name="author" content="">
					<link rel="shortcut icon" href="images/favicon.ico">

					<title>Tu pago se encuentra en verificaci&oacute;n.</title>

					<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

					<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
					<script src="atmosphere.js"></script>
					<script src="//storage.googleapis.com/installer/khipu-0.1.js"></script>

				</head>

				<body style="
     overflow-x: hidden !important;
     width:100%;
     height: 100%;
     background-image: url(img/imagenFondo.jpg);
     background-repeat: no-repeat; 
     background-attachment: fixed;
     background-size: cover;">
					<div class="container mt-5" >

							<div style="text-align:center;margin-left:20%;margin-right:20%;">
								<h4 style="color:white;font-weight: bold;">¡MUCHAS GRACIAS POR TU COMPRA!</h4>
								<hr style="background-color: white;">
							</div>

						<div class="pt-4 pb-3 mt-5 mb-5" style="background-color: rgb(20,20,20,0.9);">
							<div style="margin-left:10%;margin-right:10%;"> 
								<h6 class="mb-3" style="color:white;text-align:center">Se enviará un correo con el comprobante de pago, similar a la siguiente imagen</h6>
								<img style="height: 100%;
								width: 100%;" class="mb-4" src="img/imagenPaypal.jpg" alt=""> 
									<ul>
										<li style="color: white"><h6 style="color:white">Al momento de ingresar a la sala el día y hora del evento, se solicitará el <span style="color:rgb(216, 133, 133) !important;">código de acceso</span> y el correo electrónico asociado a tu cuenta de Paypal.</h6></li>
										<li style="color: white"><h6 style="color:white">Recuerda que sin estos datos no podras entrar, por lo que es importante que no borres por error el comprobante de pago de tu bandeja.</h6></li>
										<li style="color: white"><h6 style="color:white">Verifique su carpeta de spam en caso de que la configuración de tu correo no permita que llegue a la bandeja de entrada.</h6></li>
									</ul>

								<form action="http://culturaparatodos.cl/#/">
									<div class="mt-4 mb-4" style="text-align:center">
													
										<button type="submit" class="btn btn-info" style="background-color: rgb(98, 110, 175);border:0px !important">Volver al inicio</button>
									</div>
								</form>

							</div>
						</div>
					</div>


					<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
					<!-- <script src="js/bootstrap.min.js"></script>
					<script src="js/docs.min.js"></script> -->
					<!-- JS, Popper.js, and jQuery -->
					<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
					<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
					<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
				</body>
			</html>