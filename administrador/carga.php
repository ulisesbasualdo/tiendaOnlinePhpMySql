<?php
require '../config/config.php';
require '../config/database.php';
$db = new Database();
$con = $db->conectar();
$sql = $con->prepare("SELECT * FROM products");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC); //lo va a asociar mediante el nombre de columna
?>

<?php

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
} else {
    echo "Inicia Sesion para acceder a este contenido.<br>";
    echo "<br><a href='index.html'>Login</a>";
    echo "<br><br><a href='registrar.html'>Registrarme</a>";
    header('Location: index.html'); //redirige a la página de login si el usuario quiere ingresar sin iniciar sesion
    exit;
}

$now = time();
if ($now > $_SESSION['expire']) {
    session_destroy();
    header('Location: index.html'); //redirige a la página de login
    echo "Tu sesion a expirado,
<a href='index.html'>Inicia Sesion</a>";
    exit;
}

?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>Admin - Cargar Productos</title>
</head>

<body>
    <!-- menu-------------------------------- -->
    <nav id="menu-admin">
        <label class="logo">Ecommerce (Administrador)
        </label>
        <ul class="menu_items" style="justify-content:center">
            <li class="active"><a href="../index.php">Página principal</a></li>
            <li><a href="logout.php">Cerrar sesión</a></li>
        </ul>
        <span class="btn_menu">
            <i class="fas fa-bars"></i>
        </span>
    </nav>
    <!-- fin menu---------------------------- -->

    <div class="jumbotron text-center">
        <h1 style="color:#fff">Bienvenido
            <?php echo $_SESSION['username']; ?>
        </h1>
    </div>

    <div class="container mt-5">
        <div class="row">
            <h1 style="color:#fff; text-align:left">Ingrese datos</h1>
            <form action="insertar.php" method="post" enctype="multipart/form-data">
                <input type="text" class="form-control mb-3" name="nombre" placeholder="Nombre">
                <input type="text" class="form-control mb-3" name="descripcion" placeholder="Descripción">
                <input type="text" class="form-control mb-3" name="categoria" placeholder="Categoria">
                <input type="text" class="form-control mb-3" name="precio" placeholder="precio">
                <input type="text" class="form-control mb-3" name="descuento" placeholder="descuento">
                <input type="text" class="form-control mb-3" name="activo" placeholder="activo">
                <input type="file" class="form-control mb-3" name="imagen">

                <input type="submit" class="btn btn-primary">
            </form>
        </div>
    </div>

    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php
            foreach ($resultado as $row) {
                $id = $row['id'];
                $nombre = $row['nombre'];
                $descripcion = $row['descripcion'];
                $categoria = $row['categoria'];
                $precio = $row['precio'];
                $descuento = $row['descuento'];
                $precio_desc = $precio - (($precio * $descuento) / 100);
                $activo = $row['activo'];
                $imagen = $row['imagen'];
                ?>

                <div class="col">

                    <div class="card shadow-sm">
                        <img class="card-img-top img-fluid" style="object-fit: cover; height: 300px;" width="100%"
                            src="data:image/jpg;base64,<?= base64_encode($imagen) ?>">
                        <div class="card-body">
                            <h5 class="card-title">
                                Nombre:
                                <?php echo $nombre ?>
                            </h5>
                            <h5 class="card-title">
                                Descripcion:
                                <?php echo $descripcion ?>
                            </h5>
                            <h5 class="card-title">
                                Categoria:
                                <?php echo $categoria ?>
                            </h5>
                            <h5 class="card-title">
                                Activo:
                                <?php echo $activo ?>
                            </h5>
                            <h5 class="card-title">
                                Precio: $
                                <?php echo number_format(($precio), '2', '.', ','); ?>
                            </h5>
                            <h5 class="card-title">
                                Descuento:
                                <?php echo $descuento ?>%
                            </h5>

                            <?php if ($descuento > 0) { ?>
                                <h5 class="card-title">
                                    Total con Descuento:
                                    <?php echo MONEDA . number_format(($precio_desc), 2, '.', ','); ?>
                                </h5>
                            <?php } ?>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">

                                    <a href="eliminar.php?id=<?php echo $id ?>" class="btn btn-danger">Eliminar</a>
                                </div>

                                <a href="actualizar.php?id=<?php echo $id ?>" class="btn btn-info">Editar</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>


    <script src="../js/script.js"></script>

</body>

</html>