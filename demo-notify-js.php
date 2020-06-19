<?php
require __DIR__ . '/vendor/autoload.php';
include('constants.php');

/* Ver en consola log de heroku
heroku logs --app 'nombre_de_aplicacion'*/

$api_version = $_POST['api_version'];  // Parámetro api_version
$notification_token = $_POST['notification_token']; //Parámetro notification_token
$idPago = $_GET['id']; // Obtener el id de pago generado

// GET -> Query Params -> www.hola.com/hola?queryParam=valor
// POST -> Body -> 
// REQUEST -> ???

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
        file_put_contents("php://stderr", (string)$response.PHP_EOL);
        
        foreach ($response as $key => $value) {
            file_put_contents("php://stderr", (string)$key.PHP_EOL);
            file_put_contents("php://stderr", (string)$value.PHP_EOL);
        }


        if ($response->getReceiverId() == RECEIVER_ID) {
            if ($response->getStatus() == 'done'
             && $response->getAmount() == $amount
            ) {
                //SI PASA QUIERE DECIR QUE SE HIZO TODO CORRECTO
                // file_put_contents("php://stderr", "paso message !!!".PHP_EOL);
                // Insertar en BD:
                $servername = "190.107.177.34";
                $username = "producto_Samuel";
                $password = "S@muel01";
                $dbname = "producto_chile";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);
                // Check connection
                if ($conn->connect_error) {
                die("Falló conexión: " . $conn->connect_error);
                }

                $query1 = "INSERT INTO usuario (NombreUsuario,ClaveUsuario,direccion,celular,correo,idpago) VALUES ('asd','asd','asd',123,'asd','";
                $query2="')";
                
                $sql= $query1 . $idPago . $query2;

                if ($conn->query($sql) === TRUE) {
                    echo "Registro insertado";
                    file_put_contents("php://stderr", "La query fue: ".$sql.PHP_EOL);
                    file_put_contents("php://stderr", "Registro agregado".PHP_EOL);
                } 
                else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }

                $conn->close();
                
            }
        } 
        
        else {
            // receiver_id no coincide
        }
    } else {
        // Usar versión anterior de la API de notificación
    }
} catch (\Khipu\ApiException $exception) {
    print_r($exception->getResponseObject());
}