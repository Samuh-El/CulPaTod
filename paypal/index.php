<?php
    $idEspectaculo = $_REQUEST['idEspectaculo'];
    $valorTransaccion = $_REQUEST['valorTransaccion'];
    $nombreProducto = $_REQUEST['nombreProducto'];
    $valorint;
    $idEspectaculoInt;

    try {
        $valorint=(int)$valorTransaccion;
        $idEspectaculoInt=(int)$idEspectaculo;
        if($valorint<=0.9 || $idEspectaculoInt<=0){
            header('Location: pantallaError.php');
        }
    } catch (Exception $e) {
        header('Location: pantallaError.php');
    }
    
    if ($idEspectaculo== null || $idEspectaculo=="" || $idEspectaculo=='0' ||
    $valorTransaccion== null || $valorTransaccion=="" || $valorTransaccion=='0' ||
    $nombreProducto== null || $nombreProducto=="" || $nombreProducto=='0')
    {
         header('Location: pantallaError.php');
    }
    //echo "id espectaculo: ".$idEspectaculo."<br>valor transaccion: ".$valorTransaccion."<br>Nombre producto: ".$nombreProducto;
?>

<?php
  $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-';
  
  function generate_string($input, $strength = 16) {
      $input_length = strlen($input);
      $random_string = '';
      for($i = 0; $i < $strength; $i++) {
          $random_character = $input[mt_rand(0, $input_length - 1)];
          $random_string .= $random_character;
      }
  
      return $random_string;
  }
  
  $idRandom = generate_string($permitted_chars, 10);
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

          <title>Pago Paypal</title>
          

          <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">


          <!-- Bootstrap core CSS -->
          <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->

          <!-- Custom styles for this template -->
          <!-- <link href="css/cover.css" rel="stylesheet"> -->

          <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
          
     </head>

     <body style="
     overflow-x: hidden !important;
     width:100%;
     height: 100%;
     background-image: url(img/imagenFondo.jpg);
     background-repeat: no-repeat; 
     background-attachment: fixed;
     background-size: cover;">

          <div class="container mt-5" >

               <div style="text-align:center;margin-left:20%;margin-right:20%;">
                    <h4 style="color:white;font-weight: bold;">¡TODO LISTO!</h4>
                    <hr style="background-color: white;">
               </div>
               
               <div class="pt-4 pb-3 mt-5" style="background-color: rgb(20,20,20,0.8);margin-left:20%;margin-right:20%;">
                    <div style="margin-left:10%;margin-right:10%;">
                         <p style="color:rgb(173, 173, 173)">Tenemos todo preparado para realizar tu compra. Presiona el siguiente boton , el cual abrira una nueva pantalla emergente donde podras concretar tu pago.</p>
                              <div style="text-align:center">
                              <div id="paypal-button"></div>
                              </div>           
                    </div>
               </div>		
          </div>
     
          
          <!-- JS, Popper.js, and jQuery -->
          <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
          <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
          <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
     </body>
</html>



<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
  paypal.Button.render({
    // Configure environment
    env: 'production', // aqui cambiar sandbox o production dependiendo que se quiera
    client: {
      sandbox: 'Ac8wN2B7UvaIIK_FYkGr6JWy9_zII_Jtfrpx_zqs1z8Yrh9GqtxgerAZ8cTqznNjX8sdpTS8qfnw21fc',
      production: 'AVaNsxw5yj0CKf9vfNo0Nnx-slAracjCnT_HGlopLT8mY9-kUbXdbx8d8WBYbKKhf6kAFPaNHM823kS6'
    },

    // Customize button (optional)
    locale: 'es_US',
    style: {
      size: 'small',
      color: 'gold',
      shape: 'pill',
    },

    // Enable Pay Now checkout flow (optional)
    commit: true,

    // Set up a payment
    payment: function(data, actions) {
      return actions.payment.create({
        transactions: [{
          amount: {
            total: "<?php echo($valorTransaccion); ?>",
            currency: 'USD'
          },
            description: 'Ticket de evento en Cultura Para Todos. CÓDIGO ACCESO: '+ "<?php echo($idRandom); ?>",
            custom:"<?php echo($nombreProducto); ?>", // cuando procese el pago envie info del pago procesado           
        }]
      });
    },
    // Execute the payment
    onAuthorize: function(data, actions) {
      return actions.payment.execute().then(function() {
        // Show a confirmation message to the buyer
            //window.alert('Thank you for your purchase!');
            //console.log(data);
            window.location="verificador.php?paymentToken="+data.paymentToken+"&paymentID="+data.paymentID+"&idRandom="+"<?php echo($idRandom); ?>"+"&idEspectaculo="+"<?php echo($idEspectaculo); ?>";
      });
    }
  }, '#paypal-button');

</script>