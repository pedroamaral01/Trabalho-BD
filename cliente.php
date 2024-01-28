<?php
if (isset($_POST['submit'])) {
    include('config.php');

    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $endereco = $_POST['endereco'];

    $result_cliente = pg_query($conexao, "INSERT INTO cliente(nome,cpf,telefone,cidade,estado,endereco) VALUES('$nome','$cpf','$telefone','$cidade','$estado','$endereco')");

    if ($result_cliente) {

        if (isset($_POST['dependente_nome'])) {
            $dependente_nome = $_POST['dependente_nome'];
            $dependente_parentesco = $_POST['dependente_parentesco'];
            $dependente_endereco = $_POST['dependente_endereco'];

            foreach ($dependente_nome as $key => $nome_dependente) {
                $result_dependente = pg_query($conexao, "INSERT INTO dependente(cpf_cliente, nome, parentesco, endereco) VALUES('$cpf', '$nome_dependente', '$dependente_parentesco[$key]', '$dependente_endereco[$key]')");
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/style.css" rel="stylesheet">
    <title>Cadastro Cliente</title>

</head>

<body>

    <div class="barra-lateral">
        <h1 class="titulo"> I-giota concessões
        </h1>

        <div class="img-logo">
            <img src="./img/logo.png" alt="logo" class="circular-image">
        </div>

        <ul class="opcoes-cadastro">
            <li><a href="cliente.php" class="cadastrar-cliente">Cadastrar Cliente</a></li>
            <li><a href="emprestimo.php" class="cadastrar-cliente">Cadastrar Empréstimo</a></li>
            <li><a href="registros.php" class="registros">Lista de registros</a></li>
            <li><a href="pagamento.php" class="pagamento">Pagamento</a></li>
        </ul>

    </div>

    <div class="box">
        <form action="cliente.php" method="POST">
            <fieldset>
                <legend><b>Formulário Cadastro Cliente</b></legend>
                <br>
                <div class="inputBox">
                    <input type="text" name="nome" id="nome" class="inputUser" required>
                    <label for="nome" class="labelInput">Nome completo</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="cpf" id="cpf" class="inputUser" required>
                    <label for="cpf" class="labelInput">Cpf</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="tel" name="telefone" id="telefone" class="inputUser" required>
                    <label for="telefone" class="labelInput">Telefone</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="cidade" id="cidade" class="inputUser" required>
                    <label for="cidade" class="labelInput">Cidade</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <label for="estado">Estado</label>
                    <select id="estado" name="estado" class="inputUser">
                        <option value="SP">SP</option>
                        <option value="RJ">RJ</option>
                        <option value="MG">MG</option>
                    </select>

                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="endereco" id="endereco" class="inputUser" required>
                    <label for="endereco" class="labelInput">Endereço</label>
                </div>

                <br><br>
                <fieldset>
                    <legend><b>Dependentes</b></legend>
                    <div id="dependentes-container">
                      
                    </div>
                    <button type="button" id="adicionar-dependente">Adicionar Dependente</button>
                </fieldset>

                <input type="submit" name="submit" id="submit">
            </fieldset>
        </form>

</body>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const container = document.getElementById("dependentes-container");
        const btnAdicionarDependente = document.getElementById("adicionar-dependente");

        btnAdicionarDependente.addEventListener("click", function () {
            const divDependente = document.createElement("div");
            divDependente.classList.add("dependente");

            divDependente.innerHTML = `
                <div class="inputBox">
                    <input type="text" name="dependente_nome[]" class="inputUser" required>
                    <label for="dependente_nome" class="labelInput">Nome do Dependente</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="dependente_parentesco[]" class="inputUser" required>
                    <label for="dependente_parentesco" class="labelInput">Parentesco</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="dependente_endereco[]" class="inputUser" required>
                    <label for="dependente_endereco" class="labelInput">Endereço do Dependente</label>
                </div>
                <br><br>
            `;

            container.appendChild(divDependente);
        });
    });
</script>

</html>