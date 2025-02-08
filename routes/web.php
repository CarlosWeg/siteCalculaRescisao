<?php

$oRouter->addRota('GET', '/', [\App\Controllers\HomeController::class,'index']);
$oRouter->addRota('POST', '/calculo-rescisao', [\App\Controllers\CalculoRescisaoController::class, 'calcular']);