<?php

use OpenSearch\Client\SearchClient;
use OpenSearch\Client\OpenSearchClient;
use OpenSearch\Util\SearchParamsBuilder;

use OpenSearch\Generated\Search\SearchParams;
use OpenSearch\Generated\Search\Config;

class SearchClientTest extends PHPUnit_Framework_TestCase {

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

        $searchParams = new SearchParams();
        $searchParams->query = 'test';
        $searchParams->config = $config;


        $search = new SearchClient(self::$client);
        $ret = $search->execute($searchParams);
        $this->assertEquals($ret['path'], "/apps/{$appName}/search");

        $clauses = explode("&&", $ret['params']['query']);
        foreach ($clauses as $clause) {

            if (substr($clause, 0, 7) == 'config=') {
                $this->assertTrue(strpos($clause, 'start:0') !== false);
                $this->assertTrue(strpos($clause, 'hit:15') !== false);
                $this->assertTrue(strpos($clause, 'format:xml') !== false);
                $this->assertTrue(strpos($clause, 'rerank_size:200') !== false);
            } else if (substr($clause, 0, 6) == 'clause') {
                $this->assertEquals($clause, 'query=test');
            }
        }
    }

    public function testSearchWithAbtest() {
        $appName = "abc";

        $searchParams = new SearchParamsBuilder();

        $searchParams->setAppName($appName);
        $searchParams->setQuery("test");
        $searchParams->setSceneTag("fx");
        $searchParams->setFlowDivider("1001");
        $searchParams->setUserId("10023");
        $searchParams->setRawQuery("hello");
        
        $search = new SearchClient(self::$client);
        $ret = $search->execute($searchParams->build());

        $this->assertEquals($ret['path'], "/apps/{$appName}/search");

        $abtest = explode(",", $ret['params']['abtest']);
    }
}