<?php

namespace Core;


class Router{

    private $aRotas = [];

    public function addRota($sMetodo, $sCaminho, $aAcao){

        $this->aRotas[] = [
            'metodo' => strtoupper($sMetodo),
            'caminho' => $sCaminho,
            'acao' => $aAcao,
        ];

    }

    public function resolver($sMetodoRequest, $sRequestUri){

        $sRequestUri = str_replace('/siteCalculoRescisao','',$sRequestUri);

        // Percorre todas as rotas registradas
        foreach($this->aRotas as $rota){
            
            // Verifica se o metodo HTTP e o caminho da rota registrada coincide com a requisição
            if ($rota['metodo'] == strtoupper($sMetodoRequest) && $rota['caminho'] == $sRequestUri){

                // Se a ação da rota for uma função, executa diretamente
                if (is_callable($rota['acao'])){
                    call_user_func($rota['acao']); //Executa a função
                    return;
                }

                //Se a ação da rota for um array (classe e método):
                if (is_array($rota['acao'])){
                    $oController = new $rota['acao'][0](); //Cria uma instancia
                    $sMetodo = $rota['acao'][1]; //Obtem o nome do metodo
                
                    //Verifica se o método existe, chama e encerra
                    if (method_exists($oController,$sMetodo)){
                        $oController->$sMetodo();
                        return;
                    }            
                
                }
        
            }

        }

        http_response_code(404);

        if (file_exists('views/404.php')){
            include_once 'views/404.php';
            return;
        }
        
        echo "<h1>404 - Página não encontrada</h1>";
        echo "<p>Desculpe, a página solicita não existe</p>";
    
    }   

}