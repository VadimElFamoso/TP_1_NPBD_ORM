<?php

namespace iutnc\hellokant\Connection;
use PDO;
use PDOException;

class ConnectionFactory {
    private static $connection;

    public static function makeConnection(array $conf) : PDO {
        $db = "mysql:host={$conf['host']};dbname={$conf['dbname']};charset=utf8";

        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_STRINGIFY_FETCHES => false,
        ];

        try{
            self::$connection = new PDO($db, $conf['user'], $conf['password'], $options);
        }
        catch (PDOException $e) {
            echo "Erreur de connexion : " . $e->getMessage();
        }

        return self::$connection;
    }

    //getConnection() : permet d'obtenir une connexion à condition qu'elle ait été créée
    //auparavant. Cette méthode retourne le contenu de la variable statique, et s'utilise chaque fois
    //que cela est nécessaire d'exécuter une requête sur la base de données – par exemple la la
    //classe Query

    public static function getConnection() : PDO {

        if (self::$connection === null) {
            echo "Erreur : connexion non établie";
            exit();
        }

        return self::$connection;
    }
}