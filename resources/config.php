<?php

return json_decode(json_encode([
    'title' => 'influx',
    'viewDir' => __DIR__ . '/views',
    'webroot' => __DIR__ . '/webroot',
    'logFilePath' => __DIR__ . '/log.txt',
    'routes' => [
        [
            'method' => 'GET',
            'uri' => '/',
            'class' => '\Server\Net\Web\Http\Handler\IndexHandler',
            'view' => 'index.php'
        ],
        [
            'method' => '*',
            'uri' => '.*?',
            'class' => '\Server\Net\Web\Http\Handler\StaticHandler'
        ]
    ],
]));
