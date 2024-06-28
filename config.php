<?php 

    $server = "localhost";
    $user = "postgres";
    $password = "aluno";
    $port = "5432";

    $conexao = pg_connect("host=$server port=$port dbname=postgres user=$user password=$password");

?>