<?php

use iutnc\hellokant\Connection\ConnectionFactory;
use iutnc\hellokant\Model\Article;

// Configuration for the database connection
$config = [
    'host' => 'localhost',
    'dbname' => 'your_database_name',
    'user' => 'your_username',
    'password' => 'your_password'
];

// Establish the database connection
ConnectionFactory::makeConnection($config);

// Create a new Article instance
$article = new \iutnc\hellokant\Model\Article();

// Set the attributes
$article->title = 'Sample Title';
$article->content = 'This is the content of the article.';
$article->author_id = 1;

// Access and display the attributes
echo 'Title: ' . $article->title . PHP_EOL;
echo 'Content: ' . $article->content . PHP_EOL;
echo 'Author ID: ' . $article->author_id . PHP_EOL;