<?php
use DigitalVernissage\Vernissage;
require_once __DIR__ . '/vendor/autoload.php';
require_once 'Vernissage.php';

$app = new Vernissage("content");

$app->render();
?>