<?php
error_reporting(E_ERROR | E_PARSE);
if (isset($_POST['submit'])) {
    include ('config.php');

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
        echo "<script>alert('Cliente cadastrado com sucesso!');</script>";
    } else {
        echo "<script>alert('ERRO ao cadastrar cliente!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/styleGlobal.css" rel="stylesheet">
    <link href="./css/styleCliente.css" rel="stylesheet">
    <title>Cadastro Cliente</title>

</head>

<body>

    <div class="barra-lateral">
        <h1> I-giota concessões</h1>
        <img src="./img/logo.png" alt="logo" class="circular-image">

        <a href="cliente.php" class="links-barra">Cadastrar Cliente</a>
        <a href="emprestimo.php" class="links-barra">Cadastrar Empréstimo</a>
        <a href="registros.php" class="links-barra">Lista de registros</a>
        <a href="pagamento.php" class="links-barra">Pagamento</a>
    </div>

    <div class="box">
        <form action="cliente.php" method="POST">
            <fieldset>
                <legend><b>Cadastro Cliente</b></legend>

                <div class="inputBox">
                    <input type="text" name="nome" class="inputUser" required>
                    <label for="nome" class="labelInput">Nome completo</label>
                </div>

                <div class="inputBox">
                    <input type="text" name="cpf" class="inputUser" required>
                    <label for="cpf" class="labelInput">CPF</label>
                </div>

                <div class="inputBox">
                    <input type="tel" name="telefone" class="inputUser" required>
                    <label for="telefone" class="labelInput">Telefone</label>
                </div>

                <div class="inputBox">
                    <label for="estado">Estado </label>
                    <select id="estado" name="estado">
                        <option value="SP">SP</option>
                        <option value="RJ">RJ</option>
                        <option value="MG">MG</option>
                    </select>
                </div>

                <div class="inputBox">
                    <input type="text" name="cidade" class="inputUser" required>
                    <label for="cidade" class="labelInput">Cidade</label>
                </div>

                <div class="inputBox">
                    <input type="text" name="endereco" id="endereco" class="inputUser" required>
                    <label for="endereco" class="labelInput">Endereço</label>
                </div>

                <button type="button" id="adicionar-dependente">Adicionar Dependente</button>

                <div id="dependentes-container">
                </div>

                <button type="submit" name="submit" id="submit">Enviar</button>
            </fieldset>
        </form>
    </div>

</body>

<script>
    const buttonAdicionar = document.querySelector('#adicionar-dependente')

    function adicionaFormulario() {
        const divContainer = document.querySelector('#dependentes-container')

        divContainer.innerHTML += `
            <fieldset>
                    <legend><b>Dependente</b></legend>
                <div class="inputBox">
                    <input type="text" name="dependente_nome[]" class="inputUser" required>
                    <label for="dependente_nome" class="labelInput">Nome do Dependente</label>
                </div>
                <div class="inputBox">
                    <input type="text" name="dependente_parentesco[]" class="inputUser" required>
                    <label for="dependente_parentesco" class="labelInput">Parentesco</label>
                </div>     
                <div class="inputBox">
                    <input type="text" name="dependente_endereco[]" class="inputUser" required>
                    <label for="dependente_endereco" class="labelInput">Endereço do Dependente</label>
                </div>      
                 </fieldset> `

    }
    buttonAdicionar.addEventListener("click", adicionaFormulario)
</script>

</html>