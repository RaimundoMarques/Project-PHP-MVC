<?php


namespace App\Controller\Pages;

use App\Utils\View;
use App\Model\Entity\Organization;

class About extends Page
{

    /**
     * Método responsável por retornar o conteúdo da view About
     * 
     * @return string 
     */

    public static function getAbout()
    {
        // Estanciando a classe da Organização
        $obOrganization = new Organization();

        // Título da página
        $title = 'Sobre - MVC';

        // View da About
        $content = View::render('pages/about', [
            'id'            => $obOrganization->id,
            'name'          => $obOrganization->name,
            'site'          => $obOrganization->site,
            'description'   => $obOrganization->description
        ]);

        return parent::getPage($title, $content);
    }
}
