<?php


namespace App\Controllers;
use App\Models\SugestaoModel;
use App\Utils\SanitizarEntradaUtil;
use App\Utils\enviarRetornoUtil;


class SugestaoController extends BaseController{

    public function __construct(){
        parent::__construct();
    }

    public function validarEntrada(){
        $aDados = parent::validarEntradaBasica();

        $aDadosSanitizados = [
            'nome_contato' => SanitizarEntradaUtil::sanitizarEntrada($aDados['nome_contato'], 'string'),
            'email_contato' => SanitizarEntradaUtil::sanitizarEntrada($aDados['email_contato'], 'string'),
            'mensagem_contato' => SanitizarEntradaUtil::sanitizarEntrada($aDados['mensagem_contato'], 'string')
        ];

        if (empty($aDadosSanitizados['mensagem_contato'])){
            throw new \Exception('Campo obrigatório não fornecido: Deixe sua mensagem');
        }

        return $aDadosSanitizados;

    }

    public function enviar(){
        try{
            $aDados = $this->validarEntrada();
            $oContato = new SugestaoModel($aDados);
            $oContato->enviar();
        } catch (\Exception $e){
            enviarRetornoUtil::enviarErro('Erro ao enviar o formulário:' . $e->getMessage());
        }
    }
    
}