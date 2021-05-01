<?php
include_once './DBConnection.php';

if (isset($_POST['nome']) && isset($_POST['idade'])) {
    echo $nome = $_POST['nome'];
    echo $idade = $_POST['idade'];
}

//$db = new DBConnection();

//return json_encode($db->cadastrarUsuario($nome, $idade));
