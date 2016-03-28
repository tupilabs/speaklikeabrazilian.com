<?php

use Monolog\Logger;

return array(
    'hosts' => array(
        'localhost:9200'
    ),
    'logPath' => storage_path() . '/logs/elasticsearch.log',
    'logLevel' => Logger::INFO
);
