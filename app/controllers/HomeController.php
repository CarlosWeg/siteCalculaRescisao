<?php

namespace App\Controllers;
use App\Utils\HeadUtil;
use App\Utils\MetaTagsUtil;


class HomeController{
    private const CAMINHO_VIEWS = 'app/views';
    private const CAMINHO_VIEWS_TEMPLATES = 'app/views/templates';
    private const CAMINHO_VIEWS_HEADER = 'app/views/templates/header.php';
    private const CAMINHO_VIEWS_FOOTER = 'app/views/templates/footer.php';

    public function index(){
        $oMetaTagsIndex = new MetaTagsUtil();
        $oHeadUtilIndex = new HeadUtil($oMetaTagsIndex);
        $oHeadUtilIndex->adicionarLinksJs('js/formulario.js');
        $oHeadUtilIndex->adicionarLinksJs('js/calculoRescisao.js');
        $oHeadUtilIndex->renderizar();
        require_once self::CAMINHO_VIEWS_HEADER;
        require_once self::CAMINHO_VIEWS . '/pagina_inicial.php';
        require_once self::CAMINHO_VIEWS_FOOTER;
    }

    public function perguntasFrequentes(){
        $oMetaTagsPerguntas = new MetaTagsUtil();
        $oHeadUtilPerguntas = new HeadUtil($oMetaTagsPerguntas);
        $oHeadUtilPerguntas->renderizar();
        require_once self::CAMINHO_VIEWS_HEADER;
        require_once self::CAMINHO_VIEWS . '/perguntas_frequentes.php';
        require_once self::CAMINHO_VIEWS_FOOTER;
    }

    public function sugestoes(){
        $oMetaTagsSugestoes = new MetaTagsUtil();
        $oHeadUtilSugestoes = new HeadUtil($oMetaTagsSugestoes);
        $oHeadUtilSugestoes->renderizar();
        require_once self::CAMINHO_VIEWS_HEADER;
        require_once self::CAMINHO_VIEWS . '/sugestoes.php';
        require_once self::CAMINHO_VIEWS_FOOTER;
    }

}