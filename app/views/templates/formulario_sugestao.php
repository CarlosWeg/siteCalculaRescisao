<form id="formulario_sugestao">

    <label for = "nome_contato">Informe o nome (opcional)</label>
    <input type = "text" id = "nome_contato" name = "nome_contato" placeholder = "Nome para contato" title = "Informe o seu nome">

    <label for = "email_contato">Informe o e-mail (opcional)</label>
    <input type = "mail" id = "email_contato" name = "email_contato" placeholder = "email@exemplo.com" title = "Informe seu e-mail">

    <label for = "mensagem_contato">Deixe sua mensagem*:</label>
    <textarea id = "mensagem_contato" name = "mensagem_contato" placeholder = "Escreva sua mensagem aqui..." required title = "Digite sua mensagem"></textarea>

    <button type="button" onclick="validarFormularioSugestao()">Enviar</button>
    <button type="reset">Limpar</button>
</form>