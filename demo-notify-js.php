<?php

require __DIR__ . '/vendor/autoload.php';
include('constants.php');

$api_version = $_POST['api_version'];  // Parámetro api_version
$notification_token = $_POST['notification_token']; //Parámetro notification_token

$amount = 5000;

foreach ($_POST as $key => $value) {
    echo "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";
}

foreach ($_REQUEST as $key => $value) {
    echo "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";
}

try {
    if ($api_version == 'api_version') {
        $configuration = new Khipu\Configuration();
        $configuration->setSecret(SECRET);
        $configuration->setReceiverId(RECEIVER_ID);
        //$configuration->setDebug(true);

        $client = new Khipu\ApiClient($configuration);
        $payments = new Khipu\Client\PaymentsApi($client);

        $response = $payments->paymentsGet($notification_token);
        if ($response->getReceiverId() == RECEIVER_ID) {
            if ($response->getStatus() == 'done' && $response->getAmount() == $amount) {
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