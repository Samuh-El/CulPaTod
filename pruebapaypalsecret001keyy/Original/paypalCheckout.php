<?php 
	$email = $_REQUEST['email'];
	//echo $email;

	$idEspectaculo = $_REQUEST['idEspectaculo'];
	$valorTransaccion = $_REQUEST['valorTransaccion'];
	$nombreProducto = $_REQUEST['nombreProducto'];

	//echo "chekout".$idEspectaculo."<br>".$valorTransaccion."<br>".$nombreProducto;
?>

<input id = "1" type="hidden" name="titulo1" value="<?php echo $email; ?>">
<input id = "2" type="hidden" name="titulo2" value="<?php echo $idEspectaculo; ?>">
<input id = "3" type="hidden" name="titulo3" value="<?php echo $valorTransaccion; ?>">
<input id = "4" type="hidden" name="titulo4" value="<?php echo $nombreProducto; ?>">

<div id="paypal-button-container"></div>
<div id="paypal-button"></div>

<script src="https://www.paypalobjects.com/api/checkout.js"></script>

<script>

paypal.Button.render({ 
  env: '<?php echo PayPalENV; ?>',
  client: {
	<?php if(ProPayPal) { ?>  
	production: '<?php echo PayPalClientId; ?>'
	<?php } else { ?>
	sandbox: '<?php echo PayPalClientId; ?>'
	<?php } ?>	
  },

  payment: function (data, actions) {
	return actions.payment.create({
	  transactions: [{
		amount: {
		  total: '<?php echo $productPrice; ?>',
		  currency: '<?php echo $currency; ?>'
		}
	  }],
	});
  },

  // Extraer valor por id: document.getElementById("1").value
  onAuthorize: function (data, actions) {
	return actions.payment.execute()
	  .then(function () { 
		window.location = "<?php echo PayPalBaseUrl ?>orderDetails.php?paymentID="+data.paymentID+"&nombreProducto="+document.getElementById("4").value+"&valorTransaccion="+document.getElementById("3").value+"&email="+document.getElementById("1").value+"&payerID="+data.payerID+"&idEspectaculo="+document.getElementById("2").value+"&token="+data.paymentToken+"&pid=<?php echo $productId; ?>";
	  });
  }
	
}, '#paypal-button');
</script>