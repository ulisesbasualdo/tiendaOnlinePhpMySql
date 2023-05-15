<?php
require '../config/database.php';
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    session_destroy();
    header('Location: index.html');
    exit;
} else {
    header('Location: index.html');
    exit;
}
?>