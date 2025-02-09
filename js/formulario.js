window.onload = function(){
    temporizadorMensagem();
}

function validarFormularioSugestao(){
    let oMensagemContato = document.getElementById("mensagem_contato");

    let oForm = document.getElementById("formulario_sugestao");

    let sTexto = "";

    if (oMensagemContato.value == ""){
        sTexto = "O campo de mensagem é obrigatório";
        definirAviso(sTexto,oMensagemContato,"aviso");
        return;
    }

    if (sTexto ===""){
        oForm.submit();
    }

}

function validarFormularioRescisao(){
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

        enviarDadosRescisao(oDados);
    }
    
    return;

}

function validarDatas(sDataContratacao,sDataDemissao){
    let dDataContratacao = new Date(sDataContratacao);
    let dDataDemissao = new Date(sDataDemissao);

    return dDataDemissao > dDataContratacao;
}

function obterIcone(sTipo){

    switch(sTipo){

        case "aviso":
            return "⚠";

        case "sucesso":
            return "✓";

        case "erro":
            return "✕";

        default:
            return "⚠";

    }
}

function definirAviso(sTexto,oFocus,sTipo){

    removerMensagem();

    let sIcone = obterIcone(sTipo);

    let sMensagem = `
        <div id='mensagem_sistema' class='mensagem_sistema'>
            <span class='icone-mensagem'>${sIcone}</span>
            <span class='texto-mensagem'>${sTexto}</span>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', sMensagem);
    temporizadorMensagem();

    if (oFocus){
        oFocus.focus();
    } 

}

function removerMensagem(){
    let oMensagem = document.getElementById("mensagem_sistema");

    if (oMensagem != null){
        oMensagem.remove();
    }
}

function temporizadorMensagem(){
    setTimeout(() => {
        removerMensagem();
    },"5000");
}
