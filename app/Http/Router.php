<?php

namespace App\Http;

use \Closure;
use \Exception;
use Reflection;
use ReflectionFunction;

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

        // VARIÁVEIS DA ROTA
        $params['variables'] = [];

        // PADRÃO DE VALIDAÇÃO DAS VARIÁVEIS DAS ROTAS
        $patternVariable = '/{(.*?)}/';
        if (preg_match_all($patternVariable, $route, $matches)) {
            $route = preg_replace($patternVariable, '(.*?)', $route);

            $params['variables'] = $matches[1];
        }

        // Padrão de validação da URL
        $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';

        // Adicionando rota dentro da classe
        $this->routes[$patternRoute][$method] = $params;
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

        // Retorna a URI sem prefixo
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
        foreach ($this->routes as $patternRoute => $methods) {

            // Verifica se a rota atual bate com a rota padrão
            if (preg_match($patternRoute, $uri, $matches)) {

                // VERIFICA O MÉTODO
                if ($methods[$httpMethod]) {

                    // Removendo a primeira posição
                    unset($matches[0]);

                    // CHAVES DAS VARIÁVEIS PROCESSADAS
                    $keys = $methods[$httpMethod]['variables'];
                    $methods[$httpMethod]['variables'] = array_combine($keys, $matches);
                    $methods[$httpMethod]['variables']['request'] = $this->request;

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

            // Obtém a rota atual
            $route = $this->getRoute();

            // VERIFICA O CONTROLLER
            if (!isset($route['controller'])) {
                throw new Exception("A URL não pôde ser processada!!", 500);
            }

            // Argumentos da função
            $args = [];


            //REFLECTION
            $reflection = new ReflectionFunction($route['controller']);
            foreach ($reflection->getParameters() as $parameter) {

                echo "<pre>";
                print_r($route);
                echo "</pre>";

            }





            // Retorna a execução da função
            return call_user_func_array($route['controller'], $args);
        } catch (Exception $e) {
            //throw $th;
            return new Response($e->getCode(), $e->getMessage());
        }
    }
}
