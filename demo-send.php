<?php
require __DIR__ . '/vendor/autoload.php';
include('constants.php');
//$_REQUEST['email']
if (!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)) {
	header('Location: index.php?invalid=true');
	return;
}

$configuration = new Khipu\Configuration();
$configuration->setReceiverId(RECEIVER_ID);
$configuration->setSecret(SECRET);
$configuration->setDebug(true);

$client = new Khipu\ApiClient($configuration);
$payments = new Khipu\Client\PaymentsApi($client);


try {
    $opts = array(
        "body" => "Pago del ticket de evento",
        "bank_id" => $_REQUEST['bankId'],
        "payer_email" => $_REQUEST['email'],
        "return_url" => RETURN_URL,
        "notify_url" => NOTIFY_URL,
        "notify_api_version" => "1.3"
    );
    $response = $payments->paymentsPost("Tiket de evento" //Motivo de la compra
        , "CLP" //Moneda
        , 5000.0 //Monto
        , $opts );

    header('Location: process.php?id='. $response->getPaymentId().'&url='.$response->getPaymentUrl().'&ready_for_terminal='.$response->getReadyForTerminal());
} catch (\Khipu\ApiException $e) {
    echo print_r($e->getResponseBody(), TRUE);
}