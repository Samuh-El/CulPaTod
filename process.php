<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="images/icon.png">

	<title>Pago Khipu</title>

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

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="//storage.googleapis.com/installer/khipu-2.0.js"></script>

</head>

<body>


<div class="site-wrapper">

	<div class="site-wrapper-inner">

		<div class="cover-container">

			<div class="masthead clearfix">
				<div class="inner">
					
				</div>
			</div>

			<div class="inner cover">


				<h1 class="cover-heading" style="font-family: 'Montserrat', sans-serif;">Khipu</h1>

				<p style="font-family: 'Averia Serif Libre', cursive;">Presiona el botón para proceder al pago con Khipu.</p>

				<br><br><br>
				<div class="col-sm-offset-4 start-khipu">
					<img src="https://s3.amazonaws.com/static.khipu.com/buttons/2015/200x75-transparent.png" id="pay-button"/>
				</div>
			</div>

			<div class="mastfoot">
				
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
<script src="js/bootstrap.min.js"></script>
<script src="js/docs.min.js"></script>
</body>
</html>



