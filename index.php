<?php


require __DIR__ . "/vendor/autoload.php";

use \App\Http\Router;
use \App\Controller\Pages\Home;

define('URL', 'http://localhost/project-php-mvc/');

$obrouter = new Router(URL);

echo "<pre>";
print_r($obrouter);
echo "</pre>";

exit;

echo Home::getHome();
