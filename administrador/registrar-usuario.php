<?php
//incluimos el archivo donde se encuentran nuestros datos de conexion
require '../config/database.php';

//asignamos a la variable $form_pass el contenido del input password del formulario
$form_pass = $_POST['password'];

//encriptamos la contraseña antes de guardarla en la base de datos
$form_pass = password_hash(base64_encode(hash('sha256', $form_pass, true)), PASSWORD_DEFAULT);

//generamos una nueva instancia de conexión a la base de datos
$db = new Database();
$conexion = $db->conectar();


if (!$conexion) {
    die("La conexión falló: ");
}

//generamos una consulta para ver si el usuario ya existe
$buscarUsuario = "SELECT * FROM usuarios WHERE nombre_usuario = :username";

$stmt = $conexion->prepare($buscarUsuario);
$stmt->bindParam(':username', $_POST['username']);
$stmt->execute();
$count = $stmt->rowCount();

//verificamos si existe
if ($count == 1) {
    //si existe le avisamos y le damos la opcion de volver a cargar
    echo "<br />" . "Nombre de Usuario ya asignado, ingresa otro." . "<br />";
    echo "<a href='registrar.html'>Por favor escoga otro Nombre</a>";
} else {
    //sino, hacemos el insert a la tabla
    $query = "INSERT INTO usuarios (nombre_usuario, password, email) VALUES (:username, :password, :email)";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(':username', $_POST['username']);
    $stmt->bindParam(':password', $form_pass);
    $stmt->bindParam(':email', $_POST['email']);
    if ($stmt->execute()) {
        echo "<br />" . "<h1>" . "Gracias por registrarse!" . "</h1>";
        echo "<h3>" . "Bienvenido: " . $_POST['username'] . "</h3>" . "\n\n";
        echo "<h3>" . "Iniciar Sesion: " . "<a href='index.html'>Login</a>" . "</h3>";
    } else {
        echo "Error al crear el usuario." . $query . "<br>" . $stmt->errorInfo();
    }
}

$conexion = null;
?>