<?php

class Connection {

    private static $conn = null;

    public static function getConnection() {

        if(self::$conn == null) {
            //Criar a conexão
            $opcoes = array(
                //Define o charset da conexão
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                //Define o tipo do erro como exceção
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                //Define o retorno das consultas como
                //array associativo (campo => valor)
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            );

            //ATENÇÃO: alterar os dados da conexão de acordo com o ambiente onde a 
            //aplicação será executada
            self::$conn = new PDO("mysql:host=localhost;dbname=produto", "root", "nova_senha", $opcoes);

        }

        return self::$conn;
    }
}

//Teste de conexão
//$conn = Connection::getConnection();
//print_r($conn);