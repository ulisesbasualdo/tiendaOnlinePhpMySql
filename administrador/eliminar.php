<?php
include("../config/database.php");
$db = new Database();
$con = $db->conectar();
$id = $_GET['id'];
$sql = "DELETE FROM products WHERE id=:id";
$stmt = $con->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
if ($stmt) {
    Header("Location: carga.php");
}