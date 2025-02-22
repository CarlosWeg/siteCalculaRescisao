<form id="formulario_rescisao" class="bg-white max-w-2xl mx-auto p-6 rounded-lg shadow-md space-y-8">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="flex flex-col justify-start items-center space-y-2">
            <label for="salario_bruto" class="label">Salário Bruto*</label>
            <input type="number" name="salario_bruto" id="salario_bruto" min="0" placeholder="R$:0,00" value="1500" required title="Informe o salário bruto" class="input">
        </div>

        <div class="flex flex-col justify-start items-center space-y-2">
            <label for = "saldo_fgts_antes" class="label">Saldo do FGTS antes da contratação</label>
            <input type = "number" name = "saldo_fgts_antes" id = "saldo_fgts_antes" min = "0" placeholder = "R$:0,00" title = "Informe o saldo de FGTS anterior a contratação" class="input">
        </div>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="flex flex-col justify-start items-center space-y-2">
            <label for="data_contratacao" class="label">Data de contratação*</label>
            <input type="date" name="data_contratacao" id="data_contratacao" value="2020-01-01" required title="Informe a data de contratação" class="input">
        </div>

        <div class="flex flex-col justify-start items-center space-y-2">
            <label for="data_demissao" class="label">Data de demissão*</label>
            <input type="date" name="data_demissao" id="data_demissao" value="2021-01-01" required title="Informe a data de demissão" class="input">
        </div>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="flex flex-col justify-start items-center space-y-2">
            <label for="motivo_rescisao" class="label">Motivo da rescisão*</label>
            <select id="motivo_rescisao" name="motivo_rescisao" required title="Selecione o motivo da rescisão" class="input">
                <option value="pedido_demissao">Pedido de demissão</option>
                <option value="dispensa_sem_justa_causa">Dispensa sem justa causa</option>
                <option value="dispensa_com_justa_causa">Dispensa com justa causa</option>
                <option value="rescisao_acordo">Rescisao por acordo</option>
            </select>
        </div>

        <div class="flex flex-col justify-start items-center space-y-2">
            <label for="tipo_aviso_previo" class="label">Tipo de aviso prévio*</label>
            <select id="tipo_aviso_previo" name="tipo_aviso_previ o" required title="Selecione o tipo de aviso prévio" class="input">
                <option value="trabalhado">Trabalhado</option>
                <option value="indenizado">Indenizado</option>
            </select>
        </div>

    </div>


    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="flex flex-col justify-start items-center space-y-2">
            <label for="numero_dependentes" class="label">Número de dependentes</label>
            <input type="number" name="numero_dependentes" id="numero_dependentes" step="1" min="0" placeholder="0" title="Informe o número de dependentes" class="input">
        </div>

        <div class="flex flex-col justify-start items-center space-y-2">
            <label for="ferias_vencidas" class="label">Possui férias vencidas?</label>
            <input type="checkbox" name="ferias_vencidas" id="ferias_vencidas" value="true" title="Marque se possui férias vencidas" class="">
        </div>


    </div>

    <div class="grid grid-cols-1">

        <div class="flex flex-col justify-start space-y-6 items-center">
            <button type="button" onclick="validarFormularioRescisao()" class="botao_formulario_enviar" >Calcular</button>
            <button type="reset" class="botao_formulario_reset">Limpar</button>
        </div>

    </div>
        
</form>    