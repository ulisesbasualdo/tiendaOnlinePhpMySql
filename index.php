<?php


require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("SELECT * FROM products");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC); //lo va a asociar mediante el nombre de columna


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
        <a href="checkout.php" class="btn btn-primary">
          Carrito<span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span></a>
      </div>
    </div>
  </header>
  <main>



    <div class="container" >
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3" >
        <?php
        //include "config/conexion.php";
        $lista = listarArchivos($con);
        while ($datos = mysqli_fetch_array($lista)) {
          $id = $datos['id'];
          $nombre = $datos['nombre'];
          $descripcion = $datos['descripcion'];
          $categoria = $datos['categoria'];
          $precio = $datos['precio'];
          $activo = $datos['activo'];
          $imagen = $datos['imagen'];
          $descuento = $datos['descuento'];
          $precio_desc = $precio - (($precio * $descuento) / 100);

          $imagenConvertida = "<img src='data:image/jpg;base64," . base64_encode($imagen) . "' >";
          // $imagenConvertida = "<img src='data:image/jpg;base64," . base64_encode($imagen) . "' >";
        
          ?>


          <div class="col">

            <div class="card shadow-sm">
              <img src="data:image/jpg;base64,<?= base64_encode($imagen) ?>" 
              class="card-img-top img-fluid" style="object-fit: cover; height: 300px;">
              <div class="card-body">
                <h5 class="card-title">
                  <?php echo $nombre ?>
                </h5>

                <?php if($descuento > 0){ ?>
                <del><?php echo MONEDA . number_format(($precio),2,'.',','); ?></del>
                <h3><?php echo MONEDA . number_format(($precio_desc),2,'.',','); ?>
                <small class="text-success"><?php echo '-'. $descuento?>% descuento</small>
                </h3>

                <?php } else { ?>
                    <p class="card-text"><?php echo MONEDA . number_format(($precio),2,'.',','); ?></p>

                <?php } ?>



              
                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                    <a href="details.php?id=<?php echo $id; ?>&token=<?php 
                    echo hash_hmac('sha256',$id, KEY_TOKEN); ?>" class="btn btn-primary">Detalles</a>
                  </div>
                  <a class="btn btn-success" onclick="addProduct(<?php echo $id; ?>, '<?php echo hash_hmac('sha256',$id, KEY_TOKEN);  ?>')">Agregar</a>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>

    </div>


  </main>

  <script src="js/script.js"></script>
</body>

</html>