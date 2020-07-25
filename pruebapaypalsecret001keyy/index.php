<div id="paypal-button"></div>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
  paypal.Button.render({
    // Configure environment
    env: 'sandbox', // aqui cambiar sandbox o production dependiendo que se quiera
    client: {
      sandbox: 'Ac8wN2B7UvaIIK_FYkGr6JWy9_zII_Jtfrpx_zqs1z8Yrh9GqtxgerAZ8cTqznNjX8sdpTS8qfnw21fc',
      production: 'demo_production_client_id'
    },
    // Customize button (optional)
    locale: 'en_US',
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
            total: '1',
            currency: 'USD',
          },
          description: 'Ticket de evento en Cultura Para Todos.',
            custom:'123' // cuando procese el pago envie info del pago procesado
        }]
      });
    },
    // Execute the payment
    onAuthorize: function(data, actions) {
      return actions.payment.execute().then(function() {
        // Show a confirmation message to the buyer
            //window.alert('Thank you for your purchase!');
            //console.log(data);
            window.location="verificador.php?paymentToken="+data.paymentToken+"&paymentID="+data.paymentID;
      });
    }
  }, '#paypal-button');

</script>