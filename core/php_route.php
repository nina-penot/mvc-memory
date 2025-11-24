<?php
require_once "./core/Helper.php";
require_once "./vendor/autoload.php";

$controller_path = __DIR__ . "/../app/Controllers";
foreach (scandir_plus($controller_path) as $controller) {
    $controller = remove_php_ext($controller);
    //Prend les variables de chaque controller
    //La variable qui intéresse est nommée "post_needed"
    //à l'intérieur se trouve les méthodes qui ont besoin de la méthode post
    $vars[$controller] = get_class_vars('App\\Controllers\\' . $controller);
    foreach (get_class_methods('App\\Controllers\\' . $controller) as $method) {
        $my_controllers[$controller][] = $method;
    }
}

$routes = [];
foreach ($my_controllers as $c => $methods) {
    foreach ($methods as $m) {
        //Méthode qu'il faut appeler
        $callmethod = '"App\\Controllers\\' . $c . "@" . $m . '")';
        //Créé d'abord les noms de lien
        if ($m == "index") {
            //Si index, il faut récupérer le nom du dir
            //Plus simple de prendre seulement le mot allié à "controller"
            if (controller_to_dirname($c) == "home") {
                $linkname = '"/"';
            } else {
                $linkname = '"/' . controller_to_dirname($c) . '"';
            }
        } else {
            $linkname = '"/' . $m . '"';
        }
        //Créé les routes
        $routes[] = '$router->get(' . $linkname . ',' . $callmethod;
        if (isset($vars[$c]["post_needed"]) and in_array($m, $vars[$c]["post_needed"])) {
            $routes[] = '$router->post(' . $linkname . ',' . $callmethod;
        }
    }
}

// print_r($routes);

//écriture du fichier index.php
$code = <<<EOT
<?php

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../core/Helper.php";


\$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
\$dotenv->safeLoad();

// Importation des classes avec namespaces pour éviter les conflits de noms

use Core\Router;

// Initialisation du routeur
\$router = new Router();\n
EOT;

$code .= implode(";\n", $routes);
$code .= ";\n";

$code .= <<<EOT

\$router->dispatch(\$_SERVER['REQUEST_URI'], \$_SERVER['REQUEST_METHOD']);
EOT;
file_put_contents(__DIR__ . "/../public/index.php", $code);
