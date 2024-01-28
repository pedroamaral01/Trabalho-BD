<?php

if (isset($_POST['submit'])) {

    include('config.php');

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

        echo "CPF encontrado. Emprestimo realizado...";


        $emprestimo = pg_query($conexao, "INSERT INTO emprestimo(valor_i, juros, nprestacoes, valor_f, tipo, valor_prestacoes) VALUES('$valor', '$juros', '$prestacoes', '$valor_final', '$tipo', '$valor_prestacao')");


        $consultaCodigo = "SELECT codigo FROM emprestimo  ORDER BY codigo DESC LIMIT 1"; 
        $codigo_resultado = pg_query($conexao, $consultaCodigo);    // retornando o ultimo codigo da tabela emprestimo

            $linha = pg_fetch_assoc($codigo_resultado);

            if ($linha) {

                $codigo = $linha['codigo'];


                echo "O valor do código é: " . $codigo;
            } else {
                echo "Nenhum resultado encontrado.";
            }
        

        $faz = pg_query($conexao, "INSERT INTO faz (codigo, cpf_cliente) VALUES ('$codigo', '$cpf')");

        if ($segundoCpf !== null) {
            $faz1 = pg_query($conexao, "INSERT INTO faz (codigo, cpf_cliente) VALUES ('$codigo', '$segundoCpf')");
        }

    } else {
        echo "CPF nao esta cadastrado";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/styleEmp.css" rel="stylesheet">
    <title>Cadastro Emprestimo</title>
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

    <div class="formularios">
        <div class="box">
            <form action="emprestimo.php" method="POST">
                <fieldset>
                    <legend><b>Formulário de Cadastro de Emprestimo</b></legend>
                    <br>

                    <div class="inputBox">
                        <input type="text" name="cpf" id="cpf" class="inputUser" required>
                        <label for="cpf" class="labelInput">Cpf</label>
                    </div>
                    <br><br>
                    <div class="inputBox">
                        <input type="text" name="valor" id="valor" class="inputUser" required>
                        <label for="valor" class="labelInput">Valor de emprestimo</label>
                    </div>
                    <br><br>
                    <div class="inputBox">
                        <input type="text" name="prestacoes" id="prestacoes" class="inputUser" required>
                        <label for="prestacoes" class="labelInput">Numero de prestacoes</label>
                    </div>
                    <br><br>
                    <div class="inputBox">
                        <input type="text" name="juros" id="juros" class="inputUser" required>
                        <label for="juros" class="labelInput">Juros</label>
                    </div>

                    <br><br>
                    <div class="inputBox">
                        <p>Tipo Emprestimo:</p>
                        <input type="radio" id="Pessoal" name="tipo" value="PESSOAL" required>
                        <label for="Pessoal">Pessoal</label>
                        <br>
                        <input type="radio" id="Compartilhado" name="tipo" value="COMPARTILHADO" required>
                        <label for="Compartilhado">Compartilhado</label>
                    </div>

                    <div id="cpf-container">

                    </div>

                    <br>
                    <input type="submit" name="submit" id="submit">
                </fieldset>
            </form>

        </div>

        <script>
            document.getElementById('Compartilhado').addEventListener('change', function () {
                const container = document.getElementById('cpf-container');
                const divSegundoCpf = document.createElement("div");
                divSegundoCpf.classList.add("cpf");
                divSegundoCpf.innerHTML = `
                <div class="inputBox">
                    <input type="text" id="segundoCpf" name="segundoCpf" class="inputUser" required>
                    <label for="segundoCpf" class="labelInput">CPF</label>
                </div>
                <br><br>
            `;
                container.appendChild(divSegundoCpf);
            });
        </script>

</body>

</html>