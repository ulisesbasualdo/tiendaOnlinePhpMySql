
<?php
//incluimos el archivo donde se encuentran nuestros datos de conexion
 include '../conexion.php';
//asignamos a la variable $form_pass el contenido del input password del formulario
$form_pass = $_POST['password']; 
//encriptamos la contraseña antes de guardarla en la base de datos
$form_pass = password_hash(
  base64_encode(
      hash('sha256', $form_pass, true)
  ),
PASSWORD_DEFAULT
);
/*generamos una nueva instancia de conexión a la cual le pasamos como parametros
los datos de la conexión que tenemos guardados en conexion.php*/

$conexion = conectar();

 if ($conexion->connect_error) {
 die("La conexion falló: " . $conexion->connect_error);
}

//Generamos una consulta para ver si el usuario ya existe
 $buscarUsuario = "SELECT * FROM usuarios
 WHERE nombre_usuario = '$_POST[username]' ";

 $result = $conexion->query($buscarUsuario);

 $count = mysqli_num_rows($result);

 //Verificamos si existe
 if ($count == 1) {
   //si existe le avisamos y le damos la opcion de volver a cargar
 echo "<br />". "Nombre de Usuario ya asignado, ingresa otro." . "<br />";

 echo "<a href='index.html'>Por favor escoga otro Nombre</a>";
 }
 else{

  //sino, hacemos el insert a la tabla
 $query = "INSERT INTO usuarios (nombre_usuario, password, email) VALUES ('$_POST[username]', '$form_pass', '$_POST[email]')";

 if ($conexion->query($query) === TRUE) {
 
 echo "<br />" . "<h1>" . "Gracias por registrarse!" . "</h1>";
 echo "<h3>" . "Bienvenido: " . $_POST['username'] . "</h3>" . "\n\n";
 echo "<h3>" . "Iniciar Sesion: " . "<a href='index.html'>Login</a>" . "</h3>"; 
 }

 else {
 echo "Error al crear el usuario." . $query . "<br>" . $conexion->error; 
   }
 }
 mysqli_close($conexion);
?>
