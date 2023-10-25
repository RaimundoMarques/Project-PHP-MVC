<?php


require __DIR__ . "/vendor/autoload.php";

use \App\Http\Router;
use \App\Http\Response;
use \App\Controller\Pages\Home;

define('URL', 'http://localhost/project-php-mvc');

$obRouter = new Router(URL);

// Definindo a rota da página HOME
$obRouter->get('/', [
    function () {
        return new Response(200, Home::getHome());
    }
]);

// Imprime o response da Rota
$obRouter->run()
         ->sendResponse();
