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
        `valorTransaccion`, `orderID`, `billingToken`, 
        `intent`, `objetoPaypal`) 
        VALUES 
        (NULL, 'paypal', '".$IDtransaccion."', 
        '".$fechaUpdatePago."', 'idEspectaculo', '".$AccesToken."', 
        'CPT', 'BancoDefaultPaypal', '".$nombreCuentaPaypal." ".$apellidoCuentaPaypal."', 
        '".$correoPaga."', 'responsible_user_emailPaypal', '".$formaPago."', 
        '".$monto."', '".$idPago."', 'billingTokenPaypal', 
        'intentPaypal', '".$RespuestaVenta."');";
                
        if ($conn->query($sql) === TRUE) {

            //file_put_contents("php://stderr", "La query fue: ".$sql.PHP_EOL);
            //file_put_contents("php://stderr", "Registro agregado".PHP_EOL);
        } 
        else {
            //file_put_contents("php://stderr", "ERROR ENTRO AL ELSE".PHP_EOL);
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }

    catch(Exception $e)
    {
        echo('<script> alert("Error al conectar BD"); </script>');
    }
?>