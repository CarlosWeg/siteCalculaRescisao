<?php

namespace App\Controllers;
use App\Utils\HeadUtil;
use App\Utils\MetaTagsUtil;


class HomeController{
    private const CAMINHO_VIEWS = 'app/views';
    private const CAMINHO_VIEWS_TEMPLATES = 'app/views/templates';
    private const CAMINHO_VIEWS_HEADER = 'app/views/templates/header.php';
    private const CAMINHO_VIEWS_FOOTER = 'app/views/templates/footer.php';
    private const CAMINHO_ICON = 'images/logo_calcula_rescisao.png';

    public function index(){
        $oMetaTagsIndex = new MetaTagsUtil(
            'Calculadora de Rescisão Trabalhista | Faça uma simulação',
            'Estime quais os valores você irá receber (ou pagar) numa rescisão trabalhista. Cálculo de rescisão CLT de forma fácil e rápida.',
            'calculadora rescisão, indenização trabalhista, direitos trabalhistas, cálculo de demissão, rescisão CLT, verbas rescisórias'
        );
        $oHeadUtilIndex = new HeadUtil($oMetaTagsIndex);
        $oHeadUtilIndex->adicionarLinksJs('js/formularioRescisao.js');
        $oHeadUtilIndex->adicionarLinksJs('js/mensagem.js');
        $oHeadUtilIndex->adicionarLinksJs('js/utils.js');
        $oHeadUtilIndex->adicionarLinksCss('css/output.css');
        $oHeadUtilIndex->adicionarLinkIcon(self::CAMINHO_ICON);
        $oHeadUtilIndex->renderizar();
        require_once self::CAMINHO_VIEWS_HEADER;
        require_once self::CAMINHO_VIEWS . '/pagina_inicial.php';
        require_once self::CAMINHO_VIEWS_FOOTER;
    }

    public function perguntasFrequentes(){
        $oMetaTagsPerguntas = new MetaTagsUtil(
            'Perguntas Frequentes | Rescisão Trabalhista',
            'Tire suas dúvidas sobre rescisão trabalhista. Entenda seus direitos, cálculos e como proceder em diferentes situações.',
            'dúvidas trabalhistas, perguntas frequentes CLT, rescisão trabalhista, direitos do trabalhador'
        );
        $oHeadUtilPerguntas = new HeadUtil($oMetaTagsPerguntas);
        $oHeadUtilPerguntas->adicionarLinksJs('js/mensagem.js');
        $oHeadUtilPerguntas->adicionarLinksJs('js/utils.js');
        $oHeadUtilPerguntas->adicionarLinksCss('css/output.css');  
        $oHeadUtilPerguntas->adicionarLinkIcon(self::CAMINHO_ICON);  
        $oHeadUtilPerguntas->renderizar();
        require_once self::CAMINHO_VIEWS_HEADER;
        require_once self::CAMINHO_VIEWS . '/perguntas_frequentes.php';
        require_once self::CAMINHO_VIEWS_FOOTER;
    }

    public function sugestoes(){
        $oMetaTagsSugestoes = new MetaTagsUtil(
            'Envie suas Sugestões | Calculadora Trabalhista',
            'Ajude-nos a melhorar! Envie suas sugestões para aprimorar nossa ferramenta de cálculo de rescisão trabalhista.',
            'sugestões, feedback, melhoria de sistema, calculadora de rescisão, opinião de usuários'
        );
        $oHeadUtilSugestoes = new HeadUtil($oMetaTagsSugestoes);
        $oHeadUtilSugestoes->adicionarLinksJs('js/formularioSugestao.js');
        $oHeadUtilSugestoes->adicionarLinksJs('js/mensagem.js');
        $oHeadUtilSugestoes->adicionarLinksJs('js/utils.js');
        $oHeadUtilSugestoes->adicionarLinksCss('css/output.css');
        $oHeadUtilSugestoes->adicionarLinkIcon(self::CAMINHO_ICON);         
        $oHeadUtilSugestoes->renderizar();
        require_once self::CAMINHO_VIEWS_HEADER;
        require_once self::CAMINHO_VIEWS . '/sugestoes.php';
        require_once self::CAMINHO_VIEWS_FOOTER;
    }

}