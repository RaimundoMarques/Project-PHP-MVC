<?php

namespace App\Http;

use \Closure;

class Router
{

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
        $this->setPrefix();
    }

    /**
     * Método responsável por definir o prefixo das rotas
     * 
     */
    private function setPrefix()
    {
        // Informações da URL ATUAL
        $parseURL = parse_url($this->url);

        // Define prefixo 
        $this->prefix = $parseURL['path'] ?? '';
    }


    /**
     * Método responsável por adicionar uma rota na clase
     * @param string $method
     * @param string $route
     * @param array $params
     */
    private function addRoute($method, $route, $params = [])
    {
        // Validação dos parâmetros
        foreach ($params as $key => $value) {
            if ($value instanceof Closure) {
                $params['controller'] = $value;
                unset($params['$key']);
                continue;
            }
        }

        // Padrão de validação da URL
        $pattenernRoute = '/^' . str_replace('/', '\/', $route) . '$/';

        // Adicionando rota dentro da classe
        $this->routes[$pattenernRoute][$method] = $params;
        echo "<pre>";
        print_r($this);
        echo "</pre>";
        exit;
    }

    /**
     * Método responsável por definir uma rota de GET
     * @param string $route
     * @param array $params
     */
    public function get($route, $params = [])
    {
        return $this->addRoute('GET', $route, $params);
    }
}

        // echo "<pre>";
        // print_r($pattenernRoute);
        // echo "</pre>";
        // exit;