<?php 

    $server = "localhost";
    $user = "postgres";
    $password = "1234";
    $port = "5432";

    $conexao = pg_connect("host=$server port=$port dbname=postgres user=$user password=$password");

    /* if (!$conexao) {
        die("Erro na conexão");
    }
    
    echo "Conexão efetuada"; */
?>