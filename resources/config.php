<?php

return json_decode(json_encode([
    'title' => 'influx',
    'logFilePath' => __DIR__ . '/log.txt',
    'routes' => [
        [
            'method' => 'GET',
            'uri' => '/',
            'class' => '\Server\Net\Web\Http\Handler\IndexHandler'
        ]
    ],
]));
