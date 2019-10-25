<?php
namespace NFePHP\NFSe\Aracatuba;

use NFePHP\Common\DOMImproved as Dom;
use NFePHP\Common\Strings;
use stdClass;
use RuntimeException;
use DOMElement;
use DateTime;

class Make{
    
    public $dom;

    public $xml;

    public $user = '02949160000379';

    public $password = '123456';

    public $inscricaoUser = '50778';

    public $versaoNFSE = '1.00';

    public function __construct() {
        
        $this->dom = new Dom();

        $this->dom->preserveWhiteSpace = false;

        $this->dom->formatOutput = false;
    }

    public function gerarNota(){

        $method = '1';

        $root = $this->dom->createElement('NFSE');
        $this->dom->appendChild($root);

        $identificacao = $this->dom->createElement('IDENTIFICACAO');
        $root->appendChild($identificacao);

        $mesComp = $this->dom->createElement('MESCOMP', '1');
        $identificacao->appendChild($mesComp);

        $anoComp = $this->dom->createElement('ANOCOMP', '1');
        $identificacao->appendChild($anoComp);

        $inscricao = $this->dom->createElement('INSCRICAO', $this->inscricaoUser);
        $identificacao->appendChild($inscricao);

        $versao = $this->dom->createElement('VERSAO', $this->versaoNFSE);
        $identificacao->appendChild($versao);

        $notas = $this->dom->createElement('NOTAS');
        $root->appendChild($notas);

        $nota = $this->dom->createElement('NOTA');
        $notas->appendChild($nota);

        $lote = $this->dom->createElement('LOTE', '1');
        $nota->appendChild($lote);

        $sequencia = $this->dom->createElement('SEQUENCIA', '1');
        $nota->appendChild($sequencia);

        $dataEmissao = $this->dom->createElement('DATAEMISSAO', '1');
        $nota->appendChild($dataEmissao);

        $horaEmissao = $this->dom->createElement('HORAEMISSAO', '1');
        $nota->appendChild($horaEmissao);

        $local = $this->dom->createElement('LOCAL', '1');
        $nota->appendChild($local);

        $ufFora = $this->dom->createElement('UFFORA', '1');
        $nota->appendChild($ufFora);

        $municipioFora = $this->dom->createElement('MUNICIPIOFORA', '1');
        $nota->appendChild($municipioFora);

        $paisFora = $this->dom->createElement('PAISFORA', '1');
        $nota->appendChild($paisFora);

        $situacao = $this->dom->createElement('SITUACAO', '1');
        $nota->appendChild($situacao);

        $retido = $this->dom->createElement('RETIDO', '1');
        $nota->appendChild($retido);

        $atividade = $this->dom->createElement('ATIVIDADE', '1');
        $nota->appendChild($atividade);

        $aliquotaAplicada = $this->dom->createElement('ALIQUOTAAPLICADA', '1');
        $nota->appendChild($aliquotaAplicada);

        $deducao = $this->dom->createElement('DEDUCAO', '1');
        $nota->appendChild($deducao);

        $imposto = $this->dom->createElement('IMPOSTO', '1');
        $nota->appendChild($imposto);

        $retencao = $this->dom->createElement('RETENCAO', '1');
        $nota->appendChild($retencao);

        $observacao = $this->dom->createElement('OBSERVACAO', '1');
        $nota->appendChild($observacao);

        $cpfCnpj = $this->dom->createElement('CPFCNPJ', '1');
        $nota->appendChild($cpfCnpj);

        $nomeRazao = $this->dom->createElement('NOMERAZAO', '1');
        $nota->appendChild($nomeRazao);

        $nomeFantasia = $this->dom->createElement('NOMEFANTASIA', '1');
        $nota->appendChild($nomeFantasia);

        $municipio = $this->dom->createElement('MUNICIPIO', '1');
        $nota->appendChild($municipio);

        $bairro = $this->dom->createElement('BAIRRO', '1');
        $nota->appendChild($bairro);

        $cep = $this->dom->createElement('CEP', '1');
        $nota->appendChild($cep);

        $prefixo = $this->dom->createElement('PREFIXO', '1');
        $nota->appendChild($prefixo);

        $logradouro = $this->dom->createElement('LOGRADOURO', '1');
        $nota->appendChild($logradouro);

        $complemento = $this->dom->createElement('COMPLEMENTO', '1');
        $nota->appendChild($complemento);

        $numero = $this->dom->createElement('NUMERO', '1');
        $nota->appendChild($numero);

        $dentroPais = $this->dom->createElement('DENTROPAIS', '1');
        $nota->appendChild($dentroPais);

        $dedMateriais = $this->dom->createElement('DEDMATERIAIS', '1');
        $nota->appendChild($dedMateriais);

        $dataVencimento = $this->dom->createElement('DATAVENCIMENTO', '1');
        $nota->appendChild($dataVencimento);

        $servicos = $this->dom->createElement('SERVICOS');
        $nota->appendChild($servicos);

        $servico = $this->dom->createElement('SERVICO');
        $servicos->appendChild($servico);

        $descricao = $this->dom->createElement('DESCRICAO', '1');
        $servico->appendChild($descricao);

        $valorUnit = $this->dom->createElement('VALORUNIT', '1');
        $servico->appendChild($valorUnit);

        $quantidade = $this->dom->createElement('QUANTIDADE', '1');
        $servico->appendChild($quantidade);

        $this->xml = $this->dom->saveXML();
        
        return $this->envelopXML($this->xml, $method);
    }

