<?php

namespace App\Controllers;
use App\Utils\enviarRetornoUtil;

class BaseController{


    public function __construct(){
        header('Content-Type: application/json');
    }


    public function validarEntradaBasica(){

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['CONTENT_TYPE']) || stripos($_SERVER['CONTENT_TYPE'], 'application/json') === false) {
            throw new \Exception('Requisição inválida');
        }

        $oJsonInput = file_get_contents('php://input');
        $aDados = json_decode($oJsonInput,true);

        if (!$aDados){
            throw new \Exception('Dados não recebidos corretamente');
        }

        return $aDados;

    }

}