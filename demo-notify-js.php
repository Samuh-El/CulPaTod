<?php

require __DIR__ . '/vendor/autoload.php';
include('constants.php');

/* Ver en consola log de heroku
heroku logs --app 'nombre_de_aplicacion'*/

$api_version = $_POST['api_version'];  // Parámetro api_version
$notification_token = $_POST['notification_token']; //Parámetro notification_token

$paymentId = $_GET['id']; // Obtener el id de pago generado

// GET -> Query Params -> www.hola.com/hola?queryParam=valor
// POST -> ??? Body -> 
// REQUEST -> ???+-

$amount = 5000;
// file_put_contents("php://stderr", "sending push !!!".PHP_EOL);
// file_put_contents("php://stderr", (string)$paymentId.PHP_EOL);

try {
    if ($api_version == '1.3') {
        //file_put_contents("php://stderr", "paso push !!!".PHP_EOL);
        $configuration = new Khipu\Configuration();
        $configuration->setSecret(SECRET);
        $configuration->setReceiverId(RECEIVER_ID);
        $configuration->setDebug(true);
        // $configuration->getSecret();
        $valoresToken="";

        //file_put_contents("php://stderr", (string)$notification_token.PHP_EOL);

        $client = new Khipu\ApiClient($configuration);
        $payments = new Khipu\Client\PaymentsApi($client);
        
        $response = $payments->paymentsGet($notification_token);
        
        // Imprime todos los valores del token:
        //file_put_contents("php://stderr", "Fuera del FOREACH: " . (string)$response.PHP_EOL);
        
        foreach ($response as $key => $value) {
            file_put_contents("php://stderr", (string)$key.PHP_EOL);
            file_put_contents("php://stderr", (string)$value.PHP_EOL);
        }

        if ($response->getReceiverId() == RECEIVER_ID) {
            if ($response->getStatus() == 'done'
             && $response->getAmount() == $amount
            ) {
                 file_put_contents("php://stderr", "PASO EL DONE <br>". (string)$notification_token .PHP_EOL);

            }
        } else {
            // receiver_id no coincide
        }
    } else {
        // Usar versión anterior de la API de notificación
    }
} catch (\Khipu\ApiException $exception) {
    print_r($exception->getResponseObject());
}