<?php


require __DIR__ . "/vendor/autoload.php";

use \App\Http\Router;
use App\Utils\View;

define('URL', 'http://localhost/project-php-mvc');


// DEFININDO O VALOR PADRÃO DAS VARIÁVEIS
View::init([
    'URL' => URL
]);


// INICIA O ROTEADOR DAS PÁGINAS
$obRouter = new Router(URL);

include __DIR__.'/routes/pages.php';

// Imprime o response da Rota
$obRouter->run()
         ->sendResponse();
