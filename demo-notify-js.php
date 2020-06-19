<?php

require __DIR__ . '/vendor/autoload.php';
include('constants.php');

$api_version = $_POST['api_version'];  // Parámetro api_version
$notification_token = $_POST['notification_token']; //Parámetro notification_token

$amount = 5000;
file_put_contents("php://stderr", "sending push !!!".PHP_EOL);

try {
    if ($api_version == '1.3') {
        file_put_contents("php://stderr", "paso push !!!".PHP_EOL);
        $configuration = new Khipu\Configuration();
        $configuration->setSecret(SECRET);
        $configuration->setReceiverId(RECEIVER_ID);
        $configuration->setDebug(true);
        // $configuration->getSecret();

        file_put_contents("php://stderr", (string)$notification_token.PHP_EOL);

        $servername = "190.107.177.34";
        $username = "producto_Samuel";
        $password = "S@muel01";
        $dbname = "producto_chile";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = `INSERT into usuario (NombreUsuario,ClaveUsuario,direccion,celular,correo) VALUES (
    'ASD','ASD','ASD',123,'` . (string)$notification_token . `')`;

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

        $client = new Khipu\ApiClient($configuration);
        $payments = new Khipu\Client\PaymentsApi($client);

        $response = $payments->paymentsGet($notification_token);
        if ($response->getReceiverId() == RECEIVER_ID) {
            if ($response->getStatus() == 'done'
            //  && $response->getAmount() == $amount
            ) {
                $headers = 'From: "Comercio de prueba" <no-responder@khipu.com>' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $subject = 'La compra de prueba funciona';
                $body = <<<EOF
Hola<br/>
<br/>
<p>
Recibes este correo pues el pago de prueba fue conciliado por khipu
</p>

EOF;
                mail($response->getPayerEmail(), $subject, $body, $headers);
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