<?php

namespace iutnc\hellokant\model;


class Article extends model {
    protected static string $table = 'article';
    private array $data;

    public function __construct(?array $data = null){
        $this->data = $data ?? [];
    }
    public function categorie(): Model
    {
        return $this->belongs_to(Categorie::class, 'id_categ');
    }
}