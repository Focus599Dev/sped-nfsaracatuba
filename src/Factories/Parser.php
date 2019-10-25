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
use NFePHP\NFSe\Aracatuba\Exception\DocumentsException;
use stdClass;
use NFePHP\Common\Strings;

class Parser {

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

    /**
     * Configure environment to correct NFSe layout
     * @param string $version
    */
    public function __construct($version = '3.0.1'){
        
        $ver = str_replace('.', '', $version);

        $path = realpath(__DIR__ . "/../../storage/txtstructure$ver.json");

        $this->structure = json_decode(file_get_contents($path), true);

        $this->version = $version;

        $this->make = new Make();
    }

    /**
     * Convert txt to XML
     * @param array $nota
     * @return string|null
     */
    public function toXml($nota) {
       
        $this->array2xml($nota);

        if ($this->make->monta()) {

            return $this->make->getXML();

        }

        return null;
    }

    /**
     * Converte txt array to xml
     * @param array $nota
     * @return void
    */
    protected function array2xml($nota){

        foreach ($nota as $lin) {
            
            $fields = explode('|', $lin);

            if (empty($fields)) {
                continue;
            }

            $metodo = strtolower(str_replace(' ', '', $fields[0])).'Entity';

            if (!method_exists(__CLASS__, $metodo)) {
                //campo não definido
                throw DocumentsException::wrongDocument(16, $lin);
            }

            $struct = $this->structure[strtoupper($fields[0])];

            $std = $this->fieldsToStd($fields, $struct);

            $this->$metodo($std);
        }
    }

    /**
     * Creates stdClass for all tag fields
     * @param array $dfls
     * @param string $struct
     * @return stdClass
    */
   
    protected static function fieldsToStd($dfls, $struct) {
        
        $sfls = explode('|', $struct);
        
        $len = count($sfls)-1;
        
        $std = new \stdClass();

        for ($i = 1; $i < $len; $i++) {
            
            $name = $sfls[$i];
            
            if (isset($dfls[$i]))
                $data = $dfls[$i];
            else 
                $data = '';

            if (!empty($name)) {

                $std->$name = Strings::replaceSpecialsChars($data);
            }

        }

        return $std;
    }
}