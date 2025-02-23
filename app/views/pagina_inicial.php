<main class="main_content">

    <section class="flex items-center flex-col w-full py-16 text-white bg-blue-500">

        <div class="max-w-4xl mx-auto px-4 text-center">

            <h1 class="text-3xl lg:text-5xl font-bold text-white mb-8">Calcula Rescisão</h1>
            <p class="mb-8 text-lg">Simplificamos o complexo processo de cálculo da sua rescisão trabalhista.</p>
            
            <button type="button" id="botao_link_calculadora" class="link_calculadora" onclick='scrollSection("calculadora")'>Faça uma simulação!</button>

        </div>
    </section>

    <section id="calculadora" class="section_container scroll-mt-28">

        <?php include_once 'app/views/templates/formulario_rescisao.php';?>

    </section>
    
    <section id="container_resultado" class="section_container">

        <div id="resultado_resumo" class="resultado scroll-mt-28"></div>

        <div id="resultado_detalhe" class="resultado"></div>

    </section>

    <section id="container_explicacao" class="section_container container_explicacao">
       <?php include_once 'app/views/como_calcular_rescisao_trabalhista.php';?> 

    </section>

    
    <section id="container_aviso" class="section_container">

        <div class="aviso">
            <p class="mb-2"><strong>⚠️ Atenção: </strong>As informações e valores apresentados podem conter imprecisões.</p>
            <p>Esta ferramenta não substitui o acompanhamento de um profissional qualificado da área trabalhista.</p>
        </div>

    </section>
</main>