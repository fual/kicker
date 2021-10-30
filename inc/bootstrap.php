<?php
if (!isset($subfolder))
    $subfolder = "/" .explode("/", $_SERVER["REQUEST_URI"])[1];
require_once $_SERVER["DOCUMENT_ROOT"] . $subfolder . '/database/connection.php';
require_once $_SERVER["DOCUMENT_ROOT"] . $subfolder . '/config.php';
require_once __DIR__ . '/functions.php';
date_default_timezone_set("Europe/Moscow");
