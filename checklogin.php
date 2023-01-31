
<?php
session_start();
?>

<?php

include 'conexion.php';

#$conexion = new mysqli($host_db, $user_db, $pass_db, $db_name);
$conexion = conectar();

if ($conexion->connect_error) {
 die("La conexion falló: " . $conexion->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];
 
$sql = "SELECT * FROM usuarios WHERE nombre_usuario = '$username'";


$result = $conexion->query($sql);


if ($result->num_rows > 0) {     }
	
 
  $row = $result->fetch_array(MYSQLI_ASSOC);
  if (password_verify(base64_encode(hash('sha256', $password, true)),$row['password'])) {
   
 
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;
    $_SESSION['start'] = time();
    $_SESSION['expire'] = $_SESSION['start'] + (5 * 60);

    echo "Bienvenido! " . $_SESSION['username'];
    echo "<br><br><a href=administrador/carga.php>Panel de Control</a>"; 
    header('Location: administrador/carga.php');//redirecciona a la pagina del usuario

 } else { 
   echo "Username o Password estan incorrectos.";

   echo "<br><a href='administrador/index.html'>Volver a Intentarlo</a>";
 }
 mysqli_close($conexion); 
 ?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
	<link rel="stylesheet" type="text/css" href="css/style.css">
  <title>chequeo de login</title>
</head>
<body>
  
</body>
</html>