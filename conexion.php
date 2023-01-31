<?php

function conectar(){
 $host="localhost";
 $user="root";
 $pass="";

 $bd="ecommerce";

 $con=mysqli_connect($host,$user,$pass); //encontrar todas las bases de datos que hay en la computadora

 mysqli_select_db($con,$bd); //encontrar una base de datos especifica

 return $con;

}


?>