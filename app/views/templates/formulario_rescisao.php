<form id = "formulario_rescisao">

    <label for = "salario_bruto">Salário Bruto*</label>
    <input type = "number" name = "salario_bruto" id = "salario_bruto" min = "0" placeholder = "R$:0,00" value = "1500" required>

    <label for = "data_contratacao">Data de contratação*</label>
    <input type = "date" name = "data_contratacao" id = "data_contratacao" value = "2020-01-01" required>

    <label for = "data_demissao">Data de demissão*</label>
    <input type = "date" name = "data_demissao" id = "data_demissao" value = "2021-01-01" required>

    <label for = "motivo_rescisao">Motivo da rescisão*</label>
    <select id = "motivo_rescisao" name = "motivo_rescisao" required>
        <option value = "pedido_demissao">Pedido de demissão</option>
        <option value = "dispensa_sem_justa_causa">Dispensa sem justa causa</option>
        <option value = "dispensa_com_justa_causa">Dispensa com justa causa</option>
        <option value = "rescisao_acordo">Rescisao por acordo</option>
    </select>

    <label for = "tipo_aviso_previo">Tipo de aviso prévio*</label>
    <select id = "tipo_aviso_previo" name = "tipo_aviso_previo" required>
        <option value = "trabalhado">Trabalhado</option>
        <option value = "indenizado">Indenizado</option>
    </select>

    <label for = "saldo_fgts_antes">Saldo do FGTS antes da contratação</label>
    <input type = "number" name = "saldo_fgts_antes" id = "saldo_fgts_antes" min = "0" placeholder = "R$:0,00">

    <label for = "numero_dependentes">Número de dependentes</label>
    <input type = "number" name = "numero_dependentes" id = "numero_dependentes" step = "1" min = "0" placeholder = "0">

    <label for = "ferias_vencidas">Possui férias vencidas?</label>
    <input type = "checkbox" name = "ferias_vencidas" id = "ferias_vencidas" value = "true">

    <button type="button" onclick="validarFormulario()">Calcular</button>
    <button type="reset">Limpar</button>

</form>    