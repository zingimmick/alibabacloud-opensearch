<?php

use OpenSearch\Util\SearchParamsBuilder;
use OpenSearch\Client\SearchClient;
use OpenSearch\Client\OpenSearchClient;
use OpenSearch\Generated\Search\RankType;

class SearchParamsBuilderTest extends PHPUnit_Framework_TestCase {
    private static $client;

    public function setUp() {
        self::$client = \Mockery::mock(OpenSearchClient::class);
        self::$client->shouldReceive('post')->andReturnUsing(
            function($path, $body = '') {
                $array = json_decode($body, true);
                return json_encode(array('path' => $path, 'body' => $array));
            }
        );

        self::$client->shouldReceive('get')->andReturnUsing(
            function($path, $params = array()) {
                return json_encode(array("path" => $path, 'params' => $params));
            }
        );

        self::$client->shouldReceive('delete')->andReturnUsing(
            function($path) {
                return json_encode(array("path" => $path));
            }
        );

        self::$client->shouldReceive('patch')->andReturnUsing(
            function($path, $body = '') {
                $array = json_decode($body, true);
                return json_encode(array('path' => $path, 'body' => $array));
            }
        );

        self::$client->shouldReceive('put')->andReturnUsing(
            function($path, $body = '') {
                $array = json_decode($body, true);
                return json_encode(array('path' => $path, 'body' => $array));
            }
        );
    }

    protected function tearDown() {
        \Mockery::close();
    }

    public function testSetStart() {
        // Tests for start = 1
        $array = array('key' => 'start', 'value' => 1);
        $clauses = $this->getClauses($array['key'], $array['value'], 'setStart');
        $this->assertEquals($array['value'], $clauses['config']['start']);

        // Tests for start = -1
        $array = array('key' => 'start', 'value' => -1);
        $clauses = $this->getClauses($array['key'], $array['value'], 'setStart');
        $this->assertEquals($array['value'], $clauses['config']['start']);

        // Test for no start
        $array = array('key' => 'start', 'value' => null);
        $clauses = $this->getClauses($array['key'], $array['value'], 'setStart');
        $this->assertEquals(0, $clauses['config']['start']);

        // Test for options
        $array = array('key' => 'start', 'value' => 1);
        $clauses = $this->getClauses($array['key'], $array['value'], '', true);
        $this->assertEquals($array['value'], $clauses['config']['start']);
    }

    public function testSeHit() {
        // Tests for hit = 1
        $array = array('key' => 'hits', 'value' => 1);
        $clauses = $this->getClauses($array['key'], $array['value'], 'setHits');
        $this->assertEquals($array['value'], $clauses['config']['hit']);

        // Tests for hit = 100
        $array = array('key' => 'hits', 'value' => 100);
        $clauses = $this->getClauses($array['key'], $array['value'], 'setHits');
        $this->assertEquals($array['value'], $clauses['config']['hit']);

        // Test for not hit
        $array = array('key' => 'hits', 'value' => null);
        $clauses = $this->getClauses($array['key'], $array['value'], 'setHits', false, true);
        $this->assertEquals(15, $clauses['config']['hit']);

        // Test for options
        $array = array('key' => 'hits', 'value' => 100);
        $clauses = $this->getClauses($array['key'], $array['value'], '', true);
        $this->assertEquals($array['value'], $clauses['config']['hit']);
    }

    public function testSetFormat() {

        // Tests for json
        $array = array('key' => 'format', 'value' => 'json');
        $clauses = $this->getClauses($array['key'], $array['value'], 'setFormat');
        $this->assertEquals($array['value'], $clauses['config']['format']);

        // Test for fulljson
        $array = array('key' => 'format', 'value' => 'fulljson');
        $clauses = $this->getClauses($array['key'], $array['value'], 'setFormat');
        $this->assertEquals($array['value'], $clauses['config']['format']);

        // Test for xml
        $array = array('key' => 'format', 'value' => 'xml');
        $clauses = $this->getClauses($array['key'], $array['value'], 'setFormat');
        $this->assertEquals($array['value'], $clauses['config']['format']);

        // Test for not format
        $array = array('key' => 'format', 'value' => 'json');
        $clauses = $this->getClauses($array['key'], $array['value'], '', false, true);
        $this->assertEquals('xml', $clauses['config']['format']);

        // Tests form options
        $array = array('key' => 'format', 'value' => 'json');
        $clauses = $this->getClauses($array['key'], $array['value'], '', true);
        $this->assertEquals($array['value'], $clauses['config']['format']);
    }

