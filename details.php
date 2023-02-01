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
            $sql = $con->prepare("SELECT nombre, descripcion, precio, descuento, imagen FROM products 
            WHERE id=? AND activo=1 LIMIT 1");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC); //nos va a traer lo que encontro
            $imagen = $row['imagen'];
            $nombre = $row['nombre'];
            $descripcion = $row['descripcion'];
            $precio = $row['precio'];
            $descuento = $row['descuento'];
            $precio_desc = $precio - (($precio * $descuento) / 100);
        }
     
    } else{
        echo 'error al procesar la petición';
        exit;
    }
}



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
        <a href="cart.php" class="btn btn-primary">Carrito</a>
      </div>
    </div>
  </header>
  <main>
    <div class="container">
        <div class="row">
            <div class="col-md-6 order-md-1">
                <img src="data:image/jpg;base64,<?= base64_encode($imagen) ?>">
            </div>
            <div class="col-md-6 order-md-2">
                <h2><?php echo $nombre; ?></h2>
                <?php if($descuento > 0){ ?>}
                <p><del><?php echo MONEDA . number_format(($precio),2,'.',','); ?></del></p>
                <h2><?php echo MONEDA . number_format(($precio_desc),2,'.',','); ?>
                <small class="text-success"><?php echo $descuento; ?></small>
                </h2>

                <?php } else { ?>
                    <h2><?php echo MONEDA . number_format(($precio),2,'.',','); ?></h2>

                <?php } ?>

                
                <p class="lead">
                    <?php echo $descripcion; ?>
                </p>
            </div>
            <div class="d-grid gap-3 col-10 mx-auto">
                <button class="btn btn-primary" type="button">Comprar ahora</button>
                <button class="btn btn-outline-primary" type="button">Agregar al carrito</button>
            </div>
        </div>
    </div>