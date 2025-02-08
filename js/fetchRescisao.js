let oResultadoCalculo;

async function enviarDadosRescisao(oDados){
    try{
        
        const oResponse = await fetch('/siteCalculoRescisao/calculo-rescisao',{
            method : 'POST',
            headers : {
                'Content-Type' : 'application/json',
                'Accept': 'application/json'
            },
            body : JSON.stringify(oDados)
        });

        const oResultado = await oResponse.json();
        
        if (!oResponse.ok){
            throw new Error(oResultado.erro);
        }

        oResultadoCalculo = oResultado;

        exibirResultado();
        
    } catch (e){
        console.error("Falha na requisição: ", e.message);
        definirAviso(`Erro ao calcular: ${e.message}`,null,"erro");
    }
}

function exibirResultado(){
    definirAviso("Cáculo realizado com sucesso!",null,"sucesso");

    let oDivResultadoResumo = document.getElementById("resultado_resumo");

    console.log(oResultadoCalculo);

    let oProventos = oResultadoCalculo.resultado.proventos;
    let oDescontos = oResultadoCalculo.resultado.descontos;
    let oFgts = oResultadoCalculo.resultado.fgts;

    let sHtml = `
                <h2>Resumo do resultado</h2>
                <table>
                    <tr>
                        <th>Descrição</th>
                        <th>Valor</th>
                    <tr>    

                    <tr>
                        <td>Total a receber (líquido)</td>
                        <td>${oResultadoCalculo.resultado.valor_liquido}</td>
                    </tr>

                    <tr>
                        <td>Proventos</td>
                        <td>${oResultadoCalculo.resultado.total_proventos}</td>
                    </tr>

                    <tr>
                        <td>Descontos</td>
                        <td>${oResultadoCalculo.resultado.total_descontos}</td>
                    </tr>


                </table>

                <button type="button" onclick="exibirDetalhesCalculo()">Exibir Detalhes do Cálculo</button>

                <div id = "detalhes_calculo">
                </div>

                `;

    oDivResultadoResumo.innerHTML = sHtml;
}

function exibirDetalhesCalculo(){

    let oDivResultadoDetalhe = document.getElementById("resultado_detalhe");

    let sHtml = `
            <h2>Detalhes do resultado</h2>
            <table id = "detalhes_calculo">
                <tr>
                    <th>Descrição</th>
                    <th>Valor</th>
                <tr>    

                <tr>
                    <td>Total a receber (líquido)</td>
                    <td>${oResultadoCalculo.resultado.valor_liquido}</td>
                </tr>

                <tr>
                    <td>Proventos</td>
                    <td>${oResultadoCalculo.resultado.total_proventos}</td>
                </tr>

                <tr>
                    <td>Descontos</td>
                    <td>${oResultadoCalculo.resultado.total_descontos}</td>
                </tr>


            </table>

            `;

    oDivResultadoDetalhe.innerHTML = sHtml;

}