<?php

namespace NFePHP\NFSe\Aracatuba;

use NFePHP\Common\DOMImproved as Dom;

class Make
{

    public $dom;

    public $xml;

    public $inscricaoUser = '50778';

    public $versaoNFSE = '1.00';

    public function __construct()
    {

        $this->dom = new Dom();

        $this->dom->preserveWhiteSpace = false;

        $this->dom->formatOutput = false;
    }

    public function getXML($std)
    {

        if (empty($this->xml)) {

            $this->gerarNota($std);
        }

        return $this->xml;
    }

    public function gerarNota($std)
    {

        $root = $this->dom->createElement('NFSE');
        $this->dom->appendChild($root);

        $identificacao = $this->dom->createElement('IDENTIFICACAO');
        $root->appendChild($identificacao);

        $this->dom->addChild(
            $identificacao,                 // pai    
            "MESCOMP",                      // nome
            $std->MesCompetencia,           // valor
            true,                           // se é obrigatorio
            "Mes de competencia, 2 digitos" // descrição se der catch
        );

        $this->dom->addChild(
            $identificacao,
            "ANOCOMP",
            $std->AnoCompetencia,
            true,
            "Ano de competencia, 4 digitos"
        );

        $this->dom->addChild(
            $identificacao,
            "INSCRICAO",
            $this->inscricaoUser,
            true,
            "Inscrição mobiliária do prestador da NFS-e"
        );

        $this->dom->addChild(
            $identificacao,
            "VERSAO",
            $this->versaoNFSE,
            true,
            "Versão do leiaute do arquivo"
        );

        $notas = $this->dom->createElement('NOTAS');
        $root->appendChild($notas);

        $nota = $this->dom->createElement('NOTA');
        $notas->appendChild($nota);

        $this->dom->addChild(
            $nota,
            "RPS",
            $std->RPSNum,
            true,
            "Número do Recibo Provisório de Serviços, até 14 caracteres"
        );

        $this->dom->addChild(
            $nota,
            "LOTE",
            $std->NumeroLote,
            true,
            "lote da nfs-e, até 9 caracteres"
        );

        $this->dom->addChild(
            $nota,
            "SEQUENCIA",
            '1',
            // $std->sequencia,
            true,
            "sequência da NFS-e, até 9 caracteres"
        );

        $this->dom->addChild(
            $nota,
            "DATAEMISSAO",
            $std->DataEmissao,
            true,
            "data da NFS-e, e aceita apenas números e o separador para o formato Data"
        );

        $this->dom->addChild(
            $nota,
            "HORAEMISSAO",
            $std->HoraEmissao,
            true,
            "hora da NFS-e, e aceita apenas números e o separador para o formato hora"
        );

        $this->dom->addChild(
            $nota,
            "LOCAL",
            $std->tomador->Local,
            true,
            "local em que o serviço foi prestado"
        );

        $this->dom->addChild(
            $nota,
            "UFFORA",
            $std->tomador->UfFora,
            false,
            "sigla da Unidade Federativa em que o serviço foi prestado"
        );

        $this->dom->addChild(
            $nota,
            "MUNICIPIOFORA",
            $std->tomador->MunicipioFora,
            false,
            "código do município em que o serviço foi prestado"
        );

        $this->dom->addChild(
            $nota,
            "PAISFORA",
            $std->tomador->PaisFora,
            false,
            "país em que o serviço foi prestado"
        );

        $this->dom->addChild(
            $nota,
            "SITUACAO",
            // $std->tomador->Situacao,
            '1',
            false,
            "código da situação da NFS-e, e aceita números inteiros de até 4 caracteres"
        );

        $this->dom->addChild(
            $nota,
            "RETIDO",
            $std->IssRetido,
            true,
            "identificação se o imposto será ou não"
        );

        $this->dom->addChild(
            $nota,
            "ATIVIDADE",
            $std->CodigoCnae,
            false,
            "código da atividade da NFS-e, e aceita até 10 caracteres alfanuméricos"
        );

        $this->dom->addChild(
            $nota,
            "ALIQUOTAAPLICADA",
            $std->Aliquota,
            true,
            "alíquota da NFS-e, e aceita apenas valores no formato Decimal"
        );

        $this->dom->addChild(
            $nota,
            "DEDUCAO",
            $std->Deducao,
            true,
            "dedução da NFS-e, e aceita apenas valores no formato Decimal"
        );

        $this->dom->addChild(
            $nota,
            "IMPOSTO",
            $std->Imposto,
            true,
            "imposto da NFS-e, e aceita apenas valores no formato Decimal"
        );

        $this->dom->addChild(
            $nota,
            "RETENCAO",
            $std->ValorIssRetido,
            true,
            "valor da retenção"
        );

        $this->dom->addChild(
            $nota,
            "OBSERVACAO",
            $std->Observacao,
            false,
            "observações sobre a NFS-e"
        );

        $this->dom->addChild(
            $nota,
            "CPFCNPJ",
            $std->tomador->Cnpj,
            true,
            "CPF ou CNPJ do tomador da NFS-e, e aceita até 20 caracteres alfanuméricos"
        );

        $this->dom->addChild(
            $nota,
            "RGIE",
            $std->tomador->RgIe,
            false,
            "RG ou IE do tomador da NFS-e, e aceita até 15 caracteres"
        );

        $this->dom->addChild(
            $nota,
            "NOMERAZAO",
            $std->tomador->RazaoSocial,
            true,
            "Razão social do tomador da NFS-e"
        );

        $this->dom->addChild(
            $nota,
            "NOMEFANTASIA",
            $std->tomador->NomeFantasia,
            false,
            "nome fantasia do tomador da NFS-e"
        );

        $this->dom->addChild(
            $nota,
            "MUNICIPIO",
            $std->tomador->CodigoMunicipio,
            true,
            "código do município da empresa do tomador"
        );

        $this->dom->addChild(
            $nota,
            "BAIRRO",
            $std->tomador->Bairro,
            true,
            "descrição do bairro do tomador"
        );

        $this->dom->addChild(
            $nota,
            "CEP",
            $std->tomador->Cep,
            true,
            "CEP  da  empresa  do  tomador"
        );

        $this->dom->addChild(
            $nota,
            "PREFIXO",
            $std->tomador->Prefixo,
            false,
            "descrição resumida do prefixo do logradouro do tomador"
        );

        $this->dom->addChild(
            $nota,
            "LOGRADOURO",
            $std->tomador->Endereco,
            true,
            "descrição do logradouro do tomador da NFS-e"
        );

        $this->dom->addChild(
            $nota,
            "COMPLEMENTO",
            $std->tomador->Complemento,
            false,
            "complemento  do  endereço"
        );

        $this->dom->addChild(
            $nota,
            "NUMERO",
            $std->tomador->Numero,
            true,
            "número da empresa do tomador"
        );

        $this->dom->addChild(
            $nota,
            "EMAIL",
            $std->tomador->Email,
            true,
            "email da empresa do tomador"
        );

        $this->dom->addChild(
            $nota,
            "DENTROPAIS",
            $std->tomador->DentroPais,
            false,
            "indica se o tomador é de dentro"
        );

        $this->dom->addChild(
            $nota,
            "DEDMATERIAIS",
            $std->DeduMateriais,
            false,
            "se houve ou não dedução de materiais"
        );

        $this->dom->addChild(
            $nota,
            "DATAVENCIMENTO",
            $std->DataVencimento,
            false,
            "data para pagamento do serviço"
        );

        $this->dom->addChild(
            $nota,
            "CONTRAAPRESENTACAO",
            $std->ContraApresentacao,
            false,
            "Contra Apresentação com relação à Data de Vencimento da NFS-e"
        );

        $this->dom->addChild(
            $nota,
            "PIS",
            $std->ValorPis,
            true,
            "valor do Programa de Integração Social(PIS)"
        );

        $this->dom->addChild(
            $nota,
            "RETPIS",
            $std->RetPis,
            false,
            "informar se será deduzido do valor liquido da NFS-e"
        );

        $this->dom->addChild(
            $nota,
            "COFINS",
            $std->ValorCofins,
            true,
            "valor da Contribuição para o Financiamento da Seguridade Social(COFINS)"
        );

        $this->dom->addChild(
            $nota,
            "RETCOFINS",
            $std->RetCofins,
            false,
            "informar se será deduzido do valor liquido da NFS-e"
        );

        $this->dom->addChild(
            $nota,
            "INSS",
            $std->ValorInss,
            true,
            "valor do Instituto Nacional do Seguro Social(INSS)"
        );

        $this->dom->addChild(
            $nota,
            "RETINSS",
            $std->RetInss,
            false,
            "informar se será deduzido do valor liquido da NFS-e"
        );

        $this->dom->addChild(
            $nota,
            "IR",
            $std->ValorIr,
            true,
            "valor do Imposto de Renda(IR)"
        );

        $this->dom->addChild(
            $nota,
            "RETIR",
            $std->RetIr,
            false,
            "informar se será deduzido do valor liquido da NFS-e"
        );

        $this->dom->addChild(
            $nota,
            "CSLL",
            $std->ValorCsll,
            true,
            "valor da Contribuição Social sobreo Lucro Líquido (CSLL)"
        );

        $this->dom->addChild(
            $nota,
            "RETCSLL",
            $std->RetCsll,
            false,
            "informar se será deduzido do valor liquido da NFS-e"
        );

        $this->dom->addChild(
            $nota,
            "ICMS",
            $std->ValorIcms,
            true,
            "valor do Imposto sobre Circulação de Mercadorias e Serviços(ICMS)"
        );

        $this->dom->addChild(
            $nota,
            "RETICMS",
            $std->RetIcms,
            false,
            "informar se será deduzido do valor liquido da NFS-e"
        );

        $this->dom->addChild(
            $nota,
            "IPI",
            $std->ValorIpi,
            true,
            "valor do Imposto Sobre Produtos Industrializados(IPI)"
        );

        $this->dom->addChild(
            $nota,
            "RETIPI",
            $std->RetIpi,
            false,
            "informar se será deduzido do valor liquido da NFS-e"
        );

        $this->dom->addChild(
            $nota,
            "IOF",
            $std->ValorIof,
            true,
            "valor do Imposto sobre operações financeiras(IOF)"
        );

        $this->dom->addChild(
            $nota,
            "RETIOF",
            $std->RetIof,
            false,
            "informar se será deduzido do valor liquido da NFS-e"
        );

        $this->dom->addChild(
            $nota,
            "CIDE",
            $std->ValorCide,
            true,
            "valor das Contribuições de Intervenção no Domínio Econômico(CIDE)"
        );

        $this->dom->addChild(
            $nota,
            "RETCIDE",
            $std->RetCide,
            false,
            "informar se será deduzido do valor liquido da NFS-e"
        );

        $this->dom->addChild(
            $nota,
            "OUTROSTRIBUTOS",
            $std->ValorOutrosTributos,
            true,
            "valor de Outros Tributos"
        );

        $this->dom->addChild(
            $nota,
            "RETOUTROSTRIBUTOS",
            $std->RetOutrosTributos,
            false,
            "informar se será deduzido do valor liquido da NFS-e"
        );

        $this->dom->addChild(
            $nota,
            "OUTRASRETENCOES",
            $std->ValorOutrasRetencoes,
            true,
            "valor de Outros Impostos"
        );

        $this->dom->addChild(
            $nota,
            "RETOUTRASRETENCOES",
            $std->RetOutrasRetencoes,
            false,
            "informar se será deduzido do valor liquido da NFS-e"
        );

        $this->dom->addChild(
            $nota,
            "OBRA",
            $std->Obra,
            false,
            "código da obra"
        );

        $servicos = $this->dom->createElement('SERVICOS');
        $nota->appendChild($servicos);

        foreach ($std->servico as $key) {

            $servico = $this->dom->createElement('SERVICO');
            $servicos->appendChild($servico);

            $this->dom->addChild(
                $servico,
                "DESCRICAO",
                $key[4],
                true,
                "descrição do serviço da NFS-e"
            );

            $this->dom->addChild(
                $servico,
                "VALORUNIT",
                $key[12],
                true,
                "Refere-se ao valor unitário do serviço "
            );

            $this->dom->addChild(
                $servico,
                "QUANTIDADE",
                $key[13],
                true,
                "quantidade do serviço"
            );

            $this->dom->addChild(
                $servico,
                "DESCONTO",
                $key[14],
                true,
                "valor do desconto de um serviço"
            );

            $this->dom->addChild(
                $servico,
                "ALIQUOTATRIBUTOS",
                $std->AliquotaAtributos,
                false,
                "alíquota do tributo aproximado do serviço"
            );
        }

        $materiais = $this->dom->createElement('MATERIAIS');
        $nota->appendChild($materiais);

        $material = $this->dom->createElement('MATERIAL');
        $materiais->appendChild($material);

        $this->dom->addChild(
            $material,
            "MATDESCRICAO",
            $std->MatDescricao,
            false,
            "descrição do material"
        );

        $this->dom->addChild(
            $material,
            "MATVALORUNIT",
            $std->MatValorUnit,
            false,
            "valor unitário do material"
        );

        $this->dom->addChild(
            $material,
            "MATQUANTIDADE",
            $std->MatQuantidade,
            false,
            "quantidade do material"
        );

        $this->dom->addChild(
            $material,
            "MATNOTA",
            $std->MatNota,
            false,
            "número da nota do fornecedor do material"
        );

        $this->dom->addChild(
            $material,
            "MATCPFCNPJ",
            $std->MatCpfCnpj,
            false,
            "CPF/CNPJ do fornecedor do material"
        );

        $this->xml = $this->dom->saveXML();

        return $this->xml;
    }

