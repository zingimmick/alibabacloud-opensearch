<?php

set_include_path(
    dirname(__FILE__) . '/mockery'
    . PATH_SEPARATOR . get_include_path()
);

require_once 'Mockery/Loader.php';
require_once '../OpenSearch/Autoloader/Autoloader.php';

$loader = new \Mockery\Loader;
$loader->register();
