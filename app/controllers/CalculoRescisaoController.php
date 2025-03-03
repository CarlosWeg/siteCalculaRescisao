<?php

namespace App\Controllers;
use App\Models\CalculoRescisaoModel;
use App\Utils\SanitizarEntradaUtil;
use App\Utils\GerenciadorMensagemUtil;
use App\Utils\enviarRetornoUtil;

class CalculoRescisaoController extends BaseController{
    private const ANO_MIN = 1990;
    private const ANO_LIMITE = 2035;

    public function __construct(){
        parent::__construct();
    }

    public function validarEntrada(){

        $aDados = parent::validarEntradaBasica();

        $aDadosSanitizados = [
            'salario_bruto' => SanitizarEntradaUtil::sanitizarEntrada($aDados['salario_bruto'], 'float') ?? 0,
            'data_contratacao' => SanitizarEntradaUtil::sanitizarEntrada($aDados['data_contratacao'], 'data'),
            'data_demissao' => SanitizarEntradaUtil::sanitizarEntrada($aDados['data_demissao'], 'data'),
            'motivo_rescisao' => SanitizarEntradaUtil::sanitizarEntrada($aDados['motivo_rescisao'], 'string'),
            'tipo_aviso_previo' => SanitizarEntradaUtil::sanitizarEntrada($aDados['tipo_aviso_previo'], 'string'),
            'saldo_fgts_antes' => SanitizarEntradaUtil::sanitizarEntrada($aDados['saldo_fgts_antes'], 'float') ?? 0,
            'numero_dependentes' => SanitizarEntradaUtil::sanitizarEntrada($aDados['numero_dependentes'], 'inteiro') ?? 0,
            'ferias_vencidas' => $aDados['ferias_vencidas'] ?? false
        ];

        $aCamposObrigatorios = ['salario_bruto','data_contratacao','data_demissao','motivo_rescisao','tipo_aviso_previo'];

        foreach ($aCamposObrigatorios as $sCampo){
            if (!isset($aDadosSanitizados[$sCampo]) || empty($aDadosSanitizados[$sCampo])){
                $sCampo = obterNomeCampo($sCampo);
                throw new \Exception("Campo obrigatório não fornecido : {$sCampo}");
            }
        }

        $aMotivosPermitidos = ['pedido_demissao','dispensa_sem_justa_causa','dispensa_com_justa_causa','rescisao_acordo'];
        if (!in_array($aDadosSanitizados['motivo_rescisao'], $aMotivosPermitidos)) {
            throw new \Exception('Motivo de rescisão inválido');
        }

        $aTiposAvisoPermitidos = ['indenizado', 'trabalhado'];
        if (!in_array($aDadosSanitizados['tipo_aviso_previo'], $aTiposAvisoPermitidos)) {
            throw new \Exception('Tipo de aviso prévio inválido');
        }

        if ($aDadosSanitizados['salario_bruto'] <= 0){
            throw new \Exception('Salário bruto deve ser maior que zero');
        }

        if (isset($aDadosSanitizados['saldo_fgts_antes']) && $aDadosSanitizados['saldo_fgts_antes'] < 0){
            throw new \Exception('Saldo FGTS não pode ser negativo');
        }

        if ($aDadosSanitizados['data_contratacao'] > $aDadosSanitizados['data_demissao']){
            throw new \Exception('Data de contratação não pode ser superior a data de demissão');
        }

        if ($aDadosSanitizados['data_contratacao']->format('Y') > self::ANO_LIMITE || $aDadosSanitizados['data_demissao']->format('Y') > self::ANO_LIMITE){
            throw new \Exception('Datas não podem ser superiores a ' . self::ANO_LIMITE);
        }

        if ($aDadosSanitizados['data_contratacao']->format('Y') < self::ANO_MIN || $aDadosSanitizados['data_demissao']->format('Y') < self::ANO_MIN){
            throw new \Exception('Datas não podem ser inferiores a ' . self::ANO_MIN);
        }

        if ($aDadosSanitizados['numero_dependentes'] < 0){
            throw new \Exception('Número de dependentes não pode ser negativo');
        }

        return $aDadosSanitizados; 
    }

    public function calcular(){
        try{
            $aDados = $this->validarEntrada();
            $oCalculoRescisao = new CalculoRescisaoModel($aDados);
            $aResultado = $oCalculoRescisao->calcularRescisao();

            enviarRetornoUtil::enviarResposta([
                'status' => 'sucesso',
                'resultado' => $aResultado
            ]);
        
        } catch (\Exception $e){
            enviarRetornoUtil::enviarErro($e->getMessage());
        }

    }

    private function obterNomeCampo($sCampo){
        switch($sCampo){
            case 'salario_bruto':
                return 'Salário Bruto';
            
            case 'data_contratacao':
                return 'Data de Contratação';

            case 'data_demissao':
                return 'Data de Demissão';

            case 'motivo_rescisao':
                return 'Motivo da Rescisão';

            case 'tipo_aviso_previo':
                return 'Tipo de Aviso Prévio';

            default:
                return $sCampo;
        }
    }

}