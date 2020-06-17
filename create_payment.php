<?php
require __DIR__ . '/vendor/autoload.php';

$configuration = new Khipu\Configuration();
$configuration->setSecret('f4c0d221c20046c290f393504acc7f0ccf603f69');
$configuration->setReceiverId('313698');
$configuration->setPlatform('demo-client', '2.0');
# $configuration->setDebug(true);
$client = new Khipu\ApiClient($configuration);
$payments = new Khipu\Client\PaymentsApi($client);

try {
    $ops = array(
        "notify_url" => "https://culturaparatodos.herokuapp.com/demo-notify-js.php",
        "transaction_id" => "TX-1234",
    );
    $response = $payments->paymentsPost('Pago de demo', 'CLP', 1000, $ops);

    print "PAYMENT_ID: " . $response->getPaymentId() . "\n";

} catch (Exception $e) {
    echo $e->getMessage();
}