    public function cancelamento(){
        
        $method = '2';

        $root = $this->dom->createElement('NFSE');
        $this->dom->appendChild($root);

        $identificacao = $this->dom->createElement('IDENTIFICACAO');
        $root->appendChild($identificacao);

        $inscricao = $this->dom->createElement('INSCRICAO', $this->inscricaoUser);
        $identificacao->appendChild($inscricao);

        $lote = $this->dom->createElement('LOTE', '1');
        $identificacao->appendChild($lote);

        $sequencia = $this->dom->createElement('SEQUENCIA', '1');
        $identificacao->appendChild($sequencia);

        $observacao = $this->dom->createElement('OBSERVACAO', '1');
        $identificacao->appendChild($observacao);

        $this->xml = $this->dom->saveXML();
        
        return $this->envelopXML($this->xml, $method);
    }

    public function consultaLote(){

        $method = '3';

        $root = $this->dom->createElement('NFSE');
        $this->dom->appendChild($root);

        $identificacao = $this->dom->createElement('IDENTIFICACAO');
        $root->appendChild($identificacao);

        $inscricao = $this->dom->createElement('INSCRICAO', $this->inscricaoUser);
        $identificacao->appendChild($inscricao);

        $lote = $this->dom->createElement('LOTE', '1');
        $identificacao->appendChild($lote);

        $this->xml = $this->dom->saveXML();

        return $this->envelopXML($this->xml, $method);
    }

    public function consulta(){

        $method = '4';

        $root = $this->dom->createElement('NFSE');
        $this->dom->appendChild($root);

        $identificacao = $this->dom->createElement('IDENTIFICACAO');
        $root->appendChild($identificacao);

        $inscricao = $this->dom->createElement('INSCRICAO', $this->inscricaoUser);
        $identificacao->appendChild($inscricao);

        $lote = $this->dom->createElement('LOTE', '1');
        $identificacao->appendChild($lote);

        $sequencia = $this->dom->createElement('SEQUENCIA', '1');
        $identificacao->appendChild($sequencia);

        $this->xml = $this->dom->saveXML();

        return $this->envelopXML($this->xml, $method);
    }

    public function envelopXML($xml, $method){
        
        $xml = trim(preg_replace("/<\?xml.*?\?>/", "", $xml));

        $envelope =
        '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:nfse="nfse">
            <soapenv:Header/>
            <soapenv:Body>
               <nfse:Nfse.Execute>
                  <nfse:Operacao>' . $method . '</nfse:Operacao>
                  <nfse:Usuario>' . $this->user . '</nfse:Usuario>
                  <nfse:Senha>' . md5($this->password) . '</nfse:Senha>
                  <nfse:Webxml>' . htmlspecialchars($xml) . '</nfse:Webxml>
               </nfse:Nfse.Execute>
            </soapenv:Body>
        </soapenv:Envelope>';
        echo $envelope;
        return $envelope;
    }
}