<?php
require __DIR__ . '/vendor/autoload.php';

$configuration = new Khipu\Configuration();
$configuration->setSecret('f4c0d221c20046c290f393504acc7f0ccf603f69');
$configuration->setReceiverId('313698');
$configuration->setPlatform('demo-client', '2.0');
$notificationToken = trim(file_get_contents("../NOTIFICATION_TOKEN"));
# $configuration->setDebug(true);
$client = new Khipu\ApiClient($configuration);
$payments = new Khipu\Client\PaymentsApi($client);

try {
    $response = $payments->paymentsGet($notificationToken);

    print "PAYMENT_ID: " . $response->getPaymentId() . "\n";
    print "TRANSACTION_ID: " . $response->getTransactionId() . "\n";
    print "AMOUNT: " . $response->getAmount() . "\n";
    print "CURRENCY: " . $response->getCurrency() . "\n";
    print "STATUS: " . $response->getStatus() . "\n";

} catch (Exception $e) {
    echo $e->getMessage();
}
