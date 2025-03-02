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
    private const ALIQUOTA_FGTS = 0.08;

    public function __construct($aDados){

        $this->fSalarioBruto = $aDados['salario_bruto'];
        $this->dDataContratacao = $aDados['data_contratacao'];
        $this->dDataDemissao = $aDados['data_demissao'];
        $this->sMotivoRescisao = $aDados['motivo_rescisao'];
        $this->sTipoAvisoPrevio = $aDados['tipo_aviso_previo'];
        $this->fSaldoFgtsAntes = $aDados['saldo_fgts_antes'] ?? 0;
        $this->iNumeroDependentes = $aDados['numero_dependentes'] ?? 0;
        $this->bFeriasVencidas = $aDados['ferias_vencidas'] ?? false;
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
        $iAnoContratacao = (int)$this->dDataContratacao->format('Y');
        $iAnoDemissao = (int)$this->dDataDemissao->format('Y');

        // Se a contratação foi no mesmo ano da demissão
        if ($iAnoContratacao == $iAnoDemissao){
            $iMesContratacao = (int)$this->dDataContratacao->format('m');
            $iMesDemissao = (int)$this->dDataDemissao->format('m');

            // Se alguém foi contratado em maio (mês 5) e demitido em agosto (mês 8), a diferença seria 8 - 5 = 3, indicando junho, julho e agosto. No entanto, isso ignora o mês de contratação (maio).
            // Por isso, + 1

            $iMesesTrabalhados = $iMesDemissao - $iMesContratacao + 1;

        // Se a contratação foi em anos anteriores
        } else {
            $iMesesTrabalhados = $this->dDataDemissao->format('m');
        }

        if ($this->dDataDemissao->format('d')<15){
            $iMesesTrabalhados--;    
        }

        // Para garantir que o valor nunca será negativo
        $iMesesTrabalhados = max(0,$iMesesTrabalhados);

        return ($this->fSalarioBruto / 12) * $iMesesTrabalhados;
    }  

    private function calcularFerias(){
        $aTempoServico = $this->calcularTempoServico();
        $iMeses = $aTempoServico['meses'];
        $fValorFerias = $this->fSalarioBruto;


        // Considerar dias trabalhados no último mês
        if ($aTempoServico['dias'] > 14){
            $iMeses++;
        }

        // Calcula o valor do terço constitucional sobre as férias.
        $fTercoFerias = $fValorFerias / 3;

        $fFeriasProporcionais = ($fValorFerias / 12) * $iMeses;
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
            $iDiasAviso = 30 + min(3 * $this->aTempoTrabalhado['anos'] , 90);
            return ($this->fSalarioBruto / 30) * $iDiasAviso;
        }
        return 0;
    }

    private function calcularFgts($aFerias,$fDecimoTerceiro){

        // FGTS sobre férias (proporcionais e vencidas)
        $fFgtsFerias = ($aFerias['ferias_proporcionais'] + $aFerias['ferias_vencidas']) * self::ALIQUOTA_FGTS;

        // FGTS sobre 13
        $fFgtsDecimoTerceiro = $fDecimoTerceiro * self::ALIQUOTA_FGTS;

        // FGTS sobre salário mensal
        $fDepositoMensais = $this->fSalarioBruto * self::ALIQUOTA_FGTS;

        // Total fgts sobre o salário mensal nos meses trabalhados
        $iMeses = $this->aTempoTrabalhado['anos'] * 12 + $this->aTempoTrabalhado['meses'];
        $fTotalDepositadoTempo = $fDepositoMensais * $iMeses;

        $fSaldoTotal = $fTotalDepositadoTempo + $fFgtsDecimoTerceiro + $fFgtsFerias + $this->fSaldoFgtsAntes;

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
        // Verbas indenizatórias não entram na base do INSS
        $fBaseInss = $fValor - $this->calcularAvisoPrevio();

        //Tabela INSS 2025
        if ($fBaseInss <= 1518.00) return ($fBaseInss * 0.075) - 0;
        if ($fBaseInss <= 2793.88) return ($fBaseInss * 0.09) - 22.77;
        if ($fBaseInss <= 4190.83) return ($fBaseInss * 0.12) - 106.6;
        if ($fBaseInss <= 8157.41) return ($fBaseInss * 0.14) - 190.4;
        
        return 951.63;

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
        $aFgts = $this->calcularFgts($aFerias,$fDecimoTerceiro);

        $fProventos = $fSaldoSalario + $fDecimoTerceiro + $aFerias['ferias_vencidas'] +
                      $aFerias['ferias_proporcionais'] + $fAvisoPrevio;
            
        $fInss = $this->calcularInss($fProventos);

        // Não há irf sobre verbas indenizatórias
        $fBaseIrrf = $fProventos - $fAvisoPrevio - $fInss;
        $fIrrf = $this->calcularIrrf($fBaseIrrf);

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