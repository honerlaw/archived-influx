<?php

return json_decode(json_encode([
    'title' => 'influx',
    'logFilePath' => __DIR__ . '/log.txt',
    'services' => [
        'logger' => '\Server\Service\Logger',
        'router' => '\Server\Service\Router'
    ],
    'routes' => [
    ],
]));
