<?php

namespace App\Controllers;
use App\Models\CalculoRescisaoModel;
use App\Utils\SanitizarEntradaUtil;
use App\Utils\GerenciadorMensagemUtil;

class CalculoRescisaoController{

    public function __construct(){
        header('Content-Type: application/json');
    }

    private function enviarResposta($aDados, $iStatus = 200){
        http_response_code($iStatus);
        echo json_encode($aDados);
        exit;
    }

    private function enviarErro($sMensagem,$iStatus = 400){
        $this->enviarResposta(['erro'=>$sMensagem],$iStatus);
    }

    public function validarEntrada(){

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['CONTENT_TYPE']) || stripos($_SERVER['CONTENT_TYPE'], 'application/json') === false) {
            $this->enviarErro('Requisição inválida');
        }

        $oJsonInput = file_get_contents('php://input');
        $aDados = json_decode($oJsonInput,true);

        if (!$aDados){
            $this->enviarErro('Requisição inválida');
        }

        try{

            $aDadosSanitizados = [
                'salario_bruto' => SanitizarEntradaUtil::sanitizarEntrada($aDados['salario_bruto'] ?? null, 'float'),
                'data_contratacao' => SanitizarEntradaUtil::sanitizarEntrada($aDados['data_contratacao'] ?? null, 'data'),
                'data_demissao' => SanitizarEntradaUtil::sanitizarEntrada($aDados['data_demissao'] ?? null, 'data'),
                'motivo_rescisao' => SanitizarEntradaUtil::sanitizarEntrada($aDados['motivo_rescisao'] ?? null, 'string'),
                'tipo_aviso_previo' => SanitizarEntradaUtil::sanitizarEntrada($aDados['tipo_aviso_previo'] ?? null, 'string'),
                'saldo_fgts_antes' => SanitizarEntradaUtil::sanitizarEntrada($aDados['saldo_fgts_antes'] ?? 0, 'float'),
                'numero_dependentes' => SanitizarEntradaUtil::sanitizarEntrada($aDados['numero_dependentes'] ?? 0, 'inteiro'),
                'ferias_vencidas' => isset($aDados['ferias_vencidas']) ? (bool)$aDados['ferias_vencidas'] : false
            ];

            $aCamposObrigatorios = ['salario_bruto','data_contratacao','data_demissao','motivo_rescisao','tipo_aviso_previo'];

            foreach ($aCamposObrigatorios as $sCampo){
                if (!isset($aDadosSanitizados[$sCampo]) || empty($aDadosSanitizados[$sCampo])){
                    $this->enviarErro(("Campo obrigatório não fornecido: {$sCampo}"));
                }
            }

            $aMotivosPermitidos = ['dispensa_sem_justa_causa', 'rescisao_acordo'];
            if (!in_array($aDadosSanitizados['motivo_rescisao'], $aMotivosPermitidos)) {
                $this->enviarErro('Motivo de rescisão inválido');
            }
    
            $aTiposAvisoPermitidos = ['indenizado', 'trabalhado'];
            if (!in_array($aDadosSanitizados['tipo_aviso_previo'], $aTiposAvisoPermitidos)) {
                $this->enviarErro('Tipo de aviso prévio inválido');
            }

            if ($aDadosSanitizados['salario_bruto'] <= 0){
                $this->enviarErro('Salário bruto deve ser maior que zero');
            }

            if (isset($aDadosSanitizados['saldo_fgts_antes']) && $aDadosSanitizados['saldo_fgts_antes'] <= 0){
                $this->enviarErro('Saldo FGTS não pode ser negativo');
            }

            if (strtotime($aDadosSanitizados['data_contratacao']) > strtotime($aDadosSanitizados['data_demissao'])){
                $this->enviarErro('Data de contratação não pode ser superior a data de demissão');
            }

            if ($aDadosSanitizados['numero_dependentes'] < 0){
                $this->enviarErro('Número de dependentes não pode ser negativo');
            }

            return $aDadosSanitizados; 
        
        } catch(\Exception $e){
            $this->enviarErro('Dados inválidos' . $e->getMessage());
        }

    }

    public function calcular(){
        try{
            $aDados = $this->validarEntrada();
            $oCalculoRescisao = new CalculoRescisaoModel($aDados);
            $aResultado = $oCalculoRescisao->calcularRescisao();

            
            $this->enviarResposta([
                'status' => 'sucesso',
                'resultado' => $aResultado,
                'dados_funcionario' => $aDados
            ]);
        
        } catch (\Exception $e){
            $this->enviarErro('Erro ao calcular a rescisão : ' . $e->getMessage());
        }

    }

}