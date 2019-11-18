<?php

namespace NFePHP\NFSe\Aracatuba;

use NFePHP\NFSe\Aracatuba\Common\Tools as ToolsBase;
use NFePHP\Common\Strings;
use DOMDocument;
use NFePHP\Common\DOMImproved as Dom;

class Tools extends ToolsBase
{

    public $soapUrlHomolog = 'http://s1.asp.srv.br:8180/issonline-homolog/servlet/anfse';

    public $soapUrlProd = 'http://201.49.72.130:8083/issonline/servlet/anfse?wsdl';

    public function enviaRPS($xml)
    {

        if (empty($xml)) {
            throw new InvalidArgumentException('$xml');
        }

        $xml = Strings::clearXmlString($xml);

        $servico = '1';

        $request = $this->envelopXML($xml, $servico);

        $this->lastResponse = $this->sendRequest($request, $this->soapUrlProd);

        $this->lastResponse = $this->removeStuffs($this->lastResponse);

        $this->lastResponse = htmlspecialchars_decode($this->lastResponse);

        $this->lastResponse = substr($this->lastResponse, strpos($this->lastResponse, '<Mensagem>') + 10);

        $this->lastResponse = substr($this->lastResponse, 0, strpos($this->lastResponse, '</Mensagem>'));

        $auxResp = simplexml_load_string($this->lastResponse);
        var_dump($auxResp);
        return (string) $auxResp->return[0];
    }

    public function cancelamento($xml)
    {

        if (empty($xml)) {
            throw new InvalidArgumentException('$xml');
        }

        $xml = Strings::clearXmlString($xml);

        $servico = '2';

        $request = $this->envelopXML($xml, $servico);

        $this->lastResponse = $this->sendRequest($request, $this->soapUrlProd);

        $this->lastResponse = $this->removeStuffs($this->lastResponse);

        $this->lastResponse = htmlspecialchars_decode($this->lastResponse);

        $this->lastResponse = substr($this->lastResponse, strpos($this->lastResponse, '<Mensagem>') + 10);

        $this->lastResponse = substr($this->lastResponse, 0, strpos($this->lastResponse, '</Mensagem>'));

        $auxResp = simplexml_load_string($this->lastResponse);
        var_dump($auxResp);
        return (string) $auxResp->return[0];
    }

    public function consultaLote($xml)
    {

        if (empty($xml)) {
            throw new InvalidArgumentException('$xml');
        }

        $xml = Strings::clearXmlString($xml);

        $servico = '3';

        $request = $this->envelopXML($xml, $servico);

        $this->lastResponse = $this->sendRequest($request, $this->soapUrlProd);

        $this->lastResponse = $this->removeStuffs($this->lastResponse);

        $this->lastResponse = htmlspecialchars_decode($this->lastResponse);

        $this->lastResponse = substr($this->lastResponse, strpos($this->lastResponse, '<Mensagem>') + 10);

        $this->lastResponse = substr($this->lastResponse, 0, strpos($this->lastResponse, '</Mensagem>'));

        $auxResp = simplexml_load_string($this->lastResponse);
        var_dump($auxResp);
        return (string) $auxResp->return[0];
    }

    public function consulta($xml)
    {

        if (empty($xml)) {
            throw new InvalidArgumentException('$xml');
        }

        $xml = Strings::clearXmlString($xml);

        $servico = '4';

        $request = $this->envelopXML($xml, $servico);

        $this->lastResponse = $this->sendRequest($request, $this->soapUrlProd);

        $this->lastResponse = $this->removeStuffs($this->lastResponse);

        $this->lastResponse = htmlspecialchars_decode($this->lastResponse);

        $this->lastResponse = substr($this->lastResponse, strpos($this->lastResponse, '<Mensagem>') + 10);

        $this->lastResponse = substr($this->lastResponse, 0, strpos($this->lastResponse, '</Mensagem>'));

        $auxResp = simplexml_load_string($this->lastResponse);
        var_dump($auxResp);
        return (string) $auxResp->return[0];
    }
}
