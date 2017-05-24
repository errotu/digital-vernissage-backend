<?php
use DigitalVernisage\Vernisage;
require_once __DIR__ . '/vendor/autoload.php';
require_once 'Vernisage.php';

$app = new Vernisage("content/blog.json");

$app->render();
?>