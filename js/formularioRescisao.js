let oResultadoCalculo = null;
let bResultadosVisiveis = false;

async function validarFormularioRescisao(){
    let oSalarioBruto = document.getElementById("salario_bruto");
    let oDataContratacao = document.getElementById("data_contratacao");
    let oDataDemissao = document.getElementById("data_demissao");
    let oMotivoRescisao = document.getElementById("motivo_rescisao");
    let oTipoAvisoPrevio = document.getElementById("tipo_aviso_previo");
    let oSaldoFgtsAntes = document.getElementById("saldo_fgts_antes");
    let oNumeroDependentes = document.getElementById("numero_dependentes");
    let oFeriasVencidas = document.getElementById("ferias_vencidas");
    let oMensagem = document.getElementById("mensagem_sistema");

    let oForm = document.getElementById("formulario_rescisao"); 
    
    let sTexto = "";

    if (oSalarioBruto.value == ""){
        sTexto = "O campo salário bruto é obrigatório";
        definirAviso(sTexto,oSalarioBruto,"aviso");
        return false;
    }

    if (isNaN(oSalarioBruto.value) || oSalarioBruto.value <= 0){
        sTexto = "O campo salário bruto não pode ser negativo";
        definirAviso(sTexto,oSalarioBruto,"aviso");
        return false;
    }

    if (oDataContratacao.value == ""){
        sTexto = "O campo data de contratação é obrigatório";
        definirAviso(sTexto,oDataContratacao,"aviso");
        return false;
    }

    if (oDataDemissao.value == ""){
        sTexto = "O campo data de demissão é obrigatório";
        definirAviso(sTexto,oDataDemissao,"aviso");
        return false;
    }

    if (!validarDatas(oDataContratacao.value,oDataDemissao.value)){
        sTexto = "A data de demissão deve ser posterior à data de contratação";
        definirAviso(sTexto,oDataDemissao,"aviso");
        return false;
    }

    if (oMotivoRescisao.value == ""){
        sTexto = "O campo motivo de rescisão é obrigatório";
        definirAviso(sTexto,oMotivoRescisao,"aviso");
        return false;
    }

    if (oTipoAvisoPrevio.value == ""){
        sTexto = "O campo tipo de aviso prévio é obrigatório";
        definirAviso(sTexto,oTipoAvisoPrevio,"aviso");
        return false;
    }

    if (oSaldoFgtsAntes.value === "" || isNaN((oSaldoFgtsAntes.value))) {
        oSaldoFgtsAntes.value = 0;
    }
    
    if ((oSaldoFgtsAntes.value) < 0) {
        sTexto = "O saldo do FGTS não pode ser negativo";
        definirAviso(sTexto, oSaldoFgtsAntes,"aviso");
        return false;
    }

    if (oNumeroDependentes.value == ""){
        oNumeroDependentes.value = 0;
    }

    if (oNumeroDependentes.value < 0){
        sTexto = "O campo número de dependentes não pode ser negativo";
        definirAviso(sTexto,oNumeroDependentes,"aviso");
        return false;    
    }

    if (sTexto == ""){
        const oDados = {
            salario_bruto: oSalarioBruto.value,
            data_contratacao: oDataContratacao.value,
            data_demissao: oDataDemissao.value,
            motivo_rescisao: oMotivoRescisao.value,
            tipo_aviso_previo: oTipoAvisoPrevio.value,
            saldo_fgts_antes: oSaldoFgtsAntes.value,
            numero_dependentes: oNumeroDependentes.value,
            ferias_vencidas: oFeriasVencidas.checked
        };

        const oSucesso = await enviarDadosRescisao(oDados);

        if (oSucesso){
            exibirResultado();
            definirAviso("Simulação realizada com sucesso!<br>Confira o resultado.",null,"sucesso");
            scrollSection('resultado_resumo');
            oForm.reset();
        }

    }
}

function validarDatas(sDataContratacao,sDataDemissao){
    let dDataContratacao = new Date(sDataContratacao);
    let dDataDemissao = new Date(sDataDemissao);

    return dDataDemissao > dDataContratacao;
}

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

        return true;

    } catch (e){
        console.error("Falha na requisição: ", e.message);
        definirAviso(`Erro ao calcular: ${e.message}`,null,"erro");
        return false;
    }
}

function formatarMoeda(fValor){
    return fValor.toLocaleString('pt-BR',{
        style: 'currency',
        currency: 'BRL'
    });
}

