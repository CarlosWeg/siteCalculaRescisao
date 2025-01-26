<?php

namespace App\Utils;

class MetaTags{
    private $sTitle;
    private $sDescription;
    private $sKeyWords;
    private $sOgTitle;
    private $sOgDescription;
    private $sOgImage;


    public function __construct($sTitle = '',$sDescription = '',$sKeyWords = '', $sOgTitle = '', $sOgDescription = '' , $sOgImage = ''){
    
        $this->sTitle = $sTitle ?: 'Calculadora de Rescisão Trabalhista | Calcule Seus Direitos'; 
        $this->sDescription = $sDescription ?: 'Calcule sua indenização de forma rápida e precisa. Confira informações sobre rescisão trabalhista';
        $this->sKewWords = $sKeyWords ?: 'calculadora rescisão, indenização trabalhista, direitos trabalhistas, cálculo de demissão, rescisão CLT';
        $this->sOgTitle = $sOgTitle ?: $sTitle;
        $this->sOgDescription = $sOgDescription ?: $sOgDescription;
        $this->sOgImage = $sOgImage ?: 'https://seusite.com/imagem-compartilhamento.jpg';
    }

    public function obterMetaTags(){
        return [
            'title' => htmlspecialchars($this->sTitle),
            'description' => htmlspecialchars($this->sDescription),
            'keywords' => htmlspecialchars($this->sKeyWords),
            'ogtitle' => htmlspecialchars($this->sOgTitle),
            'ogdescription' => htmlspecialchars($this->sOgDescription),
            'ogimage' => htmlspecialchars($this->sOgImage)
        ];
    }

    public function renderizar(){
        $aTags = $this->obterMetaTags();

        echo <<<HTML
                    <title>{$aTags['title']}</title>
                    <meta name="description" content="{$aTags['description']}">
                    <meta name="keywords" content="{$aTags['keywords']}">
                    <meta name="viewport" content="width=device_width, initial-scale=1">
                    <meta name="robots" content="index,follow">

                    <meta property="og:title" content="{$aTags['ogtitle']}">
                    <meta property="og:description" content = "{$aTags['ogdescription']}">
                    <meta property="og:image" content="{$aTags['ogimage']}">;

                HTML;
                
    }

}