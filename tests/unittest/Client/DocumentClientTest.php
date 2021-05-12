<?php

use OpenSearch\Client\AppClient;
use OpenSearch\Client\OpenSearchClient;
use OpenSearch\Client\DocumentClient;
use OpenSearch\Generated\Common\Pageable;

class DocumentClientTest extends PHPUnit_Framework_TestCase {

    private static $client;

    public function setUp() {
        self::$client = \Mockery::mock(OpenSearchClient::class);
        self::$client->shouldReceive('post')->andReturnUsing(
            function ($path, $body) {
                return array('path' => $path, 'body' => $body);
            }
        );
    }

    protected function tearDown() {
        \Mockery::close();
    }

    public function testAdd() {
        $fields = array("id" => 1, "name" => "test");
        $appName = 'app_name';
        $tableName = 'table_name';
        $doc = new DocumentClient(self::$client);
        $doc->add($fields);
        $ret = $doc->commit($appName, $tableName);

        $this->assertEquals($ret['path'], "/apps/{$appName}/{$tableName}/actions/bulk");

        $body = json_decode($ret['body']);
        $this->assertEquals($body[0]->cmd, 'ADD');
        $this->assertEquals($body[0]->fields->id, 1);
        $this->assertEquals($body[0]->fields->name, 'test');
    }

    public function testUpdate() {
        $fields = array("id" => 1, "name" => "test");
        $appName = 'app_name';
        $tableName = 'table_name';
        $doc = new DocumentClient(self::$client);
        $doc->update($fields);
        $ret = $doc->commit($appName, $tableName);

        $this->assertEquals($ret['path'], "/apps/{$appName}/{$tableName}/actions/bulk");

        $body = json_decode($ret['body']);
        $this->assertEquals($body[0]->cmd, 'UPDATE');
        $this->assertEquals($body[0]->fields->id, 1);
        $this->assertEquals($body[0]->fields->name, 'test');
    }

    public function testRemove() {
        $fields = array("id" => 1, "name" => "test");
        $appName = 'app_name';
        $tableName = 'table_name';
        $doc = new DocumentClient(self::$client);
        $doc->remove($fields);
        $ret = $doc->commit($appName, $tableName);

        $this->assertEquals($ret['path'], "/apps/{$appName}/{$tableName}/actions/bulk");

        $body = json_decode($ret['body']);
        $this->assertEquals($body[0]->cmd, 'DELETE');
        $this->assertEquals($body[0]->fields->id, 1);
        $this->assertEquals($body[0]->fields->name, 'test');
    }

    public function testPush() {
        $fields = array("id" => 1, "name" => "test");
        $appName = 'app_name';
        $tableName = 'table_name';

        $doc = new DocumentClient(self::$client);
        $json = json_encode(array(array("fields" => $fields, "cmd" => "ADD")));

        $ret = $doc->push($json, $appName, $tableName);

        $this->assertEquals($ret['path'], "/apps/{$appName}/{$tableName}/actions/bulk");

        $body = json_decode($ret['body']);
        $this->assertEquals($body[0]->cmd, 'ADD');
        $this->assertEquals($body[0]->fields->id, 1);
        $this->assertEquals($body[0]->fields->name, 'test');
    }

    public function testPushOneDoc() {
        $fields = array("id" => 1, "name" => "test");
        $appName = 'app_name';
        $tableName = 'table_name';
        $doc = new DocumentClient(self::$client);

        $this->assertEmpty($doc->docs);
        $doc->pushOneDoc($fields, 'ADD');

        $this->assertEquals($doc->docs[0]['fields']['id'], 1);
        $this->assertEquals($doc->docs[0]['fields']['name'], 'test');
        $this->assertEquals($doc->docs[0]['cmd'], 'ADD');
        $this->assertEquals(count($doc->docs), 1);

        $fields['name'] = 'test1';
        $doc->remove($fields);
        $this->assertEquals(count($doc->docs), 2);
        $this->assertEquals($doc->docs[1]['cmd'], 'DELETE');
        $this->assertEquals($doc->docs[1]['fields']['name'], 'test1');

        $ret = $doc->commit($appName, $tableName);
        $this->assertEquals(count($doc->docs), 0);

        $this->assertEquals($ret['path'], "/apps/{$appName}/{$tableName}/actions/bulk");

        $body = json_decode($ret['body']);
        $this->assertEquals($body[0]->cmd, 'ADD');
        $this->assertEquals($body[0]->fields->id, 1);
        $this->assertEquals($body[0]->fields->name, 'test');
        $this->assertEquals(count($body), 2);
    }
}