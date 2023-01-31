<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://www.paypal.com/sdk/js?client-id=AV_DD3V8QB3z3_p6PDkKBReAAxmExy7BjlYv2HNHmE7ij96C79LAjlv0KYnvr9A-1fl2gq440Z6wfj6O&currency=USD"></script>
</head>
<body>
  
  <div id="paypal-button-container"></div>
  <script>
    paypal.Buttons({
      style:{
        color: 'blue',
        label: 'pay'
      },
      createOrder: function(data,actions){
        return actions.order.create({
          purchase_units:[{
            amount:{
              value: 300
            }
          }]
        });
      },
      onApprove: function(data,actions){
        actions.order.capture().then(function(detalles){
          console.log(detalles)
          window.location.href="completed.php"
        });
      },

      onCancel: function(data){
        alert("Pago cancelado");
        console.log(data);
      }
    }).render('#paypal-button-container');
  </script>

</body>
</html>