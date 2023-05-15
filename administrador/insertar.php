<?php
require_once '../config/database.php';
$db = new Database();
$pdo = $db->conectar();

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$categoria = $_POST['categoria'];
$precio = $_POST['precio'];
$descuento = $_POST['descuento'];
$activo = $_POST['activo'];
$imgFile = $_FILES['imagen'];

if (!empty($imgFile['tmp_name'])) {
    $archivoBLOB = bin2hex(file_get_contents($imgFile['tmp_name']));
    $sql = "INSERT INTO products (nombre, descripcion, categoria, precio, descuento, activo, imagen) VALUES (:nombre, :descripcion, :categoria, :precio, :descuento, :activo, UNHEX(:imagen))";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':imagen', $archivoBLOB, PDO::PARAM_STR);
} else {
    $sql = "INSERT INTO products (nombre, descripcion, categoria, precio, descuento, activo) VALUES (:nombre, :descripcion, :categoria, :precio, :descuento, :activo)";
    $stmt = $pdo->prepare($sql);
}

$stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
$stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
$stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);
$stmt->bindParam(':precio', $precio, PDO::PARAM_STR);
$stmt->bindParam(':descuento', $descuento, PDO::PARAM_STR);
$stmt->bindParam(':activo', $activo, PDO::PARAM_STR);
$stmt->execute();

if ($stmt) {
    header("Location: carga.php");
    exit();
} else {
    echo "Error al cargar el producto";
}

?>