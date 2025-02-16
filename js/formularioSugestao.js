async function validarFormularioSugestao(){
    let oMensagemContato = document.getElementById("mensagem_contato");
    let oEmailContato = document.getElementById("email_contato");
    let oNomeContato = document.getElementById("nome_contato");

    let oForm = document.getElementById("formulario_sugestao"); 

    let sTexto = "";

    if (oMensagemContato.value == ""){
        sTexto = "O campo de mensagem é obrigatório";
        definirAviso(sTexto,oMensagemContato,"aviso");
        return false;
    }

    if (sTexto == ""){
        const oDados = {
            mensagem_contato: oMensagemContato.value,
            email_contato: oEmailContato.value ? oEmailContato.value : '',
            nome_contato: oNomeContato.value ? oNomeContato.value : ''
        };

        const oSucesso = await enviarDadosSugestoes(oDados);

        if (oSucesso){
            definirAviso("Sugestão enviada com sucesso! Agradecemos o feedback.",null,"sucesso");
            oForm.reset();
        }
    }

}

async function enviarDadosSugestoes(oDados){
    try{
        
        const oResponse = await fetch('/siteCalculoRescisao/enviar-sugestao',{
            method : 'POST',
            headers : {
                'Content-Type' : 'application/json',
                'Accept': 'application/json'
            },
            body : JSON.stringify(oDados)
        });

        if (!oResponse.ok){
            const sErro = await oResponse.text();
            throw new Error(sErro);
        }

        return true;

    } catch (e){
        console.error("Falha na requisição: ", e.message);
        definirAviso(`Erro ao enviar a sugestão: ${e.message}`,null,"erro");
        return false;
    }
}