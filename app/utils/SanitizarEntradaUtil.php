<?php

namespace App\Utils;

class SanitizarEntradaUtil{

    public static function sanitizarEntrada($xValor,$sTipo){

        if ($xValor === null){
            return null;
        }

        $xValor = trim($xValor);
        $sTipo = strtolower($sTipo);

        if ($xValor === '') {
            return null;
        }

        switch ($sTipo) {
            case 'inteiro':
                return self::sanitizarInteiro($xValor);

            case 'float':
                return self::sanitizarFloat($xValor);

            case 'data':
                return self::sanitizarData($xValor);

            default:
                return self::sanitizarString($xValor);
        }

    }

    private static function sanitizarFloat($xValor){
        // Remove tudo exceto números, vírgula e ponto
        $xValor = preg_replace('/[^\d,]/', '', $xValor);

        //Substitui vírgula por ponto
        $xValor = str_replace(',','.',$xValor);

        if (substr_count($xValor,'.') > 1) {
            // Divide a string nos pontos
            $sPartes = explode('.', $xValor); 
            // -1 Pega todos os elementos exceto o último
            // Junta todos esses números
            // End Pega o último elemento do array original
            // Junta tudo por um ponto
            $xValor = implode('',array_slice($sPartes,0,-1) . '.' . end($sPartes));
        }

        return filter_var($xValor, FILTER_VALIDATE_FLOAT) !== false ? (float)$xValor : null;
    }

    private static function sanitizarInteiro($xValor){
        $xValor = preg_replace('/[^\d]/', '', $xValor);

        return filter_var($xValor, FILTER_VALIDATE_INT) !== false ? (int)$xValor : null;    
    }

    private static function sanitizarData($xValor){
        $sFormato = 'Y-m-d';
        $dData =  \DateTime::createFromFormat($sFormato,$xValor);

        if ($dData && $dData->format($sFormato) == $xValor){
            return $dData;
        }

        return null;
    }

    private static function sanitizarString($xValor){
        return htmlspecialchars($xValor,ENT_QUOTES,'UTF-8');
    }

}