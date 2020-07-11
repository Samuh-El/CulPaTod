<?php
require __DIR__ . '/vendor/autoload.php';
include('constants.php');
include('index.php');

/* Ver en consola log de heroku
heroku logs --app 'nombre_de_aplicacion'*/


$api_version = $_POST['api_version'];  // Parámetro api_version
$notification_token = $_POST['notification_token']; //Parámetro notification_token
//$idPago = $_GET['id']; // Obtener el id de pago generado
$amount = 5000;
$idEspectaculo = $_REQUEST['idEspectaculo'];

try {
  
    if ($api_version == '1.3') {
        echo "entro al if";
        //file_put_contents("php://stderr", "entro al if !!!".PHP_EOL);
        $configuration = new Khipu\Configuration();
        $configuration->setSecret(SECRET);
        $configuration->setReceiverId(RECEIVER_ID);
        $configuration->setDebug(true);
        // $configuration->getSecret();

        //file_put_contents("php://stderr", (string)$notification_token.PHP_EOL);

        $client = new Khipu\ApiClient($configuration);
        $payments = new Khipu\Client\PaymentsApi($client);
        
        $response = $payments->paymentsGet($notification_token);
        
        // Imprime todos los valores del token:
        file_put_contents("php://stderr", (string)$response.PHP_EOL);
        //$infoPago = (string)$response;
        
        foreach ($response as $key => $value) {
            file_put_contents("php://stderr", (string)$key.PHP_EOL);
            file_put_contents("php://stderr", (string)$value.PHP_EOL);
        }


        if ($response->getReceiverId() == RECEIVER_ID) {
            file_put_contents("php://stderr", "entro al if getReceiverID()".PHP_EOL);
            if ($response->getStatus() == 'done'
             //&& $response->getAmount() == $amount
            ) {
                //SI PASA QUIERE DECIR QUE SE HIZO TODO CORRECTO
                file_put_contents("php://stderr", "entro al if que inserta datos".PHP_EOL);
                // Insertar en BD:
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
                
                // Extrae datos de la variable RESPONSE
                $payment_idDB = $response["payment_id"];
                $notification_tokenDB = $response["notification_token"];
                $receiver_idDB = $response["receiver_id"];
                $bankDB = $response["bank"];
                $payer_nameDB = $response["payer_name"];
                $payer_emailDB = $response["payer_email"];
                $responsible_user_mailDB = $response["responsible_user_mail"];
                $payment_methodDB = $response["payment_method"];
                $run = $response["personal_identifier"];
                $valorTransaccionDB = $response["amount"];

                // Query a la DB
                // $sql = "INSERT INTO usuario (NombreUsuario,ClaveUsuario,direccion,celular,correo,infoPago) 
                // VALUES ('asd','asd','". $nuevoIdPago ."',123,'asd','". $idPago ."')";
                $sql ="INSERT INTO transaccion (runComprador,codigoTransaccion,fechaTransaccion,espectaculo_idEspectaculo,notification_token,receiver_id,bank,payer_name,payer_email,responsible_user_email,payment_method,valorTransaccion) 
                VALUES (
                    '".$run."','".$payment_idDB."',CURRENT_TIMESTAMP,$idEspectaculo,'".$notification_tokenDB."','".$receiver_idDB."','".$bankDB."','".$payer_nameDB."','".$payer_emailDB."','".$responsible_user_mailDB."','".$payment_methodDB."','".$valorTransaccionDB."'
                );";
                
                if ($conn->query($sql) === TRUE) {

                    //file_put_contents("php://stderr", "La query fue: ".$sql.PHP_EOL);
                    file_put_contents("php://stderr", "Registro agregado".PHP_EOL);
                } 
                else {
                    file_put_contents("php://stderr", "ERROR ENTRO AL ELSE".PHP_EOL);
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }

                $conn->close();
                
            }
        } 
        
        else {
            // receiver_id no coincide
            echo "// receiver_id no coincide";
        }
    } else {
        // Usar versión anterior de la API de notificación
        echo "// Usar versión anterior de la API de notificación";
    }
} catch (\Khipu\ApiException $exception) {
    print_r($exception->getResponseObject());
}