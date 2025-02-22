<main class="flex flex-col min-h-screen">

    <section class="flex
                   items-center
                   flex-col
                   w-full
                   pt-36
                   py-16
                   text-white
                   bg-blue-500">
        <div class="max-w-4xl mx-auto px-4 text-center">

            <h1 class="text-3xl lg:text-5xl font-bold text-white mb-8">Calcula Rescisão</h1>
            <p class="mb-8 text-lg">Simplificamos o complexo processo de cálculo da sua rescisão trabalhista.</p>
            
            <a href="#calculadora" class="bg-white text-blue-500
                                          font-semibold
                                          inline-block
                                          text-lg
                                          rounded-lg
                                          px-6 py-3
                                          transform
                                          transition-all
                                          duration-300
                                          hover:-translate-y-1">
                Faça uma simulação!
            </a>

        </div>
    </section>

    <section id="calculadora" class="section_container scroll-mt-28">

        <?php include_once 'app/views/templates/formulario_rescisao.php';?>

    </section>
    
    <section id="container_resultado" class="section_container">

        <div id="resultado_resumo" class="resultado"></div>

        <div id="resultado_detalhe" class="resultado"></div>

    </section>

    <section id="container-explicacao" class="section_container">

        <?php include_once 'app/views/como_calcular_rescisao_trabalhista.php';?>

        <div class="bg-gray-200
                    text-gray-700
                    text-center p-4
                    border
                    border-gray-800
                    rounded-md
                    max-w-3xl
                    m-auto
                    mt-8">

        <p><small><strong>Atenção: </strong>Os valores e informações apresentadas podem conter imprecisões, trate-os como uma simulação.</p>
        <p>Esta ferramenta não substitui o acompanhamento de um profissional qualificado da área trabalhista.</small></p>
        
        </div>

    </section>

</main>