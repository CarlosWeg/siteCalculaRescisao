<main class="">

    <section class="flex items-center flex-col pt-30 bg-blue-500 text-white">
    <h1 class="text-3xl font-bold text-blue-500">Tailwind CSS Funcionando!</h1>
        <p class="mb-6 text-lg">Simplificamos o complexo processo de cálculo da sua rescisão trabalhista. Nossa calculadora online gratuita oferece estimativas em poucos cliques</p>
        <a href="#calculadora" class="bg-white text-blue-500 rounded-lg">Faça uma simulação!</a>
    </section>

    <section class="container-formulario container" id="calculadora">

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