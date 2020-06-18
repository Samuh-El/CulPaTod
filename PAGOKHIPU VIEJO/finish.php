<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="images/favicon.ico">

	<title>Tu pago se encuentra en verificaci&oacute;n.</title>

	<!-- Bootstrap core CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="css/cover.css" rel="stylesheet">

	<!-- Just for debugging purposes. Don't actually copy this line! -->
	<!--[if lt IE 9]>
	<script src="js/ie8-responsive-file-warning.js"></script><![endif]-->

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="atmosphere.js"></script>
	<script src="//storage.googleapis.com/installer/khipu-0.1.js"></script>

</head>

<body>

<?php
require __DIR__ . '/vendor/autoload.php';
include('constants.php');

try 
{
    $receiver_id = 313698;
    $secret = 'f4c0d221c20046c290f393504acc7f0ccf603f69';
    $api_version = '2.0';  // Parámetro api_version
    $amount = 5000;

    //$notificationToken = $_POST["notification_token"];

    $configuration = new Khipu\Configuration();
    $configuration->setSecret('f4c0d221c20046c290f393504acc7f0ccf603f69');
    $configuration->setReceiverId('313698');
    $configuration->setPlatform('demo-client','2.0');
    $notificationToken = trim(file_get_contents("../notification_token"));
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
    } 
    
    catch (Exception $e) 
    {
        echo $e->getMessage();
    }

    // INSERTAR DATOS EN DB
    // Datos de conexión
    $servername = "190.107.177.34";
    $database = "producto_chile";
    $username = "producto_Samuel";
    $password = "S@muel01";
    $response = "prueba";

    // Crear conexión
    $conn = mysqli_connect($servername, $username, $password, $database);
    // Comprueba conexión
    if (!$conn) {
        die("<br>Falló conexión: " . mysqli_connect_error());
    }
    else
    {
        echo "<br>Conexión completa";
        // Insertar datos
        $sql = "INSERT INTO usuario (NombreUsuario,ClaveUsuario,direccion,celular,correo) VALUES
        ('pruebaphp','pruebaphp','pruebaphp','pruebaphp','pruebaphp')";            

        if ($conn->query($sql) === TRUE) 
        {
            echo "<br>Registro agregado";
        } 
        else 
        {
            echo "<br>Error: " . $sql . "<br>" . $conn->error;
        }
    }
    mysqli_close($conn);
    /////////////////////////////////////////////////////
}

catch(Exception $e)
{

}
?>

<div class="site-wrapper">

	<div class="site-wrapper-inner">

		<div class="cover-container">

			<div class="masthead clearfix">
				<div class="inner">
					<h3 class="masthead-brand">Comercio de ejemplo</h3>
					<ul class="nav masthead-nav">
						<li class="active"><a href="#">Home</a></li>
						<li><a href="#">Features</a></li>
						<li><a href="#">Contact</a></li>
					</ul>
				</div>
			</div>

			<div class="inner cover">


				<h1 class="cover-heading">Gracias!, tu pago está en verificación.</h1>

				<p>En cuanto el pago sea verificador por khipu, te llegar&aacute; un correo de confirmaci&oacute;n</p>

			</div>

			<div class="mastfoot">
				<div class="inner">
					<p>Cover template for <a href="http://getbootstrap.com">Bootstrap</a>,
						by <a href="https://twitter.com/mdo">@mdo</a>.</p>
				</div>
			</div>

		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/docs.min.js"></script>
</body>
</html>