    public function testSetKVPairs() {

        // Tests for json
        $array = array('key' => 'kvpairs', 'value' => 'abc');
        $clauses = $this->getClauses($array['key'], $array['value'], 'setKVPairs');
        $this->assertEquals($array['value'], $clauses['config'][$array['key']]);
        // Tests form options
        $array = array('key' => 'kvpairs', 'value' => 'abc');
        $clauses = $this->getClauses($array['key'], $array['value'], '', true);
        $this->assertEquals($array['value'], $clauses['config'][$array['key']]);
    }

    public function testSetCustomConfig() {
        $array = array('key' => 'customConfig', 'value' => array("a" => 1234));
        $searchParamsBuilder = new SearchParamsBuilder();
        $searchParamsBuilder->setCustomConfig('a', 1234);
        $searchClient = new SearchClient(self::$client);
        $ret = $searchClient->execute($searchParamsBuilder->build());
        $ret = json_decode($ret, true);
        $clauses = $this->parse($ret['params']['query']);
        $this->assertEquals(1234, $clauses['config']['a']);

        $array = array('key' => 'customConfig', 'value' => array("abc" => 'def'));
        $clauses = $this->getClauses($array['key'], $array['value'], '', true);
        $this->assertEquals('def', $clauses['config']['abc']);

        $array = array('key' => 'customConfig', 'value' => array("a" => 'b', 'c' => 'd'));
        $clauses = $this->getClauses($array['key'], $array['value'], '', true);
        $this->assertEquals('b', $clauses['config']['a']);
        $this->assertEquals('d', $clauses['config']['c']);

        $searchParamsBuilder = new SearchParamsBuilder();
        $searchParamsBuilder->setCustomConfig('a', 'b');
        $searchParamsBuilder->setCustomConfig('c', 'd');
        $searchClient = new SearchClient(self::$client);
        $ret = $searchClient->execute($searchParamsBuilder->build());
        $ret = json_decode($ret, true);
        $clauses = $this->parse($ret['params']['query']);
        $this->assertEquals('b', $clauses['config']['a']);
        $this->assertEquals('d', $clauses['config']['c']);
    }

    public function testSetQuery() {
        $array = array('key' => 'query', 'value' => "''");
        $clauses = $this->getClauses($array['key'], $array['value'], 'setQuery');
        $this->assertEquals($array['value'], $clauses['query']);

        $array = array('key' => 'query', 'value' => "default:'abc'");
        $clauses = $this->getClauses($array['key'], $array['value'], 'setQuery');
        $this->assertEquals($array['value'], $clauses['query']);

        $array = array('key' => 'query', 'value' => "default:'abc'");
        $clauses = $this->getClauses($array['key'], $array['value'], '', true);
        $this->assertEquals($array['value'], $clauses['query']);

    }

