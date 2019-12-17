<?php

namespace NFePHP\NFSe\Aracatuba\Factories;

/**
 * @category   NFePHP
 * @package    NFePHP\NFSe\Aracatuba\Factories\
 * @copyright  Copyright (c) 2008-2019
 * @license    http://www.gnu.org/licenses/lesser.html LGPL v3
 * @author     Marlon O. Barbosa <marlon.academi at gmail dot com>
 * @link       https://github.com/Focus599Dev/sped-nfsginfe for the canonical source repository
 */

use NFePHP\NFSe\Aracatuba\Make;
use stdClass;
use NFePHP\Common\Strings;
use App\Http\Model\Uteis;

class Parser
{

    /**
     * @var array
     */
    protected $structure;

    /**
     * @var Make
     */
    protected $make;

    /**
     * @var stdClass
     */
    protected $loteRps;

    /**
     * @var stdClass
     */
    protected $tomador;

    /**
     * @var stdClass
     */
    protected $servico;

    protected $std;

    /**
     * Configure environment to correct NFSe layout
     * @param string $version
     */
    public function __construct($version = '3.0.1')
    {

        $ver = str_replace('.', '', $version);

        $path = realpath(__DIR__ . "/../../storage/txtstructure$ver.json");

        $this->std = new \stdClass();

        $this->std->tomador = new \stdClass();

        $this->std->prestador = new \stdClass();

        $this->structure = json_decode(file_get_contents($path), true);

        $this->version = $version;

        $this->make = new Make();
    }

    /**
     * Convert txt to XML
     * @param array $nota
     * @return string|null
     */
    public function toXml($nota)
    {

        $std = $this->array2xml($nota);

        $this->fixFields();

        if ($this->make->getXML($this->std)) {

            return $this->make->getXML($this->std);
        }

        return null;
    }

    /**
     * Converte txt array to xml
     * @param array $nota
     * @return void
     */
    protected function array2xml($nota)
    {

        $obj = [];

        foreach ($nota as $lin) {

            $fields = explode('|', $lin);

            $struct = $this->structure[strtoupper($fields[0])];

            $std = $this->fieldsToStd($fields, $struct);

            $obj = (object) array_merge((array) $obj, (array) $std);
        }

        return $obj;
    }

    protected function fieldsToStd($dfls, $struct)
    {

        $sfls = explode('|', $struct);

        $len = count($sfls) - 1;

        for ($i = 1; $i < $len; $i++) {

            $name = $sfls[$i];

            if (isset($dfls[$i]))
                $data = $dfls[$i];
            else
                $data = '';

            if (!empty($name)) {

                if ($dfls[0] == 'C') {

                    $this->std->prestador->$name = Strings::replaceSpecialsChars($data);
                } elseif ($dfls[0] == 'E' || $dfls[0] == 'E02') {

                    $this->std->tomador->$name = Strings::replaceSpecialsChars($data);
                } else {

                    $this->std->$name = Strings::replaceSpecialsChars($data);
                }
            }
        }

        return $this->std;
    }

    protected function fixFields()
    {

        $impostos = ['Pis', 'Cofins', 'Inss', 'Ir', 'Csll', 'Icms', 'Ipi', 'Iof', 'Cide', 'OutrosTributos', 'OutrasRetencoes'];

        $aux = explode('T', $this->std->DataEmissao);

        $aux[0] = trim(Uteis::convertDateMysqltoBR($aux[0]));

        $this->std->DataEmissao = $aux[0];
        $this->std->HoraEmissao = $aux[1];

        if ($this->std->IssRetido == '1') {

            $this->std->IssRetido = 'S';
        } else {

            $this->std->IssRetido = 'N';
            $this->std->ValorIssRetido = '0.00';
        }

        foreach ($impostos as $value) {

            $this->std->{'Ret' . $value} = $this->retImpostos($this->std->{'Valor' . $value});

            $this->std->{'Valor' . $value} = $this->valorImpostos($this->std->{'Ret' . $value});
        }
    }

    protected function retImpostos($imposto)
    {

        if ($imposto) {

            return $ret = 'S';
        } else {

            return $ret = 'N';
        }
    }

    protected function valorImpostos($imposto)
    {

        if ($imposto = 'N') {

            return $ret = '0.00';
        }
    }
}
