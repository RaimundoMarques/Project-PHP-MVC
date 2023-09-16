<?php

// A ideia aqui, é de colocar o conteúdo do cliente
// A entidade resposável pelo projeto 
// Simulando dados vindo de uma base de dados qualquer

namespace App\Model\Entity;

class Organization
{
    /**
     * ID da organização
     * @var integer 
     */
    public $id = 1;


    /**
     * Name da organização
     * @var string
     */
    public $name = 'Nome da organização';


    /**
     * Site da organização
     * @var string
     */
    public $site = "https://www.google.com.br/";


    /**
     * Descrição da organização
     * @var string 
     */
    public $description = 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eos asperiores libero recusandae, rem accusantium quaerat corporis, perspiciatis facere unde impedit, aut repellat laudantium. Voluptatibus molestias nam quasi itaque blanditiis dolores!';
}