    public function testAddFilter() {
        $array = array('key' => 'filter', 'value' => "a>1");
        $clauses = $this->getClauses($array['key'], $array['value'], 'addFilter');
        $this->assertEquals($array['value'], $clauses['filter']);

        $searchParamsBuilder = new SearchParamsBuilder();
        $searchParamsBuilder->addFilter('a>1');
        $searchParamsBuilder->addFilter('b>2');

        $searchClient = new SearchClient(self::$client);
        $ret = $searchClient->execute($searchParamsBuilder->build());
        $ret = json_decode($ret, true);
        $clauses = $this->parse($ret['params']['query']);
        $this->assertEquals('a>1 AND b>2', $clauses['filter']);

        $searchParamsBuilder->setFilter('a>1 or b<2');
        $searchClient = new SearchClient(self::$client);
        $ret = $searchClient->execute($searchParamsBuilder->build());
        $ret = json_decode($ret, true);
        $clauses = $this->parse($ret['params']['query']);
        $this->assertEquals('a>1 or b<2', $clauses['filter']);

        $searchParamsBuilder->addFilter('c>3', 'OR');
        $searchClient = new SearchClient(self::$client);
        $ret = $searchClient->execute($searchParamsBuilder->build());
        $ret = json_decode($ret, true);
        $clauses = $this->parse($ret['params']['query']);
        $this->assertEquals('a>1 or b<2 OR c>3', $clauses['filter']);

        $searchParamsBuilder = new SearchParamsBuilder(array('filter' => 'a>1 OR b>2'));
        $searchClient = new SearchClient(self::$client);
        $ret = $searchClient->execute($searchParamsBuilder->build());
        $ret = json_decode($ret, true);
        $clauses = $this->parse($ret['params']['query']);
        $this->assertEquals('a>1 OR b>2', $clauses['filter']);
    }

    public function testAddSort() {
        $searchParamsBuilder = new SearchParamsBuilder();
        $searchParamsBuilder->addSort('a');
        $searchParamsBuilder->addSort('b', SearchParamsBuilder::SORT_DECREASE);
        $searchClient = new SearchClient(self::$client);
        $ret = $searchClient->execute($searchParamsBuilder->build());
        $ret = json_decode($ret, true);
        $clauses = $this->parse($ret['params']['query']);
        $this->assertEquals('-a;-b', $clauses['sort']);

        $searchParamsBuilder = new SearchParamsBuilder();
        $searchParamsBuilder->addSort('a');
        $searchParamsBuilder->addSort('RANK', SearchParamsBuilder::SORT_INCREASE);
        $searchClient = new SearchClient(self::$client);
        $ret = $searchClient->execute($searchParamsBuilder->build());
        $ret = json_decode($ret, true);
        $clauses = $this->parse($ret['params']['query']);
        $this->assertEquals('-a;+RANK', $clauses['sort']);

        $array = array(
            array('field' => 'a'),
            array('field' => 'b', 'order' => SearchParamsBuilder::SORT_INCREASE)
        );
        $searchParamsBuilder = new SearchParamsBuilder(array('sort' => $array));
        $searchClient = new SearchClient(self::$client);
        $ret = $searchClient->execute($searchParamsBuilder->build());
        $ret = json_decode($ret, true);
        $clauses = $this->parse($ret['params']['query']);
        $this->assertEquals('-a;+b', $clauses['sort']);
    }

    public function testSetAppName() {
        $appNames = 'abc';
        $uri = $this->getUri($appNames);
        $this->assertEquals($uri, "/apps/{$appNames}/search");

        $appNames = array('abc');
        $appNameString = implode(";", $appNames);
        $uri = $this->getUri($appNames);
        $this->assertEquals($uri, "/apps/{$appNameString}/search");

        $appNames = array('abc', 'def');
        $appNameString = implode(",", $appNames);
        $uri = $this->getUri($appNames);
        $this->assertEquals($uri, "/apps/{$appNameString}/search");
    }

    public function testSetFetchFields() {
        $array = array('key' => 'fetchFields', 'value' => array('a', 'b', 'c'));
        $ret = $this->getUriAndParams($array['key'], $array['value'], 'setFetchFields');
        $this->assertEquals(implode(";", $array['value']), $ret['params']['fetch_fields']);

        $array = array('key' => 'fetchFields', 'value' => array('a'));
        $ret = $this->getUriAndParams($array['key'], $array['value'], 'setFetchFields');
        $this->assertEquals(implode(";", $array['value']), $ret['params']['fetch_fields']);

        $array = array('key' => 'fetchFields', 'value' => array('a', 'b', 'c'));
        $ret = $this->getUriAndParams($array['key'], $array['value'], '', true);
        $this->assertEquals(implode(";", $array['value']), $ret['params']['fetch_fields']);
    }

