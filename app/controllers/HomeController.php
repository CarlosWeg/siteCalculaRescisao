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
        $oHeadUtilIndex->adicionarLinksJs('js/formularioRescisao.js');
        $oHeadUtilIndex->adicionarLinksJs('js/mensagem.js');
        $oHeadUtilIndex->adicionarLinksCss('./output.css');
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
        $oHeadUtilSugestoes->adicionarLinksJs('js/formularioSugestao.js');
        $oHeadUtilSugestoes->adicionarLinksJs('js/mensagem.js');
        $oHeadUtilSugestoes->renderizar();
        require_once self::CAMINHO_VIEWS_HEADER;
        require_once self::CAMINHO_VIEWS . '/sugestoes.php';
        require_once self::CAMINHO_VIEWS_FOOTER;
    }

    public function comoCalcular(){
        $oMetaTagsExplicacao = new MetaTagsUtil();
        $oHeadUtilExplicacao = new HeadUtil($oMetaTagsExplicacao);
        $oHeadUtilExplicacao->renderizar();
        require_once self::CAMINHO_VIEWS_HEADER;
        require_once self::CAMINHO_VIEWS . '/como_calcular_rescisao_trabalhista.php';
        require_once self::CAMINHO_VIEWS_FOOTER;

    }

}