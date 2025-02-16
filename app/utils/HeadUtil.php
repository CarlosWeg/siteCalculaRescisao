<?php

namespace App\Utils;
use App\Utils\MetaTagsUtil;


class HeadUtil{
    private $oMetaTags;
    private $aLinksCss = [];
    private $aLinksJs = [];

    public function __construct(MetaTagsUtil $oMetaTags){
        $this->oMetaTags = $oMetaTags ?? new MetaTags();
    }

    public function adicionarLinksCss($sCaminho){
        $this->aLinksCss[] = $sCaminho;
    }

    public function adicionarLinksJs($sCaminho){
        $this->aLinksJs[] = $sCaminho;
    }

    public function renderizar(){

        echo '<!DOCTYPE html>';
        echo '<html lang="pt-BR">';
        echo '<head>';

        $this->oMetaTags->renderizar();

        foreach($this->aLinksCss as $css){
            echo "\n<link href='{$css}' rel='stylesheet'>";
        }

        foreach($this->aLinksJs as $js){
            echo "\n<script src='{$js}'></script>";
        }

        echo '</head>';

    }

}