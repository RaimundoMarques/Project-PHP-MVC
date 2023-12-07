<?php


namespace App\Controller\Pages;

use App\Utils\View;
use App\Model\Entity\Organization;

class Home extends Page
{

    /**
     * Método responsável por retornar o conteúdo da view HOME
     * 
     * @return string 
     */

    public static function getHome()
    {
        // Estanciando a classe da Organização
        $obOrganization = new Organization();

        // Título da página
        $title = 'HOME - RdoMarques';

        // View da HOME
        $content = View::render('pages/home', [
            'name'          => $obOrganization->name
        ]);

        return parent::getPage($title, $content);
    }
}
