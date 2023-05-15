<?php
session_start();

require 'config/database.php';

$db = new Database();
$pdo = $db->conectar();

if (!$pdo) {
    die("La conexión falló");
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
} else {
    exit('Error: Falta el campo de usuario o contraseña');
}

$sql = "SELECT * FROM usuarios WHERE nombre_usuario = :username";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $stored_password = $row['password'];
    if (password_verify(base64_encode(hash('sha256', $password, true)), $stored_password)) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['start'] = time();
        $_SESSION['expire'] = $_SESSION['start'] + (5 * 60);
        echo "Bienvenido! " . $_SESSION['username'];
        echo "<br><br><a href=administrador/carga.php>Panel de Control</a>";
        header('Location: administrador/carga.php');
        exit;
    }
}

echo "Nombre de usuario o contraseña incorrectos.";
echo "<br><a href='administrador/index.html'>Volver a Intentarlo</a>";

$pdo = null;
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