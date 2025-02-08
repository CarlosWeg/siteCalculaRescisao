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

}