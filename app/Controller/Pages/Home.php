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
        return View::render('pages/home', [
            'name'      => 'Raimundo Marques',
            'email'     => 'raimundo.marques.ff@gmail.com',
            'cpf'       => '321654987-98', 
            'matricula' => 202320142021
        ]);
    }
}