    public function testSetRouteValue() {
        $array = array('key' => 'routeValue', 'value' => 'abc');
        $ret = $this->getUriAndParams($array['key'], $array['value'], 'setRouteValue');
        $this->assertEquals($array['value'], $ret['params']['route_value']);

        $array = array('key' => 'routeValue', 'value' => 'abc');
        $ret = $this->getUriAndParams($array['key'], $array['value'], '', true);
        $this->assertEquals($array['value'], $ret['params']['route_value']);
    }

    public function testSetFirstRankName() {
        $result = $this->getUriAndParams('firstRankName', 'aaa', 'setFirstRankName');
        $this->assertEquals('aaa', $result['params']['first_rank_name']);

        $result = $this->getUriAndParams('firstRankName', 'bbb', '', true);
        $this->assertEquals('bbb', $result['params']['first_rank_name']);
    }

    public function testSetSecondRankName() {
        $result = $this->getUriAndParams('secondRankName', 'aaa', 'setSecondRankName');
        $this->assertEquals('aaa', $result['params']['second_rank_name']);

        $result = $this->getUriAndParams('secondRankName', 'bbb', '', true);
        $this->assertEquals('bbb', $result['params']['second_rank_name']);
    }

    public function setSecondRankTypeDataProvider(): array
    {
        return [
            [RankType::EXPRESSION, 'expression'],
            [RankType::CAVA_SCRIPT, 'cava_script'],
            [null, null],
        ];
    }

    /**
     * @dataProvider setSecondRankTypeDataProvider
     */
    public function testSetSecondRankType($rankType, $expected): void
    {
        $paramKey = 'secondRankType';
        $methodName = 'setSecondRankType';
        $queryParamKey = 'second_rank_type';
        $result = $this->getUriAndParams($paramKey, $rankType, $methodName);
        if (isset($expected)) {
            $this->assertEquals($expected, $result['params'][$queryParamKey]);
        } else {
            $this->assertArrayNotHasKey($queryParamKey, $result['params']);
        }

        $result = $this->getUriAndParams($paramKey, $rankType, '', true);
        if (isset($expected)) {
            $this->assertEquals($expected, $result['params'][$queryParamKey]);
        } else {
            $this->assertArrayNotHasKey($queryParamKey, $result['params']);
        }
    }

    public function testAddQueryProcessor() {
        $result = $this->getUriAndParams('qp', 'aaa', 'addQueryProcessor');
        $this->assertEquals('aaa', $result['params']['qp']);

        $result = $this->getUriAndParams('qp', 'abc', '', true);
        $this->assertEquals('abc', $result['params']['qp']);
    }

    public function testAddCustomParam() {
        $customParam = array('key' => 'abc', 'value' => 'def');
        $searchParamsBuilder = new SearchParamsBuilder();
        $searchParamsBuilder->setCustomParam($customParam['key'], $customParam['value']);
        $searchClient = new SearchClient(self::$client);
        $ret = $searchClient->execute($searchParamsBuilder->build());
        $ret = json_decode($ret, true);

        $this->assertEquals($customParam['value'], $ret['params'][$customParam['key']]);

        $result = $this->getUriAndParams('customParams', array($customParam['key'] => $customParam['value']), '', true);
        $this->assertEquals($customParam['value'], $ret['params'][$customParam['key']]);
    }

