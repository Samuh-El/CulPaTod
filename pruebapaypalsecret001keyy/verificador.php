<?php
    //print_r($_GET); // Imprime valor de token

    $ClientID="Ac8wN2B7UvaIIK_FYkGr6JWy9_zII_Jtfrpx_zqs1z8Yrh9GqtxgerAZ8cTqznNjX8sdpTS8qfnw21fc";
    $Secret="EDdQHa0SnINkXy7eYRSqzCT5qv9FjkkgM68nGOrbdqsFehpzlhSM5ouAW9TovMu4WsFY1GuLnpG3Ygoc";

    $Login=curl_init("https://api.sandbox.paypal.com/v1/oauth2/token");
    
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
    $venta=curl_init("https://api.sandbox.paypal.com/v1/payments/payment/".$_GET['paymentID']);
    curl_setopt($venta,CURLOPT_HTTPHEADER,array("Content-Type: application/json","Authorization: Bearer ".$AccesToken));//enviar paramtros y acces token

    curl_setopt($venta,CURLOPT_RETURNTRANSFER,TRUE);

    $RespuestaVenta =curl_exec($venta);

    //print_r($RespuestaVenta);

    // Pasar respuesta de venta a objeto
    $objDatosTransaccion = json_decode($RespuestaVenta);
    //print_r($objDatosTransaccion);
?>


<br><br><br><br>
<?php print_r("ID de transacción: ".$objDatosTransaccion->transactions[0]->related_resources[0]->sale->id); ?> <br><br>
<?php print_r("Monto: ".$objDatosTransaccion->transactions[0]->amount->total); ?> <br><br>
<?php print_r("ID de pago: ".$objDatosTransaccion->id); ?> <br><br>
<?php print_r("Fecha creación pago: ".$objDatosTransaccion->transactions[0]->related_resources[0]->sale->create_time); ?> <br><br>
<?php print_r("Fecha update pago: ".$objDatosTransaccion->transactions[0]->related_resources[0]->sale->update_time); ?> <br><br>
<?php print_r("Forma de pago: ".$objDatosTransaccion->transactions[0]->related_resources[0]->sale->payment_mode); ?> <br><br>
<?php print_r("Cart: ".$objDatosTransaccion->cart); ?> <br><br>
<?php print_r("Correo de quien paga: ".$objDatosTransaccion->payer->payer_info->email); ?> <br><br>
<?php print_r("Nombre de quien paga: ".$objDatosTransaccion->payer->payer_info->first_name); ?> <br><br>
<?php print_r("Apellido de quien paga: ".$objDatosTransaccion->payer->payer_info->last_name); ?> <br><br>
<?php print_r("PayerID: ".$objDatosTransaccion->payer->payer_info->payer_id); ?> <br><br>
<?php print_r("País: ".$objDatosTransaccion->payer->payer_info->country_code); ?> <br><br>
<?php print_r("Teléfono: ".$objDatosTransaccion->payer->payer_info->phone); ?> <br><br>
<?php print_r("Custom: ".$objDatosTransaccion->transactions[0]->custom); ?> <br><br>