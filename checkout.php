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
}




// session_destroy();

// print_r($_SESSION);

?>


<?php

include("conexion.php");
$con = conectar(); //llamando la conexion
$sql = "SELECT * FROM products";
$query = mysqli_query($con, $sql); //ejecutar la consulta

$row = mysqli_fetch_array($query); //dirigir a esa tabla especifica


function listarArchivos($con)
{
    $sql = "SELECT * FROM products";
    $query = mysqli_query($con, $sql);
    return $query;
}


?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>

        <div class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a href="#" class="navbar-brand">

                    <strong>Tienda Online</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader"
                    aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navbarHeader">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="#" class="nav-link active">Catálogo</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Contacto</a>
                    </li>
                </ul>
                <a href="carrito.php" class="btn btn-primary">
                    Carrito<span id="num_cart" class="badge bg-secondary">
                        <?php echo $num_cart; ?>
                    </span></a>
            </div>
        </div>
    </header>
    <main>



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
                                <td><?php echo MONEDA . number_format($precio_desc,2, '.', ','); ?></td>
                                <td><input type="number" min="1" max="19" step="1" value="<?php echo $cantidad ?>"
                                size="5" id="cantidad_<?php echo $_id; ?>" onchange="">
                                </td>
                                <td><div id="subtotal_<?php echo $_id; ?>" name="subtotal[]">
                                <?php echo MONEDA . number_format($subtotal,2, '.', ','); ?></div>
                                </td>
                                <td><a href="#" id="eliminar" class="btn btn-warning btn-sm" data-bs-id="<?php
                                echo $id; ?>" data-bs-toogle="modal" data-bs-target="eliminaModal">Eliminar</a>
                                </td>
                            </tr>
                            <?php } ?>

                            <tr>
                                 <td colspan="3"></td>
                                 <td colspan="2">
                                    <p class="h3" id="total"><?php echo MONEDA . number_format($total, 2, '.', ',');
                                    ?></p>           
                                </td>
                            </tr>

                        </tbody>
                        <?php } ?>
                    </table>
                </div>

                <div class="row">
                    <div class="col-md-5 offset-md-7 d-grid gap-2">
                        <button class="btn btn-primary btn-lg">Realizar pago</button>
                    </div>
                </div>            
            
                
            </div>
        </div>


    </main>

    <script src="js/script.js"></script>
</body>

</html>