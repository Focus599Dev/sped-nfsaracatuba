<?php

namespace NFePHP\NFSe\Aracatuba\Common;

use RuntimeException;
use DOMDocument;
use InvalidArgumentException;
use NFePHP\Common\TimeZoneByUF;
use NFePHP\Common\Strings;
use SoapHeader;
use NFePHP\Common\Validator;
use NFePHP\NFSe\Aracatuba\Soap\Soap;

class Tools
{

    /**
     * config class
     * @var \stdClass
     */
    public $config;
    /**
     * ambiente
     * @var string
     */
    public $ambiente = 'homologacao';
    /**
     * Environment
     * @var int
     */
    public $tpAmb = 2;
    /**
     * soap class
     * @var SoapInterface
     */
    public $soap;
    /**
     * last soap request
     * @var string
     */
    public $lastRequest = '';
    /**
     * last soap response
     * @var string
     */
    public $lastResponse = '';
    /**
     * Version of layout
     * @var string
     */
    protected $versao = '3.0.1';

    protected $availableVersions = [
        '3.0.1' => 'GINFEV301',
    ];

    public function __construct($configJson)
    {

        $this->config = json_decode($configJson);

        $this->version($this->config->versao);
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

        $response = $soap->send($request, $soapUrl);

        return (string) $response;
    }

    public function envelopXML($xml, $method)
    {

        $xml = trim(preg_replace("/<\?xml.*?\?>/", "", $xml));

        $this->xml =
            '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:nfse="nfse">
            <soapenv:Header/>
            <soapenv:Body>
                <nfse:Nfse.Execute>
                    <nfse:Operacao>' . $method . '</nfse:Operacao>
                    <nfse:Usuario>' . $this->config->user . '</nfse:Usuario>
                    <nfse:Senha>' . md5($this->config->password) . '</nfse:Senha>
                    <nfse:Webxml>' . htmlspecialchars($xml) . '</nfse:Webxml>
                </nfse:Nfse.Execute>
            </soapenv:Body>
        </soapenv:Envelope>';

        return $this->xml;
    }

    public function removeStuffs($xml)
    {

        if (preg_match('/<soap:Body>/', $xml)) {

            $tag = '<soap:Body>';
            $xml = substr($xml, (strpos($xml, $tag) + strlen($tag)), strlen($xml));

            $tag = '</soap:Body>';
            $xml = substr($xml, 0, strpos($xml, $tag));

        } else if (preg_match('/<soapenv:Body>/', $xml)) {

            $tag = '<soapenv:Body>';
            $xml = substr($xml, (strpos($xml, $tag) + strlen($tag)), strlen($xml));

            $tag = '</soapenv:Body>';
            $xml = substr($xml, 0, strpos($xml, $tag));

        } else if (preg_match('/<soap12:Body>/', $xml)) {

            $tag = '<soap12:Body>';
            $xml = substr($xml, (strpos($xml, $tag) + strlen($tag)), strlen($xml));

            $tag = '</soap12:Body>';
            $xml = substr($xml, 0, strpos($xml, $tag));

        } else if (preg_match('/<env:Body>/', $xml)) {

            $tag = '<env:Body>';
            $xml = substr($xml, (strpos($xml, $tag) + strlen($tag)), strlen($xml));

            $tag = '</env:Body>';
            $xml = substr($xml, 0, strpos($xml, $tag));

        } else if (preg_match('/<env:Body/', $xml)) {

            $tag = '<env:Body xmlns:env=\'http://www.w3.org/2003/05/soap-envelope\'>';
            $xml = substr($xml, (strpos($xml, $tag) + strlen($tag)), strlen($xml));

            $tag = '</env:Body>';
            $xml = substr($xml, 0, strpos($xml, $tag));
            
        } else if (preg_match('/<S:Body>/', $xml)) {

            $tag = '<S:Body>';
            $xml = substr($xml, (strpos($xml, $tag) + strlen($tag)), strlen($xml));

            $tag = '</S:Body>';
            $xml = substr($xml, 0, strpos($xml, $tag));
        }

        if (preg_match('/ns3:/', $xml)) {

            $xml = preg_replace('/ns3:/', '', $xml);
        }

        if (preg_match('/ns2:/', $xml)) {

            $xml = preg_replace('/ns2:/', '', $xml);
        }

        if (preg_match('/ns4:/', $xml)) {

            $xml = preg_replace('/ns4:/', '', $xml);
        }

        return $xml;
    }
}
