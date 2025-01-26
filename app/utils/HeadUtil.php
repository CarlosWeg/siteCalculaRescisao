<?php

namespace Utils\CabecalhoUtil;
use App\Utils\MetaTagsUtil;


class HeadUtil{
    private $oMetaTags;
    private $aLinksCss = [];
    private $aLinksJs = [];

    public function __construct(MetaTags $oMetaTags){
        $this->oMetaTags = $oMetaTags ?? new MetaTags();
    }

    public function adicionarLinksCss($sCaminho){
        $this->aLinksCss[] = $sCaminho;
    }

    public function adicionarLinksJs($sCaminho){
        $this->aLinksJs[] = $sCaminho;
    }

    public function renderizar(){

        $this->oMetaTags->renderizar();


        foreach($this->aLinksCss as $css){
            echo "\n<link rel='stylesheet' href={$css}>";
        }

        foreach($this->aLinksJs as $js){
            echo "\n<script src='{$js}'></script>";
        }

    }

}