<?php

namespace App\Models;

class CalculoRescisaoModel{
    private $fSalarioBruto;
    private $dDataContratacao;
    private $dDataDemissao;
    private $sMotivoRescisao;
    private $sTipoAvisoPrevio;
    private $fSaldoFgtsAntes;
    private $iNumeroDependentes;
    private $bFeriasVencidas;

    public function __construct($aDados){
        $this->fSalarioBruto = $aDados['salario_bruto'];
        $this->dDataContratacao = $aDados['data_contratacao'];
        $this->dDataDemissao = $aDados['data_demissao'];
        $this->sMotivoRescisao = $aDados['motivo_rescisao'];
        $this->sTipoAvisoPrevio = $aDados['tipo_aviso_previo'];
        $this->fSaldoFgtsAntes = $aDados['saldo_fgts_antes'];
        $this->iNumeroDependentes = $aDados['numero_dependentes'];
        $this->bFeriasVencidas = isset($aDados['ferias_vencidas']) ? true : false;
    }

    public function calcularTempoServico(){
        $oIntervalo = $this->dDataContratacao->diff($this->dDataDemissao);

        return [
            'anos' => $oIntervalor->y,
            'meses' => $oIntervalo->m,
            'dias' => $oIntervalo->d
        ];
    }

    public function calcularSaldoSalario(){
        $iDiasTrabalhados = $this->dDataDemissao->format('d');
        return ($this->fSalarioBruto / 30) * $iDiasTrabalhados;
    }

    public function calcularDecimoTerceiro(){
        $iMesesTrabalhados = $this->dDataDemissao->format('m');
        return ($this->fSalarioBruto / 12) * $iMesesTrabalhados;
    }  

}