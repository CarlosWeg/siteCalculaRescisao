<form id="formulario_sugestao" class="bg-white max-w-2xl mx-auto p-6 rounded-lg shadow-md space-y-8 flex flex-col">

    <label for="nome_contato" class="label">Informe o nome (opcional)</label>
    <input type="text" id="nome_contato" name="nome_contato" placeholder="Nome para contato" title="Informe o seu nome" class="input">

    <label for="email_contato" class="label">Informe o e-mail (opcional)</label>
    <input type="mail" id="email_contato" name="email_contato" placeholder="email@exemplo.com" title="Informe seu e-mail" class="input">

    <label for="mensagem_contato" class="label">Deixe sua mensagem*:</label>
    <textarea id="mensagem_contato" name="mensagem_contato" placeholder="Escreva sua mensagem aqui..." required title="Digite sua mensagem" class="textarea"></textarea>

    <button type="button" onclick="validarFormularioSugestao()" class="botao_formulario_enviar w-full">Enviar</button>
    <button type="reset" class="botao_formulario_reset w-full">Limpar</button>
</form>