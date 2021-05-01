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
            // echo "Conectado com sucesso.";
        } catch (PDOException $e) {
            echo "<h1>Ops, algo deu errado: " . $e->getMessage() . "</h1>";
            // echo "<pre>";
            // echo print_r($e);
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

    public function selectUsuarios()
    {
        $pdo = $this->returnConnection();
        $stmt = $pdo->query("SELECT * FROM usuario");
        $user = $stmt->fetchAll();
        return $user;
    }


    public function deleteUsuario($id)
    {
        try {
            $pdo = $this->returnConnection();
            $stmt = $pdo->prepare('DELETE FROM usuario WHERE id = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            echo "sucess";
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function selectUsuarioByID($id)
    {
        $pdo = $this->returnConnection();
        $stmt = $pdo->query("SELECT * FROM usuario WHERE id =" . $id);
        $user = $stmt->fetch();
        return $user;
    }

    public function updateUsuario($id, $nome, $idade)
    {
        try {
            $pdo = $this->returnConnection();
            $stmt = $pdo->prepare('UPDATE usuario SET nome = :nome, idade = :idade WHERE id = :id');
            $stmt->execute(array(
                ':id'   => $id,
                ':nome' => $nome,
                ':idade' => $idade
            ));
            return "sucess";
        } catch (PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}
