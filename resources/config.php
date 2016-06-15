<?php

return json_decode(json_encode([
    'title' => 'influx',
    'webroot' => __DIR__ . '/webroot',
    'logFilePath' => __DIR__ . '/log.txt',
    'routes' => [
        [
            'method' => 'GET',
            'uri' => '/',
            'class' => '\Server\Net\Web\Http\Handler\IndexHandler'
        ],
        [
            'method' => '*',
            'uri' => '.*?',
            'class' => '\Server\Net\Web\Http\Handler\StaticHandler'
        ]
    ],
]));
