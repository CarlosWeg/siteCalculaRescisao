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
            definirAviso("Simulação realizada com sucesso! Confira o resultado.",null,"sucesso");
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

    let oDivResultadoResumo = document.getElementById("resultado_resumo");

    let sHtml = `
                <h2 class="">Resumo do resultado</h2>
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

                <button type="button" id="botao_detalhes_calculo" onclick="toggleDetalhesCalculo()">Exibir Detalhes do Cálculo</button>

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
            <h2>Detalhes do cálculo</h2>

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
                    <td>${formatarMoeda(oProventos.aviso_previo)}</td>
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