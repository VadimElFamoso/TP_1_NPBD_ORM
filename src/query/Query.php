<?php

namespace iutnc\hellokant\query;
use iutnc\hellokant\Connection\ConnectionFactory;
use \PDO;

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

        $columns = $this->columns ?: '*';
        if (is_array($columns)) {
            $columns = implode(', ', $columns);
        }

        if (empty($this->table)) {
            throw new \Exception("Table name is not defined");
        }

        $whereClause = !empty($this->where) ? "WHERE $this->where" : "";
        $sql = "SELECT $columns FROM $this->table $whereClause";

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

        if (!array_key_exists('id_categ', $data)) {
            $data['id_categ'] = 1;
        }

        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));
        $sql = "INSERT INTO $this->table ($columns) VALUES ($placeholders)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array_values($data));

        return $pdo->lastInsertId();
    }



}