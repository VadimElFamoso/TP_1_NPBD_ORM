<?php

namespace iutnc\hellokant\model;
use iutnc\hellokant\query\Query;

use Exception;

class Model{

    protected static string $table = 'categorie';
    private array $data;

    public function __construct(?array $data = null){
        $this->data = $data ?? [];
    }
    public function articles(): array {
        return $this->has_many(Article::class, 'id_categ');
    }

    public function __get($name){
        return $this->data[$name] ?? null;
    }

    public function __set($name, $value){
        $this->data[$name] = $value;
    }

    //OK
    public function save(): void
    {
        $query = Query::table(static::$table);
        if (isset($this->data['id'])) {
            $query->where('id', '=', $this->data['id'])->update($this->data);
        } else {
            $this->data['id'] = $query->insert($this->data);
        }
    }

    //OK
    public function delete(): void
    {
        $query = Query::table(static::$table);
        if (isset($this->data['id'])) {
            $query->where('id', '=', $this->data['id'])->delete();
        }
        else{
            throw new Exception('No id to delete');
        }

    }

    //OK
    public function insert(): void
    {

        $query = Query::table(static::$table);
        $this->data['id'] = $query->insert($this->data);
    }

    //OK
    public static function all(): array
    {
        $query = Query::table(static::$table);
        $rows = $query->get();
        $models = [];

        foreach ($rows as $row) {
            $models[] = new static($row);
        }

        return $models;
    }

    //OK
    public static function find(array $criteria, array $columns = ['*']): array
    {
        $query = Query::table(static::$table)->select($columns);

        foreach ($criteria as $criterion) {
            [$column, $operator, $value] = $criterion;
            $query->where($column, $operator, $value);
        }

        $rows = $query->get();
        $models = [];

        foreach ($rows as $row) {
            $models[] = new static($row);
        }

        return $models;
    }

    //OK
    public function belongs_to(string $relatedModel, string $foreignKey): ?Model
    {
        $relatedTable = $relatedModel::$table;
        $relatedId = $this->data[$foreignKey] ?? null;

        if ($relatedId === null) {
            return null;
        }

        $query = Query::table($relatedTable);
        $row = $query->where('id', '=', $relatedId)->first();

        if ($row) {
            return new $relatedModel($row);
        }

        return null;
    }

    //OK
    public function has_many(string $relatedModel, string $foreignKey): array
    {
        $relatedTable = $relatedModel::$table;
        $primaryKey = $this->data['id'] ?? null;

        if ($primaryKey === null) {
            return [];
        }

        $query = Query::table($relatedTable);
        $rows = $query->where($foreignKey, '=', $primaryKey)->get();
        $models = [];

        foreach ($rows as $row) {
            $models[] = new $relatedModel($row);
        }

        return $models;
    }
}