    public function testAddAggregate() {
        $agg = array(
            'groupKey' => 'abc',
            'aggFun' => 'count()'
        );

        $result = $this->getClauses('aggregate', $agg, 'addAggregate');
        $this->assertEquals('group_key:abc,agg_fun:count()', $result['aggregate']);

        $result = $this->getClauses('aggregate', $agg, '', true);
        $this->assertEquals('group_key:abc,agg_fun:count()', $result['aggregate']);

        $agg = array(
            'groupKey' => 'abc',
        );
        $result = $this->getClauses('aggregate', $agg, 'addAggregate', true);
        $this->assertFalse($result['aggregate']);

        $agg = array('groupKey' => 'abc', 'aggFun' => 'count()', 'range' => 1, 'maxGroup' => 10, 'aggFilter' => 10, 'aggSamplerThresHold' => 10, 'aggSamplerStep' => 1);
        $result = $this->getClauses('aggregate', $agg, 'addAggregate');
        $this->assertEquals('group_key:abc,agg_fun:count(),range:1,max_group:10,agg_filter:10,agg_sampler_threshold:10,agg_sampler_step:1', $result['aggregate']);

        $agg = array(
            array('groupKey' => 'abc', 'aggFun' => 'count()', 'range' => 1, 'maxGroup' => 10, 'aggFilter' => 10, 'aggSamplerThresHold' => 10, 'aggSamplerStep' => 1),
            array('groupKey' => 'abc', 'aggFun' => 'count()', 'range' => 1, 'maxGroup' => 10, 'aggFilter' => 10, 'aggSamplerThresHold' => 10, 'aggSamplerStep' => 1)
        );
        $result = $this->getClauses('aggregate', $agg, '', true);
        $this->assertEquals('group_key:abc,agg_fun:count(),range:1,max_group:10,agg_filter:10,agg_sampler_threshold:10,agg_sampler_step:1;group_key:abc,agg_fun:count(),range:1,max_group:10,agg_filter:10,agg_sampler_threshold:10,agg_sampler_step:1', $result['aggregate']);

        $searchParamsBuilder = new SearchParamsBuilder();
        foreach ($agg as $k => $v) {
            unset($v['range'], $v['maxGroup'], $v['aggFilter'], $v['aggSamplerThresHold'], $v['aggSamplerStep']);
            $searchParamsBuilder->addAggregate($v);
        }
        $searchClient = new SearchClient(self::$client);
        $ret = $searchClient->execute($searchParamsBuilder->build());
        $ret = json_decode($ret, true);
        $clauses = $this->parse($ret['params']['query']);
        $this->assertEquals('group_key:abc,agg_fun:count();group_key:abc,agg_fun:count()', $clauses['aggregate']);
    }

    public function testAddDistinct() {
        $dist = array('key' => 'a');
        $result = $this->getClauses('distinct', $dist, 'addDistinct');
        $this->assertEquals('dist_key:a,dist_count:1,dist_times:1,reserved:1', $result['distinct']);

        $result = $this->getClauses('distinct', $dist, '', true);
        $this->assertEquals('dist_key:a,dist_count:1,dist_times:1,reserved:1', $result['distinct']);

        $dist = array(array('key' => 'a'), array('key' => 'b'));
        $result = $this->getClauses('distinct', $dist, '', true);
        $this->assertEquals('dist_key:a,dist_count:1,dist_times:1,reserved:1;dist_key:b,dist_count:1,dist_times:1,reserved:1', $result['distinct']);
    }

    public function testAddSummary() {
        $summary = array('summary_field' => 'description', 'summary_len' => 100, 'summary_ellipsis' => "。。。", 'summary_snippet' => 2, 'summary_element_prefix' => '<span class=a1>', 'summary_element_postfix' => '</span>');
        $str = array();
        foreach ($summary as $k => $v) {
            $str[] = $k . ":" . $v;
        }
        $ret = $this->getUriAndParams('', $summary, 'addSummary');
        $this->assertEquals(implode(",", $str), $ret['params']['summary']);

        $summary = array('summary_field' => 'description', 'summary_len' => 100);
        $ret = $this->getUriAndParams('', $summary, 'addSummary');
        $this->assertEquals('summary_field:description,summary_len:100,summary_ellipsis:...', $ret['params']['summary']);

        $ret = $this->getUriAndParams('summaries', array($summary), '', true);
        $this->assertEquals('summary_field:description,summary_len:100,summary_ellipsis:...', $ret['params']['summary']);
    }

