
        // Função para aplicar a máscara no CPF
        function mascaraCPF(cpf) {
            cpf = cpf.replace(/\D/g, ""); // Remove qualquer coisa que não seja número
            if (cpf.length === 11) { // Aplica máscara apenas se tiver 11 números
                cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
            }
            return cpf;
        }

        // Função para aplicar a máscara no telefone
        function mascaraTelefone(telefone) {
            telefone = telefone.replace(/\D/g, ""); // Remove tudo que não é número
            if (telefone.length === 11) { // Aplica máscara apenas se tiver 11 números
                telefone = telefone.replace(/^(\d{2})(\d{5})(\d{4})$/, "($1) $2-$3");
            }
            return telefone;
        }

        // Adiciona máscara e validação nos campos
        const cpfInput = document.getElementById('cpf');
        const telefoneInput = document.getElementById('telefone');
        const formulario = document.getElementById('meuFormulario');

        cpfInput.addEventListener('input', function (event) {
            let cpf = event.target.value.replace(/\D/g, ""); // Remove não números

            // Permite digitar até 11 números e aplica máscara somente quando completos
            if (cpf.length <= 11) {
                event.target.value = mascaraCPF(cpf);
            } else {
                event.target.value = event.target.value.slice(0, 14); // Limita ao formato completo
            }
        });

        telefoneInput.addEventListener('input', function (event) {
            let telefone = event.target.value.replace(/\D/g, ""); // Remove não números

            // Permite digitar até 11 números e aplica máscara somente quando completos
            if (telefone.length <= 11) {
                event.target.value = mascaraTelefone(telefone);
            } else {
                event.target.value = event.target.value.slice(0, 15); // Limita ao formato completo
            }
        });

        // Validação no envio do formulário
        formulario.addEventListener('submit', function (event) {
            const cpf = cpfInput.value.replace(/\D/g, ""); // Remove máscara para validar
            if (cpf.length !== 11) { // Verifica se tem exatamente 11 dígitos
                alert("O CPF deve ter exatamente 11 números!");
                event.preventDefault(); // Impede o envio do formulário
                return;
            }

            const telefone = telefoneInput.value.replace(/\D/g, ""); // Remove máscara para validar
            if (telefone.length !== 11) { // Verifica se o telefone tem 11 dígitos
                alert("O telefone deve ter exatamente 11 números!");
                event.preventDefault(); // Impede o envio do formulário
                return;
            }

            alert("Formulário enviado com sucesso!");

                // Verifica se o cadastro foi realizado
    const cadastroRealizado = document.getElementById('cadastroRealizado').value === 'true';

    if (cadastroRealizado) {
        // Limpa o formulário
        document.querySelector('form').reset();
    }
        });

