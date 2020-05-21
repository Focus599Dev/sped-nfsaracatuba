   public function cancelamento($std)
    {

        $root = $this->dom->createElement('NFSE');
        $this->dom->appendChild($root);

        $identificacao = $this->dom->createElement('IDENTIFICACAO');
        $root->appendChild($identificacao);

        $this->dom->addChild(
            $identificacao,
            "INSCRICAO",
            $this->InscricaoMunicipal,
            true,
            "Inscrição mobiliária do prestador da NFS-e"
        );

        $this->dom->addChild(
            $identificacao,
            "LOTE",
            $std->sequencia,
            true,
            "Lote da NFS-e, numeros inteiros de até 9"
        );

        $this->dom->addChild(
            $identificacao,
            "SEQUENCIA",
            '1',
            // $std->sequencia,
            true,
            "Sequência da NFS-e, numeros inteiros de até 9"
        );

        $this->dom->addChild(
            $identificacao,
            "OBSERVACAO",
            $std->observacao,
            true,
            "Observação do cancelamento da NFS-e"
        );

        $this->xml = $this->dom->saveXML();

        return $this->xml;
    }
