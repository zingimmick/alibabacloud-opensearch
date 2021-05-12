<?php

use OpenSearch\Client\AppClient;
use OpenSearch\Client\OpenSearchClient;
use OpenSearch\Generated\Common\Pageable;

class OpenSearchClientTest extends PHPUnit_Framework_TestCase {
    public function setUp() {}

    protected function tearDown() {}

    public function testGet() {
        /*$mock = \Mockery::mock('Client\OpensearchClient[call]');
        $mock->shouldReceive('call')->andReturnUsing(function($url, $params, $method) {
            return array('url' => $url, 'params' => $params, 'method' => $method);
        });

        $ak = 'ak';
        $secret = 'secret';
        $host = 'http://domain';

        $client = new \Client\OpenSearchClient($ak, $secret, $host);
        $ret = $client->get('/apps', array('page' => 1, 'size' => 10));
        print_r($ret);*/
    }
}