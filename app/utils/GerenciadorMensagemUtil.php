<?php

namespace App\Utils;

class GerenciadorMensagemUtil{
    private const TIPOS = [
        'sucesso',
        'erro',
        'aviso'
    ];

    private const ICONES = [
        'sucesso' => '✓',
        'erro' => '✕',
        'aviso' => '⚠',
        '' => ''
    ];

    public static function definirMensagem($sTexto,$sPagina,$sTipo = ''){
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $sTipo = strtolower($sTipo);
        if (!in_array($sTipo,self::TIPOS)){
            $sTipo = '';
        }

        $_SESSION['mensagem_sistema'] = [
            'texto' => $sTexto,
            'tipo' => $sTipo
        ];

        header('Location: ' . $sPagina);
        exit();
    }

    public static function exibirMensagem(){
        if (isset($_SESSION['mensagem_sistema'])){
            $aMensagem = $_SESSION['mensagem_sistema'];
            self::renderizarMensagem($aMensagem);
            unset($_SESSION['mensagem_sistema']);
        }
    }

    private static function renderizarMensagem($aMensagem){

        $sIcone = self::ICONES[$aMensagem['tipo']];
        echo <<<HTML
                <div id="mensagem_sistema" class="mensagem_sistema">
                <span class="icone-mensagem">{$sIcone}</span>
                <span class="texto-mensagem">{$aMensagem['texto']}</span>
                </div>
            HTML;
    }
    
}