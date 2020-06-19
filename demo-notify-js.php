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

        //file_put_contents("php://stderr", (string)$notification_token.PHP_EOL);

        $client = new Khipu\ApiClient($configuration);
        $payments = new Khipu\Client\PaymentsApi($client);
        
        $response = $payments->paymentsGet($notification_token);
        
        // Imprime todos los valores del token:
        file_put_contents("php://stderr", "Fuera del FOREACH: " . (string)$response.PHP_EOL);
        foreach ($response as $key => $value) {
            file_put_contents("php://stderr", (string)$key.PHP_EOL);
            file_put_contents("php://stderr", (string)$value.PHP_EOL);
        }

        if ($response->getReceiverId() == RECEIVER_ID) {
            if ($response->getStatus() == 'done'
             && $response->getAmount() == $amount
            ) {
                // file_put_contents("php://stderr", "paso message !!!".PHP_EOL);
                // $headers = 'From: "Comercio de prueba" <no-responder@khipu.com>' . "\r\n";
                // $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                // $subject = 'La compra de prueba funciona';
                // $body = <<<EOF
                // Hola<br/>
                // <br/>
                // <p>
                // Recibes este correo pues el pago de prueba fue conciliado por khipu
                // </p>

                // EOF;

                //file_put_contents("php://stderr", "paso email params!!!".PHP_EOL);
                //mail($response->getPayerEmail(), $subject, $body, $headers);
                //file_put_contents("php://stderr", "paso email sended!!!".PHP_EOL);
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