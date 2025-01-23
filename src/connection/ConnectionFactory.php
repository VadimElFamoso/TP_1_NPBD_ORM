<?php

namespace iutnc\hellokant\connection;
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

        try {
            self::$connection = new PDO($db, $conf['user'], $conf['password'], $options);
        } catch (PDOException $e) {
            throw new PDOException("Erreur de connexion : " . $e->getMessage());
        }

        return self::$connection;
    }

    public static function getConnection() : PDO {
        if (self::$connection === null) {
            throw new PDOException("Erreur : connexion non établie");
        }

        return self::$connection;
    }
}