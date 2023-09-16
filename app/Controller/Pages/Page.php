<?php


namespace App\Controller\Pages;

use App\Utils\View;

class Page
{

    /**
     * Retorna o cabeçalho da página rederizado
     * @return string
     * @param string $namePage
     */
    private static function getHeader($namePage)
    {
        $namePage = 'Home';
        return View::render('pages/header', [
            'namePage' => $namePage
        ]);
    }


    /**
     * Retorna o footer da página renderizado
     * @return string
     */
    private static function getFooter()
    {
        return View::render('pages/footer');
    }


    /**
     * Método responsável por retornar o conteúdo da view Page
     * 
     * @return string 
     */

    public static function getPage($title, $content)
    {
        return View::render('pages/page', [
            'title' => $title,
            'header' => self::getHeader('namePage'),
            'footer' => self::getFooter(),
            'content' => $content
        ]);
    }
}
