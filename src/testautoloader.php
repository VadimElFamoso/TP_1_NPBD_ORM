<?php
require __DIR__ . '/vendor/autoload.php';

use iutnc\hellokant\connection\ConnectionFactory;

if (class_exists('iutnc\hellokant\connection\ConnectionFactory')) {
    echo "Class ConnectionFactory loaded successfully!";
} else {
    echo "Failed to load class ConnectionFactory.";
}
