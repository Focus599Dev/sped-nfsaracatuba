<?php

namespace NFePHP\NFSe\Aracatuba;

use NFePHP\NFSe\Aracatuba\Common\Tools as ToolsBase;
use NFePHP\Common\Strings;
use DOMDocument;
use NFePHP\Common\DOMImproved as Dom;

class Tools extends ToolsBase
{

    public function enviaRPS($xml)
    {

        if (empty($xml)) {
            throw new InvalidArgumentException('$xml');
        }

        $xml = Strings::clearXmlString($xml);

        $servico = '1';

        $request = $this->envelopXML($xml, $servico);

        $this->lastResponse = $this->sendRequest($request, $this->soapUrl);

        $this->lastResponse = htmlspecialchars_decode($this->lastResponse);

        $this->lastResponse = $this->removeStuffs($this->lastResponse);

        $auxResp = simplexml_load_string($this->lastResponse);

        return $auxResp;
    }

    public function cancelamento($xml)
    {

        if (empty($xml)) {
            throw new InvalidArgumentException('$xml');
        }

        $xml = Strings::clearXmlString($xml);

        $servico = '2';

        $request = $this->envelopXML($xml, $servico);

        $this->lastResponse = $this->sendRequest($request, $this->soapUrl);

        $this->lastResponse = htmlspecialchars_decode($this->lastResponse);

        $this->lastResponse = $this->removeStuffs($this->lastResponse);

        $this->lastResponse = substr($this->lastResponse, strpos($this->lastResponse, '<Mensagem>') + 10);

        $this->lastResponse = substr($this->lastResponse, 0, strpos($this->lastResponse, '</Mensagem>'));

        $auxResp = simplexml_load_string($this->lastResponse);

        return $auxResp;
    }

    public function consultaLote($xml)
    {

        if (empty($xml)) {
            throw new InvalidArgumentException('$xml');
        }

        $xml = Strings::clearXmlString($xml);

        $servico = '3';

        $request = $this->envelopXML($xml, $servico);

        $this->lastResponse = $this->sendRequest($request, $this->soapUrl);

        $this->lastResponse = htmlspecialchars_decode($this->lastResponse);

        $this->lastResponse = $this->removeStuffs($this->lastResponse);

        $this->lastResponse = substr($this->lastResponse, strpos($this->lastResponse, '<Mensagem>') + 10);

        $this->lastResponse = substr($this->lastResponse, 0, strpos($this->lastResponse, '</Mensagem>'));

        $auxResp = simplexml_load_string($this->lastResponse);

        return $auxResp;
    }

    public function consulta($xml)
    {

        if (empty($xml)) {
            throw new InvalidArgumentException('$xml');
        }

        $xml = Strings::clearXmlString($xml);

        $servico = '4';

        $request = $this->envelopXML($xml, $servico);

        $this->lastResponse = $this->sendRequest($request, $this->soapUrl);

        $this->lastResponse = htmlspecialchars_decode($this->lastResponse);

        $this->lastResponse = $this->removeStuffs($this->lastResponse);

        $this->lastResponse = substr($this->lastResponse, strpos($this->lastResponse, '<Mensagem>') + 10);

        $this->lastResponse = substr($this->lastResponse, 0, strpos($this->lastResponse, '</Mensagem>'));

        $auxResp = simplexml_load_string($this->lastResponse);

        return $auxResp;
    }
}
