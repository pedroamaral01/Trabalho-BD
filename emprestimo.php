<?php

if (isset($_POST['submit'])) {

    include ('config.php');

    $cpf = $_POST['cpf'];
    $valor = $_POST['valor'];
    $juros = $_POST['juros'];
    $prestacoes = $_POST['prestacoes'];
    $tipo = $_POST['tipo'];
    $juros = $juros / 100;

    $valor_final = $valor * (1 + $juros * $prestacoes);

    $valor_final = round($valor_final, 2);

    $valor_prestacao = $valor_final / $prestacoes;
    $valor_prestacao = round($valor_prestacao, 2);

    $consulta = "SELECT c.cpf FROM cliente c WHERE c.cpf = '$cpf'"; // consulta se o cpf ja existe na tabela cliente
    $verificaCpf = pg_query($conexao, $consulta);
    $resultado = pg_fetch_assoc($verificaCpf);

    $segundoCpf = isset($_POST['segundoCpf']) ? $_POST['segundoCpf'] : null;

    if ($segundoCpf !== null) {
        $consultaSegundoCpf = "SELECT c.cpf FROM cliente c WHERE c.cpf = '$segundoCpf'";
        $verificaSegundoCpf = pg_query($conexao, $consultaSegundoCpf);

        $resultadoSegundoCpf = pg_fetch_assoc($verificaSegundoCpf);
    }

    if ($resultado && ($segundoCpf == null || $resultadoSegundoCpf)) {

        $emprestimo = pg_query($conexao, "INSERT INTO emprestimo(valor_i, juros, nprestacoes, valor_f, tipo, valor_prestacoes) VALUES('$valor', '$juros', '$prestacoes', '$valor_final', '$tipo', '$valor_prestacao')");

        $consultaCodigo = "SELECT codigo FROM emprestimo  ORDER BY codigo DESC LIMIT 1";
        $codigo_resultado = pg_query($conexao, $consultaCodigo);    // retornando o ultimo codigo da tabela emprestimo
        $linha = pg_fetch_assoc($codigo_resultado);

        if ($linha) {
            $codigo = $linha['codigo'];
        }
        $faz = pg_query($conexao, "INSERT INTO faz (codigo, cpf_cliente) VALUES ('$codigo', '$cpf')");

        if ($segundoCpf !== null) {
            $faz1 = pg_query($conexao, "INSERT INTO faz (codigo, cpf_cliente) VALUES ('$codigo', '$segundoCpf')");
        }
        echo "<script>alert('Emprestimo realizado com sucesso!');</script>";
        } else {
        echo "<script>alert('ERRO!! ao cadastrar emprestimo');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/styleGlobal.css" rel="stylesheet">
    <link href="./css/styleEmprestimo.css" rel="stylesheet">
    <title>Cadastro Emprestimo</title>
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

    <div class="formularios">
        <div class="box">
            <form action="emprestimo.php" method="POST">
                <fieldset>
                    <legend><b>Cadastro de Emprestimo</b></legend>

                    <div class="inputBox">
                        <input type="text" name="cpf" class="inputUser" required>
                        <label for="cpf" class="labelInput">CPF</label>
                    </div>

                    <div class="inputBox">
                        <input type="text" name="valor" class="inputUser" required>
                        <label for="valor" class="labelInput">Valor de emprestimo</label>
                    </div>

                    <div class="inputBox">
                        <input type="text" name="prestacoes" class="inputUser" required>
                        <label for="prestacoes" class="labelInput">Numero de prestacoes</label>
                    </div>

                    <div class="inputBox">
                        <input type="text" name="juros" class="inputUser" required>
                        <label for="juros" class="labelInput">Juros</label>
                    </div>

                    <div class="inputBox">
                        <p>Tipo Emprestimo:</p>
                        <input type="radio" id="pessoal" name="tipo" value="PESSOAL" required>
                        <label for="Pessoal">Pessoal</label>
                        <br>
                        <input type="radio" id="compartilhado" name="tipo" value="COMPARTILHADO" required>
                        <label for="Compartilhado">Compartilhado</label>
                    </div>

                    <div id="cpf-container">

                    </div>

                    <button type="submit" name="submit" id="submit">Enviar</button>
                </fieldset>
            </form>

        </div>
</body>
<script>

    const tipoCompartilhado = document.querySelector('#compartilhado')
    const tipoPessoal = document.querySelector('#pessoal')

    function adicionaSegundoCpf() {
        const divContainer = document.querySelector('#cpf-container')

        divContainer.innerHTML = `
                <div class="inputBox">
                    <input type="text" id="segundoCpf" name="segundoCpf" class="inputUser" required>
                    <label for="segundoCpf" class="labelInput">CPF</label>
                </div>
            `
    }

    function removeDiv() {
        const divContainer = document.querySelector('#cpf-container')

        divContainer.innerHTML = ``
    }

    tipoCompartilhado.addEventListener("change", adicionaSegundoCpf)
    tipoPessoal.addEventListener("change", removeDiv)

</script>

</html>