    public function cancelamento($std)
    {

        $root = $this->dom->createElement('NFSE');
        $this->dom->appendChild($root);

        $identificacao = $this->dom->createElement('IDENTIFICACAO');
        $root->appendChild($identificacao);

        $this->dom->addChild(
            $identificacao,
            "INSCRICAO",
            $this->inscricaoUser,
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

    public function consultaLote($std)
    {

        $root = $this->dom->createElement('NFSE');
        $this->dom->appendChild($root);

        $identificacao = $this->dom->createElement('IDENTIFICACAO');
        $root->appendChild($identificacao);

        $this->dom->addChild(
            $identificacao,
            "INSCRICAO",
            $this->inscricaoUser,
            true,
            "Inscrição mobiliária do prestador da NFS-e"
        );

        $this->dom->addChild(
            $identificacao,
            "LOTE",
            $std->nfml_numero_lote,
            true,
            "Lote da NFS-e, numeros inteiros de até 9"
        );

        $this->xml = $this->dom->saveXML();

        return $this->xml;
    }

    public function consulta($std)
    {

        $root = $this->dom->createElement('NFSE');
        $this->dom->appendChild($root);

        $identificacao = $this->dom->createElement('IDENTIFICACAO');
        $root->appendChild($identificacao);

        $this->dom->addChild(
            $identificacao,
            "INSCRICAO",
            $this->inscricaoUser,
            true,
            "Inscrição mobiliária do prestador da NFS-e"
        );

        $this->dom->addChild(
            $identificacao,
            "LOTE",
            $std->NumeroLote,
            true,
            "Lote da NFS-e, numeros inteiros de até 9"
        );

        $this->dom->addChild(
            $identificacao,
            "SEQUENCIA",
            $std->Sequencia,
            true,
            "Sequência da NFS-e, numeros inteiros de até 9"
        );

        $this->xml = $this->dom->saveXML();

        return $this->xml;
    }
}
