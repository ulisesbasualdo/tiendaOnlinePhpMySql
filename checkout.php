<?php


require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
//en caso de exista sesion la vamos a recibir, en caso que no le agregamos null

$lista_carrito = array();

if ($productos != null) {
    foreach ($productos as $clave => $cantidad) {
        $sql = $con->prepare("SELECT id,nombre,precio,descuento,imagen,$cantidad AS cantidad FROM products WHERE id=? AND activo=1");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC); //lo va a asociar mediante el nombre de columna
    } //es solo fetch y no fetch all porque va a traer producto por producto
}

?>


<?php
include('templates/encabezado.php');
?>

<main>

    <!-- Modal -->
    <div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="eliminaModalLabel">Alerta</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Desea eliminar el producto de la lista?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button id="btn-elimina" type="button" class="btn btn-danger" onclick="eliminar()">Eliminar</button>
                </div>
            </div>
        </div>
    </div>



    <div class="container">
        <div class="table-response">
            <div class="table-responsive">
                <table class="table table-primary">
                    <thead>
                        <tr>
                            <th scope="col">Producto</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($lista_carrito == null) {
                            echo '<tr><td colspan="5" class="text-center"><b>Lista vacia</b></td></tr>';
                        } else {
                            $total = 0;
                            foreach ($lista_carrito as $productos) {
                                $_id = $productos['id'];
                                $nombre = $productos['nombre'];
                                $precio = $productos['precio'];
                                $descuento = $productos['descuento'];
                                $cantidad = $productos['cantidad'];
                                $precio_desc = $precio - (($precio * $descuento) / 100);
                                $subtotal = $cantidad * $precio_desc;
                                $total += $subtotal;
                                ?>


                                <tr class="">
                                    <td>
                                        <?php echo $nombre; ?>
                                    </td>
                                    <td>
                                        <?php echo MONEDA . number_format($precio_desc, 2, '.', ','); ?>
                                    </td>
                                    <td><input type="number" min="1" max="19" step="1" value="<?php echo $cantidad ?>" size="5"
                                            id="cantidad_<?php echo $_id; ?>"
                                            onchange="actualizaCantidad(this.value, <?php echo $_id; ?>)">
                                    </td>
                                    <td>
                                        <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]">
                                            <?php echo MONEDA . number_format($subtotal, 2, '.', ','); ?></div>
                                    </td>
                                    <td><a href="#" id="eliminar" class="btn btn-warning btn-sm" data-bs-id="<?php
                                    echo $_id; ?>" data-bs-toggle="modal" data-bs-target="#eliminaModal">Eliminar</a>
                                    </td>
                                </tr>
                            <?php } ?>

                            <tr>
                                <td colspan="3"></td>
                                <td colspan="2">
                                    <p class="h3" id="total">
                                        <?php echo MONEDA . number_format($total, 2, '.', ',');
                                        ?>
                                    </p>
                                </td>
                            </tr>

                        </tbody>
                    <?php } ?>
                </table>
            </div>

            <?php if ($lista_carrito != null) { ?>
                <div class="row">
                    <div class="col-md-5 offset-md-7 d-grid gap-2">
                        <a href="pago.php"><button class="btn btn-primary btn-lg">Realizar pago</button></a>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>


</main>

<script src="js/script.js"></script>
</body>

</html>