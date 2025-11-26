<?php

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../core/Helper.php";


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->safeLoad();

// Importation des classes avec namespaces pour éviter les conflits de noms

use Core\Router;

// Initialisation du routeur
$router = new Router();
$router->get("/profile","App\Controllers\AuthController@profile");
$router->post("/profile","App\Controllers\AuthController@profile");
$router->get("/register","App\Controllers\AuthController@register");
$router->post("/register","App\Controllers\AuthController@register");
$router->get("/login","App\Controllers\AuthController@login");
$router->post("/login","App\Controllers\AuthController@login");
$router->get("/logout","App\Controllers\AuthController@logout");
$router->get("/","App\Controllers\HomeController@index");
$router->get("/about","App\Controllers\HomeController@about");
$router->get("/memory","App\Controllers\MemoryController@index");
$router->post("/memory","App\Controllers\MemoryController@index");
$router->get("/card_show","App\Controllers\MemoryController@card_show");
$router->get("/cardmaker","App\Controllers\MemoryController@cardmaker");
$router->post("/cardmaker","App\Controllers\MemoryController@cardmaker");
$router->get("/scoreboard","App\Controllers\MemoryController@scoreboard");

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);