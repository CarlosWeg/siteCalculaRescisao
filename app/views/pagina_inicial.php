<main class="main-content-container container">

    <section class="container-introducao container">
        <h1>Calculadora de Rescisão Trabalhista</h1>
        <p>Simplificamos o complexo processo de cálculo da sua rescisão trabalhista. Nossa calculadora online gratuita oferece estimativas em poucos cliques</p>
        <p>Descubra quanto deve ser recebido (ou pago). <span class = "simule-agora">Faça uma simulação!</span></p>
    </section>

    <section class="container-formulario container">

        <?php include_once 'app/views/templates/formulario_rescisao.php';?>

        <p><small><strong>Atenção:</strong>Os valores e informações apresentadas podem conter imprecisões, trate-os como uma simulação. Esta ferramenta não substitui o acompanhamento de um profissional qualificado da área trabalhista.</small></p>
    
    </section>
    
    <section id="container_resultado" class="container-resultado container">

        <div id = "resultado_resumo" class = "resultado"></div>

        <div id = "resultado_detalhe" class = "resultado"></div>

    </section>

    <section id="container-exemplo-simulacao" class="container-exemplo-simulacao container">

    </section>

    <?php include_once 'app/views/como_calcular_rescisao_trabalhista.php';?>

</main>