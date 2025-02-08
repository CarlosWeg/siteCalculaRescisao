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

    let sHtml = `
                <h2>Resumo do resultado</h2>
                <table id="tabela_resumo" class = "tabela_calculo">
                    <tr>
                        <th>Descrição</th>
                        <th>Valor</th>
                    </tr>    

                    <tr>
                        <td>Proventos</td>
                        <td>${formatarMoeda(oResultadoCalculo.resultado.total_proventos)}</td>
                    </tr>

                    <tr>
                        <td>Descontos</td>
                        <td>${formatarMoeda(oResultadoCalculo.resultado.total_descontos)}</td>
                    </tr>

                    <tr>
                        <td>Total a receber (líquido)</td>
                        <td>${formatarMoeda(oResultadoCalculo.resultado.valor_liquido)}</td>
                    </tr>

                </table>

                <button type="button" onclick="exibirDetalhesCalculo()">Exibir Detalhes do Cálculo</button>

                `;

    oDivResultadoResumo.innerHTML = sHtml;
}

function formatarMoeda(fValor){
    return fValor.toLocaleString('pt-BR',{
        style: 'currency',
        currency: 'BRL'
    });
}

function exibirDetalhesCalculo(){

    let oProventos = oResultadoCalculo.resultado.proventos;
    let oDescontos = oResultadoCalculo.resultado.descontos;
    let oFgts = oResultadoCalculo.resultado.fgts;

    let oDivResultadoDetalhe = document.getElementById("resultado_detalhe");

    let sHtml = `
            <h2>Detalhes do resultado</h2>

            <h3>Proventos</h3>

            <table id="tabela_proventos" class="tabela_calculo">
                <tr>
                    <th>Descrição</th>
                    <th>Valor</th>
                </tr>    

                <tr>
                    <td>Saldo Salário</td>
                    <td>${formatarMoeda(oProventos.saldo_salario)}</td>
                </tr>

                <tr>
                    <td>Aviso prévio</td>
                    <td>${formatarMoeda(oProventos.saldo_salario)}</td>
                </tr>


                <tr>
                    <td>Décimo terceiro</td>
                    <td>${formatarMoeda(oProventos.decimo_terceiro)}</td>
                </tr>

                <tr>
                    <td>Férias proporcionais</td>
                    <td>${formatarMoeda(oProventos.ferias_proporcionais)}</td>
                </tr>

                <tr>
                    <td>Férias vencidas</td>
                    <td>${formatarMoeda(oProventos.ferias_vencidas)}</td>
                </tr>

                <tr>
                    <td>Total proventos</td>
                    <td>${formatarMoeda(oResultadoCalculo.resultado.total_proventos)}</td>
                </tr>


            </table>

            <h3>Descontos</h3>

            <table id="tabela_descontos" class="tabela_calculo">
                <tr>
                    <th>Descrição</th>
                    <th>Valor</th>
                </tr>    

                <tr>
                    <td>IRRF (Imposto de Renda Retido na Fonte)</td>
                    <td>${formatarMoeda(oDescontos.irrf)}</td>
                </tr>

                <tr>
                    <td>INSS (Instituto Nacional do Seguro Social)</td>
                    <td>${formatarMoeda(oDescontos.inss)}</td>
                </tr>

                <tr>
                    <td>Total descontos</td>
                    <td>${formatarMoeda(oResultadoCalculo.resultado.total_descontos)}</td>
                </tr>


            </table>

            <h3>FGTS</h3>

            <table id="tabela_fgts" class="tabela_calculo">
                <tr>
                    <th>Descrição</th>
                    <th>Valor</th>
                </tr>    

                <tr>
                    <td>Saldo Total</td>
                    <td>${formatarMoeda(oFgts.saldo_total)}</td>
                </tr>

                <tr>
                    <td>Multa</td>
                    <td>${formatarMoeda(oFgts.multa)}</td>
                </tr>

            </table>

            `;

    oDivResultadoDetalhe.innerHTML = sHtml;

}