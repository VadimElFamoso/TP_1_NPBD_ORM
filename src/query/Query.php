<?php

namespace iutnc\hellokant\query;
use iutnc\hellokant\Connection\ConnectionFactory;
class Query {

    private $columns;
    private $table;
    private $where;
    private $bindings = [];

    public static function table($table) {
        $query = new Query();
        $query->table = $table;
        return $query;
    }

    public function where($column, $operator, $value) {
        $this->where = "$column $operator ?";
        $this->bindings[] = $value;
        return $this;
    }

    public function get() {
        $pdo = ConnectionFactory::getConnection();
        $sql = "SELECT $this->columns FROM $this->table WHERE $this->where";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($this->bindings);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function select($columns) {
        $this->columns = $columns;
        return $this;
    }

    public function delete() {

        $pdo = ConnectionFactory::getConnection();
        $sql = "DELETE FROM $this->table WHERE $this->where";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($this->bindings);
        return $stmt->rowCount();
    }

    public function insert($data) {
        $pdo = ConnectionFactory::getConnection();
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));
        $sql = "INSERT INTO $this->table ($columns) VALUES ($placeholders)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array_values($data));
        return $pdo->lastInsertId();
    }
}