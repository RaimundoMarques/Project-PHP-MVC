<?php

namespace App\Http;

use \Closure;
use \Exception;

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
                unset($params[$key]);
                continue;
            }
        }

        // Padrão de validação da URL
        $pattenernRoute = '/^' . str_replace('/', '\/', $route) . '$/';

        // Adicionando rota dentro da classe
        $this->routes[$pattenernRoute][$method] = $params;
    }

                            /** MÉTODOS DE CRUD */
/*---------------------------------------------------------------------------------------*/
    /**
     * Método responsável por definir uma rota de GET
     * @param string $route
     * @param array $params
     */
    public function get($route, $params = [])
    {
        return $this->addRoute('GET', $route, $params);
    }

/*---------------------------------------------------------------------------------------*/    

    /**
     * Método responsável por definir uma rota de POST
     * @param string $route
     * @param array $params
     */
    public function post($route, $params = [])
    {
        return $this->addRoute('POST', $route, $params);
    }

/*---------------------------------------------------------------------------------------*/

    /**
     * Método responsável por definir uma rota de PUT
     * @param string $route
     * @param array $params
     */
    public function put($route, $params = [])
    {
        return $this->addRoute('PUT', $route, $params);
    }

/*---------------------------------------------------------------------------------------*/

    /**
     * Método responsável por definir uma rota de DELETE
     * @param string $route
     * @param array $params
     */
    public function delete($route, $params = [])
    {
        return $this->addRoute('DELETE', $route, $params);
    }
/*---------------------------------------------------------------------------------------*/



    /**
     * Método responsável por retornar a URI desconsiderando o prefixo
     * @return string
     */
    private function getUri()
    {
        // URI da Request
        $uri = $this->request->getUri();

        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];
        return end($xUri);
    }


    /**
     * Método responsável por retornar os dados da rota atual
     * @return array
     */
    private function getRoute()
    {
        // URI
        $uri = $this->getUri();
        $httpMethod = $this->request->getHttpMethod();

        // VALIDA AS ROTAS
        foreach ($this->routes as $pattenernRoute => $methods) {

            // Verifica se a rota atual bate com a rota padrão
            if (preg_match($pattenernRoute, $uri)) {

                // VERIFICA O MÉTODO
                if ($methods[$httpMethod]) {

                    // RETORNO DOS PARÂMETROS DA ROTA
                    return $methods[$httpMethod];
                }

                // Método não permitido
                throw new Exception("Método não permitido!", 405);
            }
        }

        // URL não encontrada
        throw new Exception("URL não encontrada!", 404);
    }


    /**
     * Método responsável por executar a rota atual
     * @return Response
     */
    public function run()
    {
        try {
            //code...
            
            $route = $this->getRoute();

            // VERIFICA O CONTROLLER
            if(!isset($route['controller'])){
                throw new Exception("A URL não pode ser processada!!", 500);
            }

            // Argumentos da função
            $args = []; 

            // Retorna a execução da função
            return call_user_func_array($route['controller'], $args);

            // echo '<pre>';
            // print_r($route);
            // echo '</pre>';exit;

            
        } catch (Exception $e) {
            //throw $th;
            return new Response($e->getCode(), $e->getMessage());
        }
    }
}
