<?php

include("../conexion.php");
$con = conectar();
$tpm = 0;
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$categoria = $_POST['categoria'];
$precio = $_POST['precio'];
$activo = $_POST['activo'];
$imagen = $_FILES['imagen'];
//move_uploaded_file($_FILES['imagen']['tmp_name'],"../img/".$_FILES['imagen']);

#archivo


$tmp = $imagen['tmp_name'];
if ($tmp) {
    $contenido = file_get_contents($tmp);
    $archivoBLOB = addslashes($contenido);
}



if ($archivoBLOB) {
    $sql = "UPDATE products SET nombre='$nombre',descripcion='$descripcion',categoria='$categoria',precio='$precio',activo='$activo',imagen='$archivoBLOB' WHERE id='$id'";
    $query = mysqli_query($con, $sql);
} else {
    $sql = "UPDATE products SET nombre='$nombre',descripcion='$descripcion',categoria='$categoria',precio='$precio',activo='$activo' WHERE id='$id'";
    $query = mysqli_query($con, $sql);
}


if ($query) {
    Header("Location: carga.php");
}
?>