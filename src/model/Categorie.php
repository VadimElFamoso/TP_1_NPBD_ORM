<?php

namespace iutnc\hellokant\model;

class Article extends Model {
    protected static string $table = 'categorie';
    private array $data;

    public function __construct(?array $data = null){
        $this->data = $data ?? [];
    }

    public function articles(): array {
        return $this->has_many(Article::class, 'id_categ');
    }
}