<?php


require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
//en caso de exista sesion la vamos a recibir, en caso que no le agregamos null

$lista_carrito = array();

if($productos != null){
    foreach($productos as $clave => $cantidad){
        $sql = $con->prepare("SELECT id,nombre,precio,descuento,imagen,$cantidad AS cantidad FROM products WHERE id=? AND activo=1");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC); //lo va a asociar mediante el nombre de columna
    } //es solo fetch y no fetch all porque va a traer producto por producto
} else {
    header("Location: index.php");
    exit;
}




// session_destroy();

// print_r($_SESSION);

?>


<?php
include('templates/encabezado.php');
?>



<br>

        <div class="container">
            <div class="row">
                <div class="col-6">
                    <h4>Detalles de pago</h4>
                    <div id="paypal-button-container"></div>
                </div>

            <div class="col-6">
            


            <div class="table-response">
                <div class="table-responsive">
                    <table class="table table-primary">
                        <thead>
                            <tr>
                                <th scope="col">Producto</th>
                                <th scope="col">Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($lista_carrito == null){
                                echo '<tr><td colspan="5" class="text-center"><b>Lista vacia</b></td></tr>';
                            } else {
                                $total = 0;
                                foreach($lista_carrito as $productos){
                                    $_id = $productos['id'];
                                    $nombre = $productos['nombre'];
                                    $precio = $productos['precio'];
                                    $descuento = $productos['descuento'];
                                    $cantidad = $productos['cantidad'];
                                    $precio_desc = $precio - (($precio * $descuento)/100);
                                    $subtotal = $cantidad * $precio_desc;
                                    $total += $subtotal;
                                ?>

                                
                            <tr class="">
                                <td><?php echo $nombre; ?></td>
                                <td><div id="subtotal_<?php echo $_id; ?>" name="subtotal[]">
                                <?php echo MONEDA . number_format($subtotal,2, '.', ','); ?></div>
                                </td>
                            </tr>
                            <?php } ?>

                            <tr>
                                 <td colspan="2">
                                    <p class="h3 text-end" id="total"><?php echo MONEDA . number_format($total, 2, '.', ',');
                                    ?></p>           
                                </td>
                            </tr>

                        </tbody>
                        <?php } ?>
                    </table>
                </div>

                           
            
                
            </div>
        </div>
        </div>
        </div>

    </main>

    <script src="js/script.js"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENT_ID; ?>&currency=<?php echo CURRENCY; ?>"></script>
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
              value: <?php echo $total; ?>
            }
          }]
        });
      },
      onApprove: function(data,actions){
        let URL = 'clases/captura.php'
        actions.order.capture().then(function(detalles){
          console.log(detalles)

          let url = 'clases/captura.php'

          return fetch(url, {
            method: 'post',
            headers: {
                'content-type': 'aplication/json'
            },
            body: JSON.stringify({
                detalles: detalles
            })
          }).then(function(response){
            window.location.href = "completado.php?key=" + detalles['id']
          })
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