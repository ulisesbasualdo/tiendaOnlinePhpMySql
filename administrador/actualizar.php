<?php
include("../conexion.php");
$con=conectar();

$id=$_GET['id'];

$sql="SELECT * FROM products WHERE id='$id'";
$query=mysqli_query($con,$sql);

$row=mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="en">
 <head>
  <title></title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="../css/style.css" rel="stylesheet">
  <title>Actualizar</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        
 </head>
 <body>
  <div class="container mt-5">

  <form action="modificar.php" method="post" enctype="multipart/form-data">
  <input type="hidden" name="id" value="<?php echo $row['id']  ?>">
                Nombre:<input value="<?php echo $row['nombre']  ?>" type="text" class="form-control mb-3" name="nombre" placeholder="">
                Descripcion:<input value="<?php echo $row['descripcion']  ?>" type="text" class="form-control mb-3" name="descripcion">
                Categoria:<input value="<?php echo $row['categoria']  ?>" type="text" class="form-control mb-3" name="categoria">
                Precio:<input value="<?php echo $row['precio']  ?>" type="text" class="form-control mb-3" name="precio">
                Descuento:<input value="<?php echo $row['descuento']  ?>" type="text" class="form-control mb-3" name="descuento">
                Activo:<input value="<?php echo $row['activo']  ?>" type="text" class="form-control mb-3" name="activo">
                Imagen:
                <?php $imagen = $row['imagen'];?>
                <img width="100px" src="data:image/jpg;base64,<?= base64_encode($imagen) ?>">
                <br>
                Cambiar imagen:<input type="file" class="form-control mb-3" name="imagen">

                <input type="submit" class="btn btn-primary btn-block" value="Actualizar">
            </form>

  
  </div>
 </body>
</html>