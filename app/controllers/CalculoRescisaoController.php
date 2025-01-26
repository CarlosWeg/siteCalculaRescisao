<?php

namespace App\Controllers;
use App\Models\CalculoRescisaoModel;
use App\Utils\SanitizarEntradaUtil;
use App\Utils\GerenciadorMensagemUtil;

class CalculoRescisaoController{

    public function validarEntrada(){

        if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
            return false;
        }

        $aDadosValidados = [
                'salario_bruto' => SanitizarEntradaUtil::sanitizarEntrada($_POST['salario_bruto'],'float'),
                'data_contratacao' => SanitizarEntradaUtil::sanitizarEntrada($_POST['data_contratacao'],'data'),
                'data_demissao' => SanitizarEntradaUtil::sanitizarEntrada($_POST['data_demissao'],'data'),
                'motivo_rescisao' => SanitizarEntradaUtil::sanitizarEntrada($_POST['motivo_rescisao'],'string'),
                'tipo_aviso_previso' => SanitizarEntradaUtil::sanitizarEntrada($_POST['tipo_aviso_previo'],'string'),
                'saldo_fgts_antes' =>isset($_POST['saldo_fgts_Antes']) ? SanitizarEntradaUtil::sanitizarEntrada($_POST['saldo_fgts_antes'],'float') : 0,
                'numero_dependentes' => isset($_POST['numero_dependentes']) ? SanitizarEntradaUtil::sanitizarEntrada($_POST['numero_dependentes'],'inteiro') : 0,
                'ferias_vencidas' => isset($_POST['ferias_vencidas'])
        ];

        if (strtotime($aDadosValidados['data_contratacao']) > strtotime($aDadosValidados['data_demissao'])){
            return false;
        }

        return $aDadosValidados; 

    }

    public function calcular(){
        $aDados = $this->validarEntrada();

        if (!$aDados || $aDados == false){
            GerenciadorMensagemUtil::definirMensagem('Dados inválidos ou método de requisição incorreto. Tente novamente','/','erro');  
            return; 
        }

        $oCalculoRescisao = new CalculoRescisaoModel($aDados);
        $aResultado = $oCalculoRescisao->calcularRescisao();

        $aDadosView = [
            'resultado' => $aResultado,
            'dados_funcionario' => $aDados
        ];


    }

}                                                               