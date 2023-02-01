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
        <a href="cart.php" class="btn btn-primary">Carrito</a>
      </div>
    </div>
  </header>
  <main>



    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
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

          $imagenConvertida = "<img src='data:image/jpg;base64," . base64_encode($imagen) . "' >";
          // $imagenConvertida = "<img src='data:image/jpg;base64," . base64_encode($imagen) . "' >";
        
          ?>


          <div class="col">

            <div class="card shadow-sm">
              <img src="data:image/jpg;base64,<?= base64_encode($imagen) ?>" class="d-block w-100">
              <div class="card-body">
                <h5 class="card-title">
                  <?php echo $nombre ?>
                </h5>
                <p class="card-text">
                  $
                  <?php echo number_format(($precio), '2', '.', ','); ?>
                </p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                    <a href="details.php?id=<?php echo $row['id']; ?>&token=<?php 
                    echo hash_hmac('sha256',$row['id'], KEY_TOKEN); ?>" class="btn btn-primary">Detalles</a>
                  </div>
                  <a href="" class="btn btn-success">Agregar</a>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>

    </div>


  </main>

</body>

</html>