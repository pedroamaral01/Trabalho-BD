<?php
include_once('config.php');

$emprestimo = "SELECT c.nome, e.codigo ,e.tipo, e.valor_i, e.valor_f, e.nprestacoes, 
e.juros * 100 AS juros_percentual ,  valor_prestacoes
FROM cliente c
LEFT JOIN faz f ON c.cpf = f.cpf_cliente
LEFT JOIN emprestimo e ON f.codigo = e.codigo;";

$resultadoEmprestimo = pg_query($conexao, $emprestimo);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/styleGlobal.css" rel="stylesheet">
    <link href="./css/styleRegistros.css" rel="stylesheet">
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

    <div class="tabela-emprestimo">
        <h1>Lista Cadastros</h1>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Codigo</th>
                    <th>Tipo</th>
                    <th>Valor Inicial</th>
                    <th>Valor Final</th>
                    <th>Numero de Prestações</th>
                    <th>Juros</th>
                    <th>Valor Prestações</th>
                </tr>
            </thead>
            <tbody>

                <?php
                while ($user_data = pg_fetch_assoc($resultadoEmprestimo)) {
                    echo "<tr>";
                    echo "<td>" . $user_data['nome'] . "</td>";
                    echo "<td>" . $user_data['codigo'] . "</td>";
                    echo "<td>" . $user_data['tipo'] . "</td>";
                    echo "<td>" . $user_data['valor_i'] . "</td>";
                    echo "<td>" . $user_data['valor_f'] . "</td>";
                    echo "<td>" . $user_data['nprestacoes'] . "</td>";
                    echo "<td>" . $user_data['juros_percentual'] ."%" . "</td>";    
                    echo "<td>" . $user_data['valor_prestacoes'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>