function toggleDetalhesCalculo(){
    let oDivResultadoDetalhe = document.getElementById("resultado_detalhe");
    let oBotaoDetalhesCalculo = document.getElementById("botao_detalhes_calculo");

    if (bResultadosVisiveis === true){
        oDivResultadoDetalhe.innerHTML = '';
        oBotaoDetalhesCalculo.innerText = 'Exibir detalhes do cálculo';
        bResultadosVisiveis = false;
    } else {
        exibirDetalhesCalculo();
        oBotaoDetalhesCalculo.innerText = 'Ocultar detalhes do cálculo';
        bResultadosVisiveis = true;
    }

}

function exibirResultado(){
    definirAviso("Cáculo realizado com sucesso!",null,"sucesso");

    let oContainer = document.getElementById("container_resultado")
    let oDivResultadoResumo = document.getElementById("resultado_resumo");

    let sHtml = `

                <table id="tabela_resumo" class="tabela_resultado">
                <caption class="titulo_tabela">Resumo do resultado</caption>

                    <tr>
                        <th>Descrição</th>
                        <th class="valor">Valor</th>
                    </tr>    

                    <tr>
                        <td>Proventos</td>
                        <td class="valor">${formatarMoeda(oResultadoCalculo.resultado.total_proventos)}</td>
                    </tr>

                    <tr>
                        <td>Descontos</td>
                        <td class="valor">${formatarMoeda(oResultadoCalculo.resultado.total_descontos)}</td>
                    </tr>

                    <tr>
                        <td>Total a receber (líquido)</td>
                        <td class="valor">${formatarMoeda(oResultadoCalculo.resultado.valor_liquido)}</td>
                    </tr>

                </table>

                <button type="button" id="botao_detalhes_calculo" class="botao_detalhes_calculo" onclick="toggleDetalhesCalculo()">Exibir Detalhes do Cálculo</button>

                `;

    oDivResultadoResumo.innerHTML = sHtml;

    if (bResultadosVisiveis){
        exibirDetalhesCalculo();    
    }

}

function exibirDetalhesCalculo(){

    let oProventos = oResultadoCalculo.resultado.proventos;
    let oDescontos = oResultadoCalculo.resultado.descontos;
    let oFgts = oResultadoCalculo.resultado.fgts;

    let oDivResultadoDetalhe = document.getElementById("resultado_detalhe");

    let sHtml = `
            <table id="tabela_proventos" class="tabela_resultado">
            <caption class="titulo_tabela">Proventos</caption>
                <tr>
                    <th>Descrição</th>
                    <th class="valor">Valor</th>
                </tr>    

                <tr>
                    <td>Saldo Salário</td>
                    <td class="valor">${formatarMoeda(oProventos.saldo_salario)}</td>
                </tr>

                <tr>
                    <td>Aviso prévio</td>
                    <td class="valor">${formatarMoeda(oProventos.aviso_previo)}</td>
                </tr>


                <tr>
                    <td>Décimo terceiro</td>
                    <td class="valor">${formatarMoeda(oProventos.decimo_terceiro)}</td>
                </tr>

                <tr>
                    <td>Férias proporcionais</td>
                    <td class="valor">${formatarMoeda(oProventos.ferias_proporcionais)}</td>
                </tr>

                <tr>
                    <td>Férias vencidas</td>
                    <td class="valor">${formatarMoeda(oProventos.ferias_vencidas)}</td>
                </tr>

                <tr>
                    <td>Total proventos</td>
                    <td class="valor">${formatarMoeda(oResultadoCalculo.resultado.total_proventos)}</td>
                </tr>


            </table>

            <table id="tabela_descontos" class="tabela_resultado">
            <caption class="titulo_tabela">Descontos</caption>
                <tr>
                    <th>Descrição</th>
                    <th class="valor">Valor</th>
                </tr>    

                <tr>
                    <td>IRRF (Imposto de Renda Retido na Fonte)</td>
                    <td class="valor">${formatarMoeda(oDescontos.irrf)}</td>
                </tr>

                <tr>
                    <td>INSS (Instituto Nacional do Seguro Social)</td>
                    <td class="valor">${formatarMoeda(oDescontos.inss)}</td>
                </tr>

                <tr>
                    <td>Total descontos</td>
                    <td class="valor">${formatarMoeda(oResultadoCalculo.resultado.total_descontos)}</td>
                </tr>


            </table>

            <table id="tabela_fgts" class="tabela_resultado">
            <caption class="titulo_tabela">FGTS</caption>
                <tr>
                    <th>Descrição</th>
                    <th class="valor">Valor</th>
                </tr>    

                <tr>
                    <td>Saldo Total</td>
                    <td class="valor">${formatarMoeda(oFgts.saldo_total)}</td>
                </tr>

                <tr>
                    <td>Multa</td>
                    <td class="valor">${formatarMoeda(oFgts.multa)}</td>
                </tr>

            </table>

            `;

    oDivResultadoDetalhe.innerHTML = sHtml;

}
