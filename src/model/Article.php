<?php

namespace \iutnc\hellokant\Article;

class Article extends Model {
    protected $table = 'articles';
    protected $fillable = ['title', 'content', 'author_id'];
}