<?php

use \App\Http\Response;
use \App\Controller\Pages;


// Definindo a rota da página HOME
$obRouter->get('/', [
    function () {
        return new Response(200, Pages\Home::getHome());
    }
]);


// Definindo a rota da página about
$obRouter->get('/sobre', [
    function () {
        return new Response(200, Pages\About::getAbout());
    }
]);



// Definindo a rotas dinâmicas
$obRouter->get('/pagina/{idPagina}', [
    function ($idPagina) {
        return new Response(200, 'Página ' . $idPagina);
    }
]);

