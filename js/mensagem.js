document.addEventListener('DOMContentLoaded', function() {
    iniciarTemporizador();
});

let mensagemTimeout = null;

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

    if (mensagemTimeout){
        clearTimeout(mensagemTimeout);
        mensagemTimeout = null;
    }

    removerMensagem();

    let sIcone = obterIcone(sTipo);

    let sMensagem = `
        <div id='mensagem_sistema' class='mensagem_sistema'>
            <span class='icone-mensagem'>${sIcone}</span>
            <span class='texto-mensagem'>${sTexto}</span>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', sMensagem);

    iniciarTemporizador();

    if (oFocus){
        oFocus.focus();
    } 

}

function iniciarTemporizador(iTempo = 5000){
    mensagemTimeout = setTimeout(()=>{
        const oMensagem = document.getElementById("mensagem_sistema");

        if (oMensagem){
            oMensagem.classList.add('animacao-fade-out');
            setTimeout(()=>removerMensagem(),300);
        }
    },iTempo);
}

function removerMensagem(){
    const oMensagem = document.getElementById("mensagem_sistema");

    if (oMensagem){
        oMensagem.remove();
    }

    if (mensagemTimeout){
        clearTimeout(mensagemTimeout);
        mensagemTimeout = null;
    }

}

