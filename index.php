<?php
require __DIR__ . '/vendor/autoload.php';

$configuration = new Khipu\Configuration();
$configuration->setSecret('f4c0d221c20046c290f393504acc7f0ccf603f69');
$configuration->setReceiverId('313698');
$configuration->setPlatform('demo-client', '2.0');
$configuration->setDebug(true);
$client = new Khipu\ApiClient($configuration);
$payments = new Khipu\Client\PaymentsApi($client);

echo "declaro variables";

try {
    echo "entro al try";
    $ops = array(
        "notify_url" => "https://culturaparatodos.herokuapp.com/",
        "transaction_id" => "TX-1234",
    );
    echo "antes response";
    $response = $payments->paymentsPost('Pago de demo', 'CLP', 1000, $ops);
    echo "despues response";

    echo "PAYMENT_ID: " . $response->getPaymentId() . "\n";

} catch (Exception $e) {
    echo $e->getMessage();
}
////////////////////////
$notificationToken = trim(file_get_contents("../NOTIFICATION_TOKEN"));
$client = new Khipu\ApiClient($configuration);
$payments = new Khipu\Client\PaymentsApi($client);
echo "declaro variables 2";

try {
    echo "try 2";
    $response = $payments->paymentsGet($notificationToken);

    print "PAYMENT_ID: " . $response->getPaymentId() . "\n";
    print "TRANSACTION_ID: " . $response->getTransactionId() . "\n";
    print "AMOUNT: " . $response->getAmount() . "\n";
    print "CURRENCY: " . $response->getCurrency() . "\n";
    print "STATUS: " . $response->getStatus() . "\n";

} catch (Exception $e) {
    echo $e->getMessage();
}
