<?php

use OpenSearch\Client\SuggestClient;
use OpenSearch\Client\OpenSearchClient;

use OpenSearch\Generated\Search\SearchParams;
use OpenSearch\Generated\Search\Config;
use OpenSearch\Generated\Search\Suggest;

class SuggestClientTest extends PHPUnit_Framework_TestCase {

    private static $client;

    public function setUp() {
        self::$client = \Mockery::mock(OpenSearchClient::class);
        self::$client->shouldReceive('get')->andReturnUsing(
            function($path, $params = array()) {
                return array("path" => $path, 'params' => $params);
            }
        );
    }

    protected function tearDown() {
        \Mockery::close();
    }

    public function testExecute() {
        $config = new Config();
        $appName = "abc";
        $config->appNames = array($appName);
        $config->hits = 10;

        $suggest = new Suggest();
        $suggestName = 'def';
        $suggest->suggestName = $suggestName;

        $searchParams = new SearchParams();
        $searchParams->query = 'test';
        $searchParams->config = $config;
        $searchParams->suggest = $suggest;

        $search = new SuggestClient(self::$client);
        $ret = $search->execute($searchParams);
        $this->assertEquals($ret['path'], "/apps/{$appName}/suggest/{$suggestName}/search");
        $this->assertEquals($ret['params']['query'], $searchParams->query);
        $this->assertEquals($ret['params']['hits'], 10);
    }
}