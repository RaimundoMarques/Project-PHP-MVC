<?php


namespace App\Controller\Pages;

use App\Utils\View;


class Home
{

    /**
     * Método responsável por retornar o conteúdo da view HOME
     * 
     * @return string 
     */

    public static function getHome()
    {
        return View::render('pages/home');
    }
}
