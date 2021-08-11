<?php
Dotenv\Dotenv::createImmutable(dirname(__DIR__))->load();

define('APP_NAME', $_ENV['APP_NAME']);

define('APP_ROOT', dirname(dirname(__FILE__)));

define('APP_URL', $_ENV['APP_URL']);

define('DEFULT_LANGUAGE', $_ENV['DEFULT_LANGUAGE']);