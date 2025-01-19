<?php

namespace App\Controllers;
use App\Models\CalculoRescisaoModel;
use App\Utils\SanitizarEntradaUtil;

class calculoRescisaoController{
    public function 

    public function validarEntrada(){

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
                $aDadosValidados['salario_bruto'] = SanitizarEntradaUtil::sanitizarEntrada($_POST['salario_bruto'],'float');
                $aDadosValidados['data_contratacao'] = SanitizarEntradaUtil::sanitizarEntrada($_POST['data_contratacao'],'data');
                $aDadosValidados['data_demissao'] = SanitizarEntradaUtil::sanitizarEntrada($_POST['data_demissao'],'data');
                $aDadosValidados['motivo_rescisao'] = SanitizarEntradaUtil::sanitizarEntrada($_POST['motivo_rescisao'],'string');
                $aDadosValidados['tipo_aviso_previso'] = SanitizarEntradaUtil::sanitizarEntrada($_POST['tipo_aviso_previo'],'string');
                $aDadosValidados['saldo_fgts_antes'] = isset($_POST['saldo_fgts_Antes']) ? SanitizarEntradaUtil::sanitizarEntrada($_POST['saldo_fgts_antes'],'float') : 0;
                $aDadosValidados['numero_dependentes'] = isset($_POST['numero_dependentes']) ? SanitizarEntradaUtil::sanitizarEntrada($_POST['numero_dependentes'],'inteiro') : 0;
                $aDadosValidados['ferias_vencidas'] = isset($_POST['ferias_vencidas']) ? true : false;

                return $aDadosValidados;
        }
    }

}