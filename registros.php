<?php
include_once('config.php');

$cliente = "SELECT * FROM cliente";
$emprestimo = "SELECT * FROM emprestimo";

$resultadoCliente = pg_query($conexao, $cliente);
$resultadoEmprestimo = pg_query($conexao, $emprestimo);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/styleReg.css" rel="stylesheet">
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

    <div class="tabela-cliente">
        <h1>Tabela Cliente</h1>
        <table>
            <thead>
                <tr>
                    <th>CPF</th>
                    <th>Nome</th>
                    <th>Cidade</th>
                    <th>Estado</th>
                    <th>Endereço</th>
                    <th>Telefone</th>
                </tr>
            </thead>
            <tbody>

                <?php
                while ($user_data = pg_fetch_assoc($resultadoCliente)) {
                    echo "<tr>";
                    echo "<td>" . $user_data['cpf'] . "</td>";
                    echo "<td>" . $user_data['nome'] . "</td>";
                    echo "<td>" . $user_data['cidade'] . "</td>";
                    echo "<td>" . $user_data['estado'] . "</td>";
                    echo "<td>" . $user_data['endereco'] . "</td>";
                    echo "<td>" . $user_data['telefone'] . "</td>";
                    echo "</tr>";
                    
                }
                ?>



            </tbody>
        </table>
    </div>

    <div class="tabela-emprestimo">
        <h1>Tabela Emprestimo</h1>
        <table>
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Juros</th>
                    <th>Valor Inicial</th>
                    <th>Valor Final</th>
                    <th>Numero de Prestações</th>
                    <th>Tipo</th>
                    <th>Valor Prestações</th>
                </tr>
            </thead>
            <tbody>

                <?php
                while ($user_data = pg_fetch_assoc($resultadoEmprestimo)) {
                    echo "<tr>";
                    echo "<td>" . $user_data['codigo'] . "</td>";
                    echo "<td>" . $user_data['juros'] . "</td>";
                    echo "<td>" . $user_data['valor_i'] . "</td>";
                    echo "<td>" . $user_data['valor_f'] . "</td>";
                    echo "<td>" . $user_data['nprestacoes'] . "</td>";
                    echo "<td>" . $user_data['tipo'] . "</td>";
                    echo "<td>" . $user_data['valor_prestacoes'] . "</td>";
                    echo "</tr>";
                }
                ?>



            </tbody>
        </table>
    </div>



</body>

</html>