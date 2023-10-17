<?php


require __DIR__ . "/vendor/autoload.php";

use \App\Http\Router;
use \App\Http\Response;
use \App\Controller\Pages\Home;

define('URL', 'http://localhost/project-php-mvc');

$obrouter = new Router(URL);


// Definindo a rota da página HOME
$obrouter->get('/', [
    function () {
        return new Response(200, Home::getHome());
    }
]);


// echo "<pre>";
// print_r($params);
// echo "</pre>";