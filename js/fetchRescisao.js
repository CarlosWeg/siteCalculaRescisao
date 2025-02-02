async function enviarDadosRescisao(oDados){
    try{
        definirAviso("Calculando...",null);

        const oResponse = await fetch('/',{
            method : 'POST',
            headers : {
                'Content-Type' : 'application/json',
            },
            body : JSON.stringify(oDados)

        });


        if (!oResponse.ok){
            throw new Error(`Erro HTTP: ${oResponse.status}`);
        }

        const oResultado = await oResponse.json();
        exibirResultados(oResultado);
        
    } catch (error){
        console.error("Falha na requisição: ",error);
        definirAviso("Erro ao calcular, tente novamente mais tarde.",null);
    }
}

function exibirResultados(resultado){
    const divResultado = document.getElementById('resultado');

    divResultado.innerHTML = `
        <h3>Resultado da Rescisão</h3>
    `;
}