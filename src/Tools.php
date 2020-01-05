<?php

namespace NFePHP\NFSe\Aracatuba;

use NFePHP\NFSe\Aracatuba\Common\Tools as ToolsBase;
use NFePHP\Common\Strings;
use NFePHP\NFSe\Aracatuba\Make;

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

        $this->lastRequest = htmlspecialchars_decode($request);

        $request = $this->envelopSoapXML($request);

        $auxRequest = $this->sendRequest($request, $this->soapUrl);

        $auxRequest = htmlspecialchars_decode($auxRequest);

        $auxRequest = $this->removeStuffs($auxRequest);

        return $auxRequest;
    }

    public function CancelaNfse($std)
    {

        $make = new Make();

        $xml = $make->cancelamento($std);

        $xml = Strings::clearXmlString($xml);

        $servico = '2';

        $request = $this->envelopXML($xml, $servico);

        $request = $this->envelopSoapXML($request);

        $this->lastResponse = $this->sendRequest($request, $this->soapUrl);

        $this->lastResponse = htmlspecialchars_decode($this->lastResponse);

        $this->lastResponse = $this->removeStuffs($this->lastResponse);

        $this->lastResponse = substr($this->lastResponse, strpos($this->lastResponse, '<Mensagem>') + 10);

        $this->lastResponse = substr($this->lastResponse, 0, strpos($this->lastResponse, '</Mensagem>'));

        $auxResp = simplexml_load_string($this->lastResponse);

        return $auxResp;
    }

    public function consultaSituacaoLoteRPS($std)
    {

        $make = new Make();

        $xml = $make->consultaLote($std);

        $xml = Strings::clearXmlString($xml);

        $servico = '3';

        $request = $this->envelopXML($xml, $servico);

        $request = $this->envelopSoapXML($request);
        var_dump('ae');
        $this->lastResponse = $this->sendRequest($request, $this->soapUrl);

        $this->lastResponse = htmlspecialchars_decode($this->lastResponse);

        $this->lastResponse = $this->removeStuffs($this->lastResponse);

        $this->lastResponse = substr($this->lastResponse, strpos($this->lastResponse, '<Mensagem>') + 10);

        $this->lastResponse = substr($this->lastResponse, 0, strpos($this->lastResponse, '</Mensagem>'));

        $auxResp = simplexml_load_string($this->lastResponse);

        return $auxResp;
    }
}
