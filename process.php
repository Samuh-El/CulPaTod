<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="images/favicon.ico">

	<title>Comprueba tu orden y realiza el pago.</title>


	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">


	<!-- Bootstrap core CSS -->
	<!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->

	<!-- Custom styles for this template -->
	<!-- <link href="css/cover.css" rel="stylesheet"> -->

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="//storage.googleapis.com/installer/khipu-2.0.js"></script>

</head>

<body style="background-color:black;">

<div class="container mt-5" >

<div style="text-align:center;margin-left:20%;margin-right:20%;">
<h4 style="color:white;font-weight: bold;">¡TODO LISTO PARA PAGAR!</h4>
<hr style="background-color: white;">
</div>
<div class="pt-4 pb-3 mt-5" style="background-color: #332C2C;margin-left:20%;margin-right:20%;">
<div style="margin-left:10%;margin-right:10%;">
<p style="color:rgb(173, 173, 173)">Tenemos todo preparado para realizar tu compra. Presiona el boton de abajo para ser redireccionado a la página de Khipu para concretar tu pago.</p>

				<div class="start-khipu" style="text-align:center">
					<img style="cursor:pointer;" src="https://s3.amazonaws.com/static.khipu.com/buttons/2015/200x75-transparent.png" id="pay-button"/>

</div>

				
				</div>
				</div>		
				</div>
<div id="khipu-chrome-extension-div"></div>
<script>
	window.onload = function () {
		KhipuLib.startKhipu('<?php echo $_GET['url'];?>','<?php echo $_GET['id'];?>','<?php echo $_GET['ready_for_terminal'];?>', '#pay-button');
	}
</script>
<!-- <script src="js/bootstrap.min.js"></script>
<script src="js/docs.min.js"></script> -->
<!-- JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>



