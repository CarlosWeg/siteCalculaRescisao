<?php

namespace App\Utils;

class enviarRetornoUtil{
    
    public static function enviarResposta($aDados, $iStatus = 200){
        http_response_code($iStatus);
        echo json_encode($aDados);
        exit();
    }

    public static function enviarErro($sMensagem,$iStatus = 400){
        self::enviarResposta(['erro'=>$sMensagem],$iStatus);
    }

}