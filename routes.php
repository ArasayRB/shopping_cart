<?php
namespace app;

require __DIR__ . '/vendor/autoload.php'; #Cargar todas las dependencias

use Phroute\Phroute\RouteCollector;

$collector = new RouteCollector();

$collector->get("/", ['app\controllers\User_Controller','principal']);
$collector->get("/login", ['app\controllers\User_Controller','loginView']);
$collector->get("/products", ['app\controllers\Product_Controller','index']);
$collector->post("/products/stars_value", ['app\controllers\ProductClasification_Controller','putClasification']);
$collector->get("/carts", ['app\controllers\ShoppingCart_Controller','index']);
$collector->post("/carts/add",['app\controllers\ShoppingCart_Controller','addProductToCartByUser']);
$collector->post("/carts/update",['app\controllers\ShoppingCart_Controller','updateToCart']);
$collector->post("/carts/delete",['app\controllers\ShoppingCart_Controller','delete']);
$collector->post("/carts/pay",['app\controllers\UserPay_Controller','pay']);
$collector->get("/logout", ['app\controllers\User_Controller','logoff']);
$collector->get("/usuarios", function(){
	echo "Obtener los usuarios";
	echo '</br';
	echo $_SESSION['name'];
});
$collector->post("/login", ['app\controllers\User_Controller','login']);

return $collector;
