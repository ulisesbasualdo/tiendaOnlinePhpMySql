<?php


require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();


//en caso que no se encuentre el token ni se le ponga id, o en caso de que 
// se altere el id o token, muestra el mensaje de error
$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if($id == '' || $token == ''){
    echo 'Error al procesar la petición';
    exit;
} else {
    $token_tmp = hash_hmac('sha256', $id, KEY_TOKEN);
    if($token == $token_tmp){
        $sql = $con->prepare("SELECT count(id) FROM products WHERE id=? AND activo=1");
        $sql->execute([$id]);
        if($sql->fetchColumn() > 0){
            $sql = $con->prepare("SELECT nombre, descripcion, precio, descuento, activo, imagen FROM products 
            WHERE id=? AND activo=1 LIMIT 1");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC); //nos va a traer lo que encontro
            $imagen = $row['imagen'];
            $nombre = $row['nombre'];
            $descripcion = $row['descripcion'];
            $precio = $row['precio'];
            $descuento = $row['descuento'];
            $precio_desc = $precio - (($precio * $descuento) / 100);
        } else{
          echo 'error al procesar la petición';
          exit;
        }
     
    } else{
        echo 'error al procesar la petición';
        exit;
    }
}



?>


<?php
include('templates/encabezado.php');
?>




  <main>
    <div class="container">
        <div class="row">
            <div class="col-md-6 order-md-1">
                <img class="img-fluid img-thumbnail"  src="data:image/jpg;base64,<?= base64_encode($imagen) ?>">
            </div>
            <div class="col-md-6 order-md-2">
                <h2><?php echo $nombre; ?></h2>
                <p class="lead">
                    <?php echo $descripcion; ?>
                </p>
                <?php if($descuento > 0){ ?>
                <p><del><?php echo MONEDA . number_format(($precio),2,'.',','); ?></del></p>
                <h2><?php echo MONEDA . number_format(($precio_desc),2,'.',','); ?>
                <small class="text-success"><?php echo '-'. $descuento?>% descuento</small>
                </h2>

                <?php } else { ?>
                    <h2><?php echo MONEDA . number_format(($precio),2,'.',','); ?></h2>

                <?php } ?>

                
                
                <div class="d-grid gap-3 col-10 mx-auto">
                <a href="pago.php" class="btn btn-primary" type="button" onclick="addProduct(<?php echo $id; ?>, '<?php echo $token_tmp; ?>')">Comprar ahora</a>
                <button class="btn btn-outline-primary" type="button" 
                onclick="addProduct(<?php echo $id; ?>, '<?php echo $token_tmp; ?>')">
                Agregar al carrito</button>
            </div>
            </div>
            
        </div>
    </div>

    

    <script src="js/script.js"></script>


        

    </body>