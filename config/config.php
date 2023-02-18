<?php

define("KEY_TOKEN", "ALA.wqc-354*");
define("MONEDA", "$"); //para modificar solo esto cuando haya un cambio de moneda

session_start();

$num_cart = 0;
if(isset($_SESSION['carrito']['productos'])){
    $num_cart = count($_SESSION['carrito']['productos']);
}

?>