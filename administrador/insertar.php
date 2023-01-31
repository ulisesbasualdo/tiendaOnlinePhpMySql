<?php
include("../conexion.php");
$con=conectar();

$nombre=$_POST['nombre'];
$descripcion=$_POST['descripcion'];
$categoria=$_POST['categoria'];
$precio=$_POST['precio'];
$activo=$_POST['activo'];
$imgFile = $_FILES['imagen'];
//move_uploaded_file($_FILES['imagen']['tmp_name'],"../img/".$_FILES['imagen']);


 #archivo
 $tmp=$imgFile['tmp_name'];
 $contenido=file_get_contents($tmp);
 $archivoBLOB=addslashes($contenido);

if($tmp!=""){
    $sql="INSERT INTO products VALUES('null','$nombre','$descripcion','$precio','$categoria','$activo','$archivoBLOB')";
    $query= mysqli_query($con,$sql);
}else{
    $sql="INSERT INTO products VALUES('null','$nombre','$descripcion','$precio','$categoria','$activo')";
    $query= mysqli_query($con,$sql);
}




if($query){
    Header("Location: carga.php");
    
}else {
}
?>