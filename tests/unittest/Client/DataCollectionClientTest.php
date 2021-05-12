<?php

use OpenSearch\Client\OpenSearchClient;
use OpenSearch\Client\DataCollectionClient;

class DataCollectionClientTest extends PHPUnit_Framework_TestCase {

    private static $client;

    public function setUp() {
        self::$client = \Mockery::mock(OpenSearchClient::class);
        self::$client->shouldReceive('post')->andReturnUsing(
            function ($path, $body) {
                return array('path' => $path, 'body' => $body);
            }
        );
    }

    public function testCommit() {
        $searchAppName = "zhao_special";
        $dataCollectionName = "zhao_special";
        $dataCollectionType = "BEHAVIOR";

        $dataCollectionClient = new DataCollectionClient(self::$client);
        $dataCollectionClient->add([
            "user_id" => "1120021255",
            "biz_id" => "biz_name",
            "rn" => "156516585419723283227314",
            "trace_id" => "1564455556323223680397827",
            "trace_info" => "%7B%22request%5Fid%22%3A%22156516585419723283227314%22%2C%22scm%22%3A%2220140713.120006678..%22%7D",
            "item_id" => "2223",
            "item_type" => "item",
            "bhv_type" => "click",
            "bhv_time" => "1566475047"
        ]);

        $ret = $dataCollectionClient->commit($searchAppName, $dataCollectionName, $dataCollectionType);
        $this->assertEquals($ret['path'], "/app-groups/{$searchAppName}/data-collections/{$dataCollectionName}/data-collection-type/{$dataCollectionType}/actions/bulk");

        $body = json_decode($ret['body']);
        $fields = $body[0]->fields;

        $this->assertEquals($fields->user_id, "104628");
        $this->assertEquals($fields->biz_id, "jiuchen");
        $this->assertEquals($fields->trace_id, "1564455556323223680397827");
        $this->assertEquals($fields->item_id, "2223");
        $this->assertEquals($fields->item_type, "item");
        $this->assertEquals($fields->bhv_type, "click");
    }

    public function testPush() {
        $searchAppName = "zhao_special";
        $dataCollectionName = "zhao_special";
        $dataCollectionType = "BEHAVIOR";

        $cmd    = "ADD";
        $fields = array(
            "user_id" => "1120021255",
            "biz_id" => "biz_name",
            "rn" => "156516585419723283227314",
            "trace_id" => "Alibaba",
            "trace_info" => "%7B%22request%5Fid%22%3A%22156516585419723283227314%22%2C%22scm%22%3A%2220140713.120006678..%22%7D",
            "item_id" => "2223",
            "item_type" => "item",
            "bhv_type" => "click",
            "bhv_time" => "1566475047"
        );
        $docs = json_encode([['cmd' => $cmd, 'fields' => $fields]]);

        $dataCollectionClient = new DataCollectionClient(self::$client);
        $ret = $dataCollectionClient->push($docs, $searchAppName, $dataCollectionName, $dataCollectionType);

        $this->assertEquals($ret['path'], "/app-groups/{$searchAppName}/data-collections/{$dataCollectionName}/data-collection-type/{$dataCollectionType}/actions/bulk");

        $body = json_decode($ret['body']);
        $fields = $body[0]->fields;

        $this->assertEquals($body[0]->cmd, 'ADD');
        $this->assertEquals($fields->user_id, "104628");
        $this->assertEquals($fields->biz_id, "jiuchen");
        $this->assertEquals($fields->trace_id, "1564455556323223680397827");
        $this->assertEquals($fields->item_id, "2223");
        $this->assertEquals($fields->item_type, "item");
        $this->assertEquals($fields->bhv_type, "click");
    }
}