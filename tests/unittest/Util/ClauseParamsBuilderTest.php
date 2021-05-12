<?php

use OpenSearch\Util\ClauseParamsBuilder;
use OpenSearch\Generated\Search\SearchParams;
use OpenSearch\Generated\Search\Config;
use OpenSearch\Generated\Search\Sort;
use OpenSearch\Generated\Search\SortField;


class ClauseParamsBuilderTest extends PHPUnit_Framework_TestCase {
    public function setUp() {}

    protected function tearDown() {}

    public function testGetClausesConfigString() {
        $config = new Config();
        $params = new SearchParams(array('config' => $config));

        $params->config->start = 10;

        $clauseParamsBuilder = new ClauseParamsBuilder($params);
        $ret = $this->parse($clauseParamsBuilder->getClausesString());

        $this->assertEquals($ret['config']['start'], 10);
        $this->assertEquals($ret['config']['hit'], 15);
        $this->assertEquals($ret['config']['format'], 'xml');
        $this->assertEquals($ret['config']['rerank_size'], 200);

        $params->config->start = 0;
        $params->config->searchFormat = 1;
        $params->config->hits = 10;

        $clauseParamsBuilder = new ClauseParamsBuilder($params);
        $ret = $this->parse($clauseParamsBuilder->getClausesString());

        $this->assertEquals($ret['config']['start'], 0);
        $this->assertEquals($ret['config']['hit'], 10);
        $this->assertEquals($ret['config']['format'], 'json');
        $this->assertEquals($ret['config']['rerank_size'], 200);
    }

    public function testGetClausesQueryString() {
        $params = new SearchParams();
        $params->query = "default:'test'";
        $clauseParamsBuilder = new ClauseParamsBuilder($params);
        $ret = $this->parse($clauseParamsBuilder->getClausesString());
        $this->assertEquals($ret['query'], $params->query);
    }

    public function testGetClausesQueryStringSort() {
        $params = new SearchParams();
        $params->sort = new Sort();
        $sortField1 = new SortField(array('field' => 'a', 'order' => 0));
        $sortField2 = new SortField(array('field' => 'b'));
        $sortField3 = new SortField(array('field' => 'RANK', 'order' => 1));

        $params->sort->sortFields = array($sortField1, $sortField2, $sortField3);
        $clauseParamsBuilder = new ClauseParamsBuilder($params);

        $ret = $this->parse($clauseParamsBuilder->getClausesString());
        $this->assertEquals($ret['sort'], '-a;-b;+RANK');
    }

    public function testGetClausesStringFilter() {
        $params = new SearchParams();
        $params->filter = 'a>1;b>2';
        $clauseParamsBuilder = new ClauseParamsBuilder($params);
        $ret = $this->parse($clauseParamsBuilder->getClausesString());
        $this->assertEquals($ret['filter'], 'a>1;b>2');
    }

    public function testGetClausesStringDistinct() {}

    public function testGetClausesStringAggregagte() {}

    public function testGetClausesStringRouteValue() {}

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
            }
        }

        return $ret;
    }
}