<?php

include_once ('config.php');

if (isset($_POST['submit'])) {
    include ('config.php');

    $codigo = $_POST['codigo'];
    $numeroPrestacoes = $_POST['numeroPrestacoes'];

    $consultaCodigo = "SELECT codigo FROM emprestimo  WHERE codigo = '$codigo' ";
    $resultConsultaCodigo = pg_query($conexao, $consultaCodigo);
    $resultadoCodigo = pg_fetch_assoc($resultConsultaCodigo);  //verifica se codigo existe no banco

    if ($resultadoCodigo) {

        $atualizaParcela = "UPDATE EMPRESTIMO SET nprestacoes = nprestacoes - $numeroPrestacoes WHERE codigo = '$codigo'";
        $queryAtualiza = pg_query($conexao, $atualizaParcela);

        $deletaEmprestimo = "DELETE FROM faz WHERE codigo = (SELECT e.codigo FROM emprestimo e WHERE nprestacoes = 0); DELETE FROM emprestimo WHERE nprestacoes = 0;";
        $queryDeleta = pg_query($conexao, $deletaEmprestimo);

        echo "<script>alert('Pagamento efetuado!');</script>";
    } else {
        echo "<script>alert('ERRO!! Código não encontrado!');</script>";
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
    <link href="./css/stylePagamento.css" rel="stylesheet">
    <title>Pagamento </title>

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
        <form action="pagamento.php" method="POST">
            <fieldset>
                <legend><b>Pagamento Prestações</b></legend>
                <div class="inputBox">
                    <input type="number" name="codigo" class="inputUser" required>
                    <label for="codigo" class="labelInput">Codigo do Emprestimo</label>
                </div>
                <div class="inputBox">
                    <input type="number" name="numeroPrestacoes" class="inputUser" required>
                    <label for="numeroPrestacoes" class="labelInput">Numero de prestações a serem pagas</label>
                </div>

                <button type="submit" name="submit" id="submit">Enviar</button>
            </fieldset>
        </form>
    </div>

</body>

</html>