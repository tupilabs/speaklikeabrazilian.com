<?php

use Monolog\Logger;

return array(
    'hosts' => array(
                	'localhost:9200'
               ),
    'logPath' => 'app/storage/logs/elastisearch.log',
    'logLevel' => Logger::DEBUG
);