<?php

// include the application
include __DIR__ . '/src/Application.php';

// register the autoloader class
\Server\Application::autoload();

// start the application
$app = new \Server\Application();
$app->start();
