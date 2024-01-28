<?php
 
 include_once('config.php');

 if (isset($_POST['submit'])) {
    include('config.php');

    $codigo = $_POST['codigo'];
   
    $consultaCodigo = "SELECT codigo FROM emprestimo  WHERE codigo = '$codigo' ";
    $resultConsultaCodigo = pg_query($conexao, $consultaCodigo);
    $resultadoCodigo = pg_fetch_assoc($resultConsultaCodigo);  //verifica se codigo existe no banco

   if($resultadoCodigo) {
    echo"Codigo existe";

    $atualizaParcela ="UPDATE EMPRESTIMO SET nprestacoes = nprestacoes -1 WHERE codigo = '$codigo'";
    $queryAtualiza = pg_query($conexao,$atualizaParcela);

    $deletaEmprestimo = "DELETE FROM faz WHERE codigo = (SELECT e.codigo FROM emprestimo e WHERE nprestacoes = 0); DELETE FROM emprestimo WHERE nprestacoes = 0;";
    $queryDeleta = pg_query($conexao,$deletaEmprestimo);
   }

   else {
    echo "nao existe";
   }
}

?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/stylePag.css" rel="stylesheet">
    <title>Pagamento </title>

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
        <form action="pagamento.php" method="POST">
            <fieldset>
                <legend><b>Formulário Cadastro Cliente</b></legend>
                <br>
                <div class="inputBox">
                    <input type="text" name="codigo" id="codigo" class="inputUser" required>
                    <label for="codigo" class="labelInput">Codigo do Emprestimo</label>
                </div>
                <br><br>
               
                </fieldset>

                <input type="submit" name="submit" id="submit">
            </fieldset>
        </form>

</body>

</html>