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
    private $aTempoTrabalhado;

    public function __construct($aDados){
        $this->fSalarioBruto = $aDados['salario_bruto'];
        $this->dDataContratacao = $aDados['data_contratacao'];
        $this->dDataDemissao = $aDados['data_demissao'];
        $this->sMotivoRescisao = $aDados['motivo_rescisao'];
        $this->sTipoAvisoPrevio = $aDados['tipo_aviso_previo'];
        $this->fSaldoFgtsAntes = $aDados['saldo_fgts_antes'];
        $this->iNumeroDependentes = $aDados['numero_dependentes'];
        $this->bFeriasVencidas = $aDados['ferias_vencidas'];
        $this->aTempoTrabalhado = $this->calcularTempoServico();
    }

    private function calcularTempoServico(){
        $oIntervalo = $this->dDataContratacao->diff($this->dDataDemissao);

        return [
            'anos' => $oIntervalo->y,
            'meses' => $oIntervalo->m,
            'dias' => $oIntervalo->d
        ];
    }

    private function calcularSaldoSalario(){
        $iDiasTrabalhados = $this->dDataDemissao->format('d');
        return ($this->fSalarioBruto / 30) * $iDiasTrabalhados;
    }

    private function calcularDecimoTerceiro(){
        $iMesesTrabalhados = $this->dDataDemissao->format('m');
        return ($this->fSalarioBruto / 12) * $iMesesTrabalhados;
    }  

    private function calcularFerias(){
        $aTempoServico = $this->calcularTempoServico();
        $fValorFerias = $this->fSalarioBruto;

        // Calcula o valor do terço constitucional sobre as férias.
        $fTercoFerias = $fValorFerias / 3;

        $fFeriasProporcionais = ($fValorFerias / 12) * $aTempoServico['meses'];
        $fTercoFeriasProporcionais =$fFeriasProporcionais / 3;
        
        // Retorna um array com dois valores: 
        // 'ferias_vencidas': Se houver férias vencidas, soma o valor das férias e o terço constitucional; caso contrário, retorna 0.
        // 'ferias_proporcionais': Soma as férias proporcionais e o terço constitucional sobre as férias proporcionais.
        return [
            'ferias_vencidas' => $this->bFeriasVencidas ? $fValorFerias + $fTercoFerias : 0,
            'ferias_proporcionais' => $fFeriasProporcionais + $fTercoFeriasProporcionais
        ];
    }

    private function calcularAvisoPrevio(){
        if ($this->sTipoAvisoPrevio === 'indenizado'){
            $iDiasAviso = 30 + min(3 * $this->aTempoTrabalhado['anos'] , 60);
            return ($this->fSalarioBruto / 30) * $iDiasAviso;
        }
        return 0;
    }

    private function calcularFgts(){
        $fDepositoMensais = $this->fSalarioBruto * 0.08;
        $fTotalDepositado = $fDepositoMensais * ($this->aTempoTrabalhado['anos'] * 12 + $this->aTempoTrabalhado['meses']);
        $fSaldoTotal = $fTotalDepositado + $this->fSaldoFgtsAntes;

        $fMultaFgts = 0;

        if ($this->sMotivoRescisao === 'dispensa_sem_justa_causa'){
            $fMultaFgts = $fSaldoTotal * 0.4;
        }

        if ($this->sMotivoRescisao === 'rescisao_acordo'){
            $fMultaFgts = $fSaldoTotal * 0.2;
        }

        return [
            'saldo_total' => $fSaldoTotal,
            'multa' => $fMultaFgts
        ];

    }

    private function calcularInss($fValor){
        //Tabela INSS 2025
        if ($fValor <= 1518.00) return $fValor * 0.075;
        if ($fValor <= 2793.88) return $fValor * 0.09;
        if ($fValor <= 4190.83) return $fValor * 0.12;
        if ($fValor <= 8157.41) return $fValor * 0.14;
        
        return 951.62; // Teto

    }

    private function calcularIrrf($fValor){
        // Dedução por dependente
        $fDeducaoDependentes = $this->iNumeroDependentes * 189.59;
        $fValor -= $fDeducaoDependentes;

        // Tabela IRRF 2025
        if ($fValor <= 2259.20) return 0;
        if ($fValor <= 2826.65) return ($fValor * 0.075) - 169.44;
        if ($fValor <= 3751.05) return ($fValor * 0.15) - 381.44;
        if ($fValor <= 4664.68) return ($fValor * 0.225) - 662.77;
        
        return ($fValor * 0.275) - 896; // Acima de R$ 4.664,68

    }

    public function calcularRescisao(){
        $fSaldoSalario = $this->calcularSaldoSalario();
        $fDecimoTerceiro = $this->calcularDecimoTerceiro();
        $aFerias = $this->calcularFerias();
        $fAvisoPrevio = $this->calcularAvisoPrevio();
        $aFgts = $this->calcularFgts();

        $fProventos = $fSaldoSalario + $fDecimoTerceiro + $aFerias['ferias_vencidas'] +
                      $aFerias['ferias_proporcionais'] + $fAvisoPrevio;
        
        $fInss = $this->calcularInss($fProventos);
        $fIrrf = $this->calcularIrrf($fProventos - $fInss);

        $fDescontos = $fInss + $fIrrf;
        
        return [

            'proventos' => [
                'saldo_salario' => $fSaldoSalario,
                'decimo_terceiro' => $fDecimoTerceiro,
                'ferias_vencidas' => $aFerias['ferias_vencidas'],
                'ferias_proporcionais' => $aFerias['ferias_proporcionais'],
                'aviso_previo' => $fAvisoPrevio
            ],

            'descontos' => [
                'inss' => $fInss,
                'irrf' => $fIrrf
            ],

            'fgts' => [
                'saldo_total' => $aFgts['saldo_total'],
                'multa' => $aFgts['multa']
            ],

            'total_proventos' => $fProventos,
            'total_descontos' => $fDescontos,
            'valor_liquido' => $fProventos - $fDescontos

        ];

    }

}