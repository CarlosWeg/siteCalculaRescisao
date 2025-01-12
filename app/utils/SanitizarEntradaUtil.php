<?php

namespace App\Utils;

class SanitizarEntradaUtil{

    public static function sanitizarEntrada($valor,$sTipo){

        $valor = trim($valor);
        $sTipo = strtolower($sTipo);

        if ($sTipo === 'string'){
            return htmlspecialchars($valor,ENT_QUOTES,'UTF-8');
        }

        if ($sTipo === 'inteiro'){
            return filter_var($valor,FILTER_SANITIZE_NUMBER_INT);
        }

        if ($sTipo === 'float'){
            return filter_var($valor,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
        }

        if ($sTipo === 'data'){
            $sFormato = 'Y-m-d';
            return \DateTime::createFromFormat($sFormato,$valor);
        }

        return $valor;

    }

}