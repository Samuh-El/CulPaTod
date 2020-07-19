<title>Pago Paypal</title>


	<?php 
	//$orderNumber = 000999;

	if(!empty($_GET['paymentID']) && !empty($_GET['payerID']) && !empty($_GET['token']) && !empty($_GET['pid']) )
	{
		$paymentID = $_GET['paymentID'];
		$payerID = $_GET['payerID'];
		$token = $_GET['token'];
		$pid = $_GET['pid']; // Producto ID
		$email = $_REQUEST['email'];

		$idEspectaculo = $_REQUEST['idEspectaculo'];
		$valorTransaccion = $_REQUEST['valorTransaccion'];
		$nombreProducto = $_REQUEST['nombreProducto'];

		//echo $idEspectaculo."<br>".$valorTransaccion."<br>".$nombreProducto;
		?>
		


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

					<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

					<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
					<script src="atmosphere.js"></script>
					<script src="//storage.googleapis.com/installer/khipu-0.1.js"></script>

				</head>

				<body style="background-color:black;">
					<div class="container mt-5" >

							<div style="text-align:center;margin-left:20%;margin-right:20%;">
								<h4 style="color:white;font-weight: bold;">¡MUCHAS GRACIAS POR TU COMPRA!</h4>
								<hr style="background-color: white;">
							</div>

						<div class="pt-4 pb-3 mt-5 mb-5" style="background-color: #332C2C;">
							<div style="margin-left:10%;margin-right:10%;"> 
								<h6 class="mb-3" style="color:white;text-align:center">Se enviará un correo con el comprobante de pago, similar a la siguiente imagen</h6>
								<img style="height: 100%;
								width: 100%;" class="mb-4" src="http://www.imagenespc.productochile.cl/ejemploCorreo.jpg" alt=""> 
									<ul>
										<li style="color: white"><h6 style="color:white">Al momento de ingresar a la sala el día y hora del evento, se solicitará el <span style="color:rgb(216, 133, 133) !important;">código de verificación sin guiones</span> y el correo electrónico que proporcionaste para realizar esta compra.</h6></li>
										<li style="color: white"><h6 style="color:white">Recuerda que sin estos datos no podras entrar, por lo que es importante que no borres por error el comprobante de pago de tu bandeja.</h6></li>
										<li style="color: white"><h6 style="color:white">Verifique su carpeta de spam en caso de que la configuración de tu correo no permita que llegue a la bandeja de entrada.</h6></li>
									</ul>

								<form action="http://culturaparatodos.cl/#/">
									<div class="mt-4 mb-4" style="text-align:center">
													
										<button type="submit" class="btn btn-info" style="background-color: rgb(98, 110, 175);border:0px !important">Volver al inicio</button>
									</div>
								</form>

							</div>
						</div>
					</div>


					<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
					<!-- <script src="js/bootstrap.min.js"></script>
					<script src="js/docs.min.js"></script> -->
					<!-- JS, Popper.js, and jQuery -->
					<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
					<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
					<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
				</body>
			</html>








		<!-- <div class="alert alert-success">
		  <strong>COMPLETO!</strong> <br>Se terminó de pagar lo tuyo machucao
		</div> -->

		<!-- <table>       
			<tr>
			  <td>Payment Id:  <?php echo $paymentID; ?></td>
			  <td>Payer Id: <?php echo $payerID; ?></td>
			  <td>product Id: <?php echo $pid; ?></td>
			  <td>Token: <?php echo $token; ?></td>
			  <td>Correo: <?php echo $email; ?></td>
			</tr>       
		</table> -->

		
		<?php	
			$servername = "190.107.177.34";
			$username = "producto_Samuel";
			$password = "*XN5GXmkn(-N";
			$dbname = "producto_cultura";

			// Create connection
			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn->connect_error) {
				die("Falló conexión: " . $conn->connect_error);
			}
			
			$sql ="INSERT INTO transaccion (runComprador,codigoTransaccion,fechaTransaccion,espectaculo_idEspectaculo,notification_token,receiver_id,bank,payer_name,payer_email,responsible_user_email,payment_method,valorTransaccion) 
			VALUES (
				'paypal','".$paymentID."',CURRENT_TIMESTAMP,'".$idEspectaculo."','".$token."',0,'0','0','".$email."','0','0','".$valorTransaccion."'
			);";
			
			if ($conn->query($sql) === TRUE) {

				//file_put_contents("php://stderr", "La query fue: ".$sql.PHP_EOL);
				//file_put_contents("php://stderr", "Registro agregado".PHP_EOL);
			} 
			else {
				//file_put_contents("php://stderr", "ERROR ENTRO AL ELSE".PHP_EOL);
				echo "Error: " . $sql . "<br>" . $conn->error;
			}

			$conn->close();
	} 
	
	else {
		// En caso de error...
		//file_put_contents("php://stderr", "ERROR PERO ENTERO FILETIAO".PHP_EOL);
		
		header('Location: pantallaError.php'); 
		//header('Location:index.php');
		//echo "no tranza hno<br>hasta la proximaaa!";
	}
	?>

