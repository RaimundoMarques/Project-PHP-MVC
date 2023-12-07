<?php


require __DIR__ . "/vendor/autoload.php";

use \App\Http\Router;

define('URL', 'http://localhost/project-php-mvc');

$obRouter = new Router(URL);

include __DIR__.'/routes/pages.php';

// Imprime o response da Rota
$obRouter->run()
         ->sendResponse();
