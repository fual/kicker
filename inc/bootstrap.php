<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/database/connection.php';
require_once __DIR__ . '/functions.php';

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

$session = new \Symfony\Component\HttpFoundation\Session\Session();
$session->start();