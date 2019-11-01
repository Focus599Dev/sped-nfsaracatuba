<?php 

namespace NFePHP\NFSe\Aracatuba\Soap;

use NFePHP\NFSe\Aracatuba\Make;

class Soap{

    public function __construct() {

        $obj = new Make;

        $xml = $obj->gerarNota();

        $this->send($xml, $soapUrl);
    }

    public function send($xml, $soapUrl){

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURLOPT_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_SSLVERSION, 4);
        curl_setopt($ch, CURLOPT_URL, $soapUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_VERBOSE, true);

        $response = curl_exec($ch);
        echo $response;
        curl_close($ch);

        return $response;
    }
}