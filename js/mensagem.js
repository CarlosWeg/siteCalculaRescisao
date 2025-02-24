document.addEventListener('DOMContentLoaded', function() {
    temporizadorMensagem();
    atualizarAnoDev();
});

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

function scrollSection(elementoId){
    const oElemento = document.getElementById(elementoId);

    if (oElemento){
        oElemento.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
}

function atualizarAnoDev() {
    const oAno = document.getElementById("ano_dev");

    if (oAno) {
        oAno.innerHTML = new Date().getFullYear();
    } else {
        console.error("Elemento com ID 'ano_dev' não encontrado.");
    }
}