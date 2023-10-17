<?php

namespace App\Http;

class Response
{
    /**
     * Código do estatus http
     * @var integer 
     */
    private $httpCode = 200;

    /**
     * Cebeçalho do response
     * @var array
     */
    private $headers = [];

    /**
     * Tipo de conteúdo que está sedo restornado
     * @var string
     */
    private $contentType = 'text/html';

    /**
     * Conteúdo do response
     * @var mixed
     */

    private $content;

    /**
     * Método responsável por definir os valores
     * @param integer
     * @param array
     * @param string
     * @param mixed
     */
    public function __construct($httpCode, $content, $contentType = 'text/html')
    {
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->setContentType($contentType);
    }

    /**
     * Método responsável por alterar o content type do response
     * @param string
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        $this->addHeader('Content-type', $contentType);
    }

    /**
     * Método responsável por adicionar um registro no cabeçalho do response
     * @param string $key
     * @param string $value
     */
    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }

    /**
     * Método responsável por enviar os headers para o navegador
     */
    private function sendHeaders()
    {
        // Definir o código de status
        http_response_code($this->httpCode);

        // Enviando headers
        foreach ($this->headers as $key => $value) {
            header($key . ': ' . $value);
        }
    }

    /**
     * Método responsável por enviar a resposta a usuário
     */
    public function sendResponse()
    {
        // Enviando os headers
        $this->sendHeaders();

        // Imprimindo conteúdo
        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;
                exit;
        }
    }
}