    public function testAddDisableFunctions() {
        $ret = $this->getUriAndParams('disableFunctions', "test=11111", 'addDisableFunctions');
        $this->assertEquals('test=11111', $ret['params']['disable']);

        $ret = $this->getUriAndParams('disableFunctions', 'test:123', '', true);
        $this->assertEquals('test:123', $ret['params']['disable']);

        $ret = $this->getUriAndParams('disableFunctions', array('test:123'), '', true);
        $this->assertEquals('test:123', $ret['params']['disable']);

    }

    public function testSetScrollExpire() {
        $ret = $this->getUriAndParams('', '3m', 'setScrollExpire');
        $this->assertEquals('scan', $ret['params']['search_type']);
        $this->assertEquals('3m', $ret['params']['scroll']);
    }

    public function testSetSetScrollId() {
        $ret = $this->getUriAndParams('', 'abc', 'setScrollId');
        $this->assertEquals('1m', $ret['params']['scroll']);
        $this->assertEquals('abc', $ret['params']['scroll_id']);

        $searchParamsBuilder = new SearchParamsBuilder();
        $searchParamsBuilder->setScrollExpire('3m');
        $searchParamsBuilder->setScrollId('abc');

        $searchClient = new SearchClient(self::$client);
        $ret = $searchClient->execute($searchParamsBuilder->build());
        $ret = json_decode($ret, true);
        $this->assertEquals('3m', $ret['params']['scroll']);
        $this->assertEquals('abc', $ret['params']['scroll_id']);
    }

    private function getUri($appNames) {
        if (is_array($appNames)) {
            $appNameString = implode(',', $appNames);
        } else {
            $appNameString = $appNames;
        }
        $searchParamsBuilder = new SearchParamsBuilder();
        $searchParamsBuilder->setAppName($appNames);
        $searchClient = new SearchClient(self::$client);

        $ret = $searchClient->execute($searchParamsBuilder->build());
        $params = json_decode($ret, true);
        $this->assertEquals($params['path'], "/apps/{$appNameString}/search");

        $searchParamsBuilder = new SearchParamsBuilder(array('appName' => $appNames));
        $searchClient = new SearchClient(self::$client);

        $ret = $searchClient->execute($searchParamsBuilder->build());
        $params = json_decode($ret, true);
        $this->assertEquals($params['path'], "/apps/{$appNameString}/search");
        return $params['path'];
    }

    private function getClauses($paramKey, $paramValue, $functionName, $options = false, $isNull = false) {
        $params = $this->getUriAndParams($paramKey, $paramValue, $functionName, $options, $isNull);
        $clauses = $this->parse($params['params']['query']);
        return $clauses;
    }

    private function getUriAndParams($paramKey, $paramValue, $functionName, $options = false, $isNull = false) {
        if ($options == false) {
            $searchParamsBuilder = new SearchParamsBuilder();
            if (!$isNull) {
                $searchParamsBuilder->$functionName($paramValue);
            }
        } else {
            $searchParamsBuilder = new SearchParamsBuilder([$paramKey => $paramValue]);

        }
        $searchClient = new SearchClient(self::$client);

        $ret = $searchClient->execute($searchParamsBuilder->build());
        $params = json_decode($ret, true);
        return $params;
    }

    private function parse($string) {
        $ret = array();
        $clauses = explode('&&', $string);
        foreach ($clauses as $clause) {
            if (substr($clause, 0, 7) == 'config=') {
                $clause = substr($clause, 7);
                $split = explode(',', $clause);
                foreach ($split as $kvs) {
                    list($k, $v) = explode(':', $kvs);
                    $ret['config'][$k] = $v;
                }
            } else if (substr($clause, 0, 6) == 'query=') {
                $ret['query'] = substr($clause, 6);
            } else if (substr($clause, 0, 5) == 'sort=') {
                $ret['sort'] = substr($clause, 5);
            } else if (substr($clause, 0, 7) == 'filter=') {
                $ret['filter'] = substr($clause, 7);
            } else if (substr($clause, 0, 10) == 'aggregate=') {
                $ret['aggregate'] = substr($clause, 10);
            } else if (substr($clause, 0, 9) == 'distinct=') {
                $ret['distinct'] = substr($clause, 9);

            }
        }

        return $ret;
    }
}
