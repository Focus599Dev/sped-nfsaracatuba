<?php

include 'Make.php';
include 'Convert.php';
include 'Soap/Soap.php';
include 'Exception/DocumentsException.php';
include 'Factories/Parser.php';
include '../../sped-common/src/DOMImproved.php';
include '../../sped-common/src/Strings.php';

// $obj = new NFePHP\NFSe\ARACATUBA\Soap\Soap();

$url = realpath(__DIR__ . "/../storage/TxT.txt");

$textoTeste = file_get_contents($url);

$obj = new NFePHP\NFSe\ARACATUBA\Convert;

$obj->toXml($textoTeste);