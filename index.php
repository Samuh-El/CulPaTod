<?php
require __DIR__ . '/vendor/autoload.php';

$configuration = new Khipu\Configuration();
$configuration->setSecret('f4c0d221c20046c290f393504acc7f0ccf603f69');
$configuration->setReceiverId('313698');
$configuration->setPlatform('demo-client', '2.0');
//$configuration->setDebug(true);
$client = new Khipu\ApiClient($configuration);
$payments = new Khipu\Client\PaymentsApi($client);

echo "<br>declaro variables";

try {
    echo "<br>entro al try";
    $ops = array(
        "notify_url" => "https://culturaparatodos.herokuapp.com/demo-notify-js.php",
    );
    echo "<br>antes response";
    $response = $payments->paymentsPost('Pago de demo', 'CLP', 1000, $ops);
    echo "<br>despues response";

    echo "<br>PAYMENT_ID: " . $response->getPaymentId() . "\n";

} catch (Exception $e) {
    echo "<br>entro al catch 1";
    echo "<br>" . $e->getMessage();
}
////////////////////////
$notificationToken = $_REQUEST['notification_token'];
$client = new Khipu\ApiClient($configuration);
$payments = new Khipu\Client\PaymentsApi($client);
echo "<br>declaro variables 2<br>";

try {
    echo "<br>try 2<br>";
    $response = $payments->paymentsGet($notificationToken);
    echo "<br>paso response2<br>";

    print "PAYMENT_ID: " . $response->getPaymentId() . "\n";
    print "TRANSACTION_ID: " . $response->getTransactionId() . "\n";
    print "AMOUNT: " . $response->getAmount() . "\n";
    print "CURRENCY: " . $response->getCurrency() . "\n";
    print "STATUS: " . $response->getStatus() . "\n";

} catch (Exception $e) {
    echo "<br>entro al catch2<br>";
    echo $e->getMessage();
}
