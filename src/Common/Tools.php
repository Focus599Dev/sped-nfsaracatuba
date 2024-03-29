<?php

namespace NFePHP\NFSe\Aracatuba\Common;

use NFePHP\NFSe\Aracatuba\Soap\Soap;

class Tools
{

    public $soapUrl;
    /**
     * config class
     * @var \stdClass
     */
    public $config;
    /**
     * Environment
     * @var int
     */
    public $soap;
    /**
     * Version of layout
     * @var string
     */
    protected $versao = '3.0.1';

    protected $availableVersions = [
        '3.0.1' => 'GINFEV301',
    ];
    
    private $cnpj = '';

    public function __construct($configJson)
    {

        $this->config = json_decode($configJson);

        $this->version($this->config->versao);

        if ($this->config->tpAmb == '1') {
            $this->soapUrl = 'https://s76.asp.srv.br/issonline/servlet/anfse?wsdl';
        } else {
            $this->soapUrl = 'http://s1.asp.srv.br:8180/issonline-homolog/servlet/anfse?wsdl';
        }
        
        $this->cnpj =  $this->config->cnpj;
    }

    public function version($version = null)
    {

        if (null === $version) {

            return $this->versao;
        }

        if (false === isset($this->availableVersions[$version])) {

            throw new \InvalidArgumentException('Essa versão de layout não está disponível');
        }

        $this->versao = $version;

        return $this->versao;
    }

    protected function sendRequest($request, $soapUrl)
    {

        $soap = new Soap;

        $response = $soap->send($request, $soapUrl, $this->cnpj);

        return (string) $response;
    }

    public function envelopXML($xml, $method)
    {

        $xml = trim(preg_replace("/<\?xml.*?\?>/", "", $xml));

        $this->xml =
            '<nfse:Nfse.Execute>
                <nfse:Operacao>' . $method . '</nfse:Operacao>
                <nfse:Usuario>' . $this->config->user . '</nfse:Usuario>
                <nfse:Senha>' . md5($this->config->password) . '</nfse:Senha>
                <nfse:Webxml>' . htmlspecialchars($xml) . '</nfse:Webxml>
            </nfse:Nfse.Execute>';

        return $this->xml;
    }

    public function envelopSoapXML($xml)
    {
        $this->xml =
            '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:nfse="nfse">
            <soapenv:Header/>
                <soapenv:Body>' . $xml . '</soapenv:Body>
            </soapenv:Envelope>';

        return $this->xml;
    }

    public function removeStuffs($xml)
    {

        if (preg_match('/<SOAP-ENV:Body>/', $xml)) {

            $tag = '<SOAP-ENV:Body>';
            $xml = substr($xml, (strpos($xml, $tag) + strlen($tag)), strlen($xml));

            $tag = '</SOAP-ENV:Body>';
            $xml = substr($xml, 0, strpos($xml, $tag));
        } elseif (preg_match('/<NFSE>/', $xml)) {

            $tag = '<NFSE>';
            $xml = substr($xml, (strpos($xml, $tag) + strlen($tag)), strlen($xml));

            $tag = '</NFSE>';
            $xml = substr($xml, 0, strpos($xml, $tag));
        }

        if (preg_match('/<Nfse.ExecuteResponse xmlns="nfse">/', $xml)) {

            $xml = preg_replace('/<Nfse.ExecuteResponse xmlns="nfse">/', '', $xml);
        }

        if (preg_match('/<\/Nfse.ExecuteResponse>/', $xml)) {

            $xml = preg_replace('/<\/Nfse.ExecuteResponse>/', '', $xml);
        }

        if (preg_match('/<NFSE>/', $xml)) {

            $xml = preg_replace('/<NFSE>/', '', $xml);
        }

        if (preg_match('/<\/NFSE>/', $xml)) {

            $xml = preg_replace('/<\/NFSE>/', '', $xml);
        }

        $xml = trim($xml);
        
        if (preg_match('/<Mensagem><\?xml version="1.0" encoding="ISO-8859-1"\?>/', $xml)) {

            $xml = preg_replace('/<Mensagem><\?xml version="1.0" encoding="ISO-8859-1"\?>/', '<Mensagem>', $xml);
        }

        return $xml;
    }

    public function getLastRequest()
    {
        return $this->lastRequest;
    }
}
