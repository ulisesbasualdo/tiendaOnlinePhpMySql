<?php
require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();
$sql = $con->prepare("SELECT * FROM products WHERE activo=1");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC); //lo va a asociar mediante el nombre de columna
include("templates/encabezado.php");
?>
<main>
<div class="container">
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
    <?php
    //include "config/conexion.php";
    foreach ($resultado as $row) {
      $id = $row['id'];
      $nombre = $row['nombre'];
      $descripcion = $row['descripcion'];
      $categoria = $row['categoria'];
      $precio = $row['precio'];
      $activo = $row['activo'];
      $imagen = $row['imagen'];
      $descuento = $row['descuento'];
      $precio_desc = $precio - (($precio * $descuento) / 100);
      ?>

      <div class="col">
        <div class="card shadow-sm">
          <img src="data:image/jpg;base64,<?= base64_encode($imagen) ?>" class="card-img-top img-fluid"
            style="object-fit: cover; height: 300px;">
          <div class="card-body">
            <h5 class="card-title">
              <?php echo $nombre ?>
            </h5>
            <?php if ($descuento > 0) { ?>
              <del>
                <?php echo MONEDA . number_format(($precio), 2, '.', ','); ?>
              </del>
              <h3>
                <?php echo MONEDA . number_format(($precio_desc), 2, '.', ','); ?>
                <small class="text-success">
                  <?php echo '-' . $descuento ?>% descuento
                </small>
              </h3>
            <?php } else { ?>
              <p class="card-text">
                <?php echo MONEDA . number_format(($precio), 2, '.', ','); ?>
              </p>
            <?php } ?>
            <div class="d-flex justify-content-between align-items-center">
              <div class="btn-group">
                <a href="details.php?id=<?php echo $id; ?>&token=<?php
                   echo hash_hmac('sha256', $id, KEY_TOKEN); ?>" class="btn btn-primary">Detalles</a>
              </div>
              <a class="btn btn-success"
                onclick="addProduct(<?php echo $id; ?>, '<?php echo hash_hmac('sha256', $id, KEY_TOKEN); ?>')">Agregar</a>
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