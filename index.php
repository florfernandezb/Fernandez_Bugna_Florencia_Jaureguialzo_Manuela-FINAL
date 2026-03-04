<?php
require_once __DIR__ . '/class/Products.php';
require_once __DIR__ . '/class/Cart.php';
require_once __DIR__ . '/class/Categories.php';
require_once __DIR__ . '/class/DatabaseConection.php';
require_once __DIR__ . '/route/route.php';

require_once "functions/autoload.php";

$routes = getRoutesSitio();

$view = $_GET['s'] ?? 'home';

$categories = (new Categories())->getCategories();

$colors = (new Colors()) ->getColors();

if(!isset($routes[$view])) {
    $view = '404';
}

$login_message = null;
if ($view === 'cart' && !is_logged_in()) {
    $view = 'login';
    $login_message = 'Para ver tu carrito necesitás iniciar sesión.';
}

$cart = (new Cart())->get_carrito();
$quantity = ((new Cart())->cantidad_total());
$total = (new Cart())->precio_total();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $routes[$view]['title'];?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="res/favicon.png" type="image/x-icon">
</head>
<body>
    <div class="visually-hidden">
        <a href="#content">Saltar al contenido</a>
    </div>
    <header class="row">
        <div class="col-6">
            <h1 ><a href="index.php?s=home">Hecho por Vicki</a></h1>
        </div>
        
        <nav id="nav" class="col-6 navbar">
            <ul id="open-close">
                <li class="open"><a href="#nav">Abrir</a></li>
                <li class="close"><a href="#">Cerrar</a></li>
            </ul>    
            <ul id="menu" class="navbar">
                <li ><a  href="index.php?s=home" class="nav-link active" aria-current="page">Home</a></li>
                <li class="dropdownmenu">       
                <a  href="index.php?s=productList" class="nav-link active" aria-current="page">Productos</a>
                    <ul class="dropdown-content">
                    <?php foreach($categories as $category): ?>
                        <li ><a href="index.php?s=productList&category=<?= $category->getId();?>"><?= ucfirst($category->getName());?></a></li> 
                    <?php
                    endforeach; ?>
                    </ul>
                </li>
                <li ><a  href="index.php?s=formContacto">Contacto</a></li>
                <li ><a  href="index.php?s=datos">Datos de las alumnas</a></li>
                <li ><a  href="index.php?s=login">Admin</a></li>
            </ul>
            <?php
                $cartHref = is_logged_in() ? "index.php?s=cart" : "index.php?s=login";
                $miniQty = (is_logged_in() && $cart) ? $quantity : 0;
                $miniTotal = (is_logged_in() && $cart) ? $total : 0;
            ?>
            <a href="<?= $cartHref ?>" class="divCarritoIcon" aria-label="Ir al carrito">
                <p id="miniCarritoCantidad"><?= (int)$miniQty ?></p>
                <p id="miniCarritoPrecio">$<?= number_format((float)$miniTotal, 0, ",", ".") ?></p>
            </a>
        </nav>
    </header>
    <?php
    require __DIR__ . '/views/' . $view . '.php';

    ?>
    <footer>
        <p>Este sitio es un trabajo práctico para la materia Programación II del tercer cuatrimestre de la Escuela Da Vinci. </p>
        <p>Florencia Fernández Bugna | Manuela Jaureguialzo</p>
        <p>&copy; Da Vinci - 2022</p>
    </footer>
</body>
</html>