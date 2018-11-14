<?php

use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

try {
    $dotenv = new Dotenv(__DIR__ . '/../');
    $dotenv->load();
} catch(InvalidArgumentException $e) {
    // Errors here
}
