<?php

$oRouter->addRota('GET', '/', [\App\Controllers\HomeController::class,'index']);
$oRouter->addRota('POST', '/calculo-rescisao', [\App\Controllers\CalculoRescisaoController::class, 'calcular']);

$oRouter->addRota('GET','/sugestoes',[\App\Controllers\HomeController::class,'sugestoes']);
$oRouter->addRota('POST','/enviar-sugestao',[\App\Controllers\SugestaoController::class,'enviar']);

$oRouter->addRota('GET','/perguntas-frequentes',[\App\Controllers\HomeController::class,'perguntasFrequentes']);

//$oRouter->addRota('GET','/como-calcular-rescisao-trabalhista',[\App\Controllers\HomeController::class,'comoCalcular']);