<?php

class DBConnection
{

    private $_dbHostname = "localhost";
    private $_dbName = "hellovue";
    private $_dbUsername = "root";
    private $_dbPassword = "";
    private $_con;

    public function __construct()
    {
        try {
            $this->_con = new PDO("mysql:host=$this->_dbHostname;dbname=$this->_dbName", $this->_dbUsername, $this->_dbPassword);
            $this->_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Conectado com sucesso.";
        } catch (PDOException $e) {
            echo "<h1>Ops, algo deu errado: " . $e->getMessage() . "</h1>";
            echo "<pre>";
            echo print_r($e);
        }
    }
    // return Connection
    public function returnConnection()
    {
        return $this->_con;
    }


    public function cadastrarUsuario($nome, $idade)
    {
        $pdo = $this->returnConnection();
        $stmt = $pdo->prepare('INSERT INTO usuario  VALUES(null,:nome,:idade)');
        $stmt->execute(array(
            ':nome' => $nome,
            ':idade' => $idade
        ));
        if ($stmt->rowCount() > 0) {
            return "sucess";
        } else {
            return 'error';
        }
    }
}
