<?php

namespace App\Http;


class Router{

    /**
     * URL completa do projeto (raiz)
     * @var string
     */
    private $url = '';


    /**
     * Prfixo de todas as rotas
     * @var string
     */
    private $prefix = '';


    /**
     * Índice de rotas
     * @var array
     */
    private $routes = [];


    /**
     * Instância de request
     * @var Request
     */
    private $request;

    /**
     * Método responsável por iniciar a classe
     * @param string $url
     */
    public function __construct($url)
    {
        $this->request = new Request();
        $this->url = $url;
    }
}