<?php

use Monolog\Logger;


return array(
    'hosts' => array(
        env('ES_SERVER')
    ),
    'logPath' => storage_path() . '/logs/elasticsearch.log',
    'logLevel' => Logger::INFO
);
