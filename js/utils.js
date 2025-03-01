document.addEventListener('DOMContentLoaded', function() {
    atualizarAnoDev();
});


function atualizarAnoDev() {
    const oAno = document.getElementById("ano_dev");
    
    if (oAno) {
        oAno.innerHTML = new Date().getFullYear();
    } 
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