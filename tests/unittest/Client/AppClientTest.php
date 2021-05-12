<?php

use OpenSearch\Client\AppClient;
use OpenSearch\Client\OpenSearchClient;
use OpenSearch\Generated\Common\Pageable;

class AppClientTest extends PHPUnit_Framework_TestCase {

    private static $client = null;

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

    public function testSave() {
        $app = '{"name": true}';
        $appClient = new AppClient(self::$client);
        $ret = json_decode($appClient->save('test'));
        $this->assertEquals($ret->path, '/apps');
        $this->assertEmpty($ret->body);

        $ret = json_decode($appClient->save($app));
        $this->assertEquals($ret->path, '/apps');
        $this->assertTrue($ret->body->name);
    }

    public function testGetById() {
        $appClient = new AppClient(self::$client);
        $appId = '1234';
        $ret = json_decode($appClient->getById($appId));
        $this->assertEquals($ret->path, "/apps/{$appId}");

        $appId = 'abcd';
        $ret = json_decode($appClient->getById($appId));
        $this->assertEquals($ret->path, "/apps/{$appId}");
    }

    /*public function testFork() {
        $app = '{"name": true}';

        $appId = 1234;
        $appClient = new AppClient(self::$client);
        $ret = json_decode($appClient->fork($appId, 'test'));
        $this->assertEquals($ret->path, "/apps/{$appId}/actions/fork");
        $this->assertEmpty($ret->body);

        $appId = "abcd";
        $ret = json_decode($appClient->fork($appId, $app));
        $this->assertEquals($ret->path, "/apps/{$appId}/actions/fork");
        $this->assertTrue($ret->body->name);
    }*/

    public function testListAll() {
        $pageable = new Pageable(array('page' => 1, "size" => 2));
        $appClient = new AppClient(self::$client);
        $ret = json_decode($appClient->listAll($pageable));
        $this->assertEquals($ret->path, "/apps");
        $this->assertEquals($ret->params->page, 1);
        $this->assertEquals($ret->params->size, 2);
    }

    public function testRemoveById() {
        $appClient = new AppClient(self::$client);
        $appId = '1234';
        $ret = json_decode($appClient->removeById($appId));
        $this->assertEquals($ret->path, "/apps/{$appId}");

        $appId = 'abcd';
        $ret = json_decode($appClient->removeById($appId));
        $this->assertEquals($ret->path, "/apps/{$appId}");
    }

    public function testUpdateById() {
        $app = '{"name": true}';

        $appId = 1234;
        $appClient = new AppClient(self::$client);
        $ret = json_decode($appClient->updateById($appId, 'test'));
        $this->assertEquals($ret->path, "/apps/{$appId}");
        $this->assertEmpty($ret->body);

        $appId = "abcd";
        $ret = json_decode($appClient->updateById($appId, $app));
        $this->assertEquals($ret->path, "/apps/{$appId}");
        $this->assertTrue($ret->body->name);
    }

    public function testReindexById() {
        $appId = 1234;
        $appClient = new AppClient(self::$client);
        $ret = json_decode($appClient->reindexById($appId));
        $this->assertEquals($ret->path, "/apps/{$appId}/actions/reindex");
        $this->assertEmpty($ret->body);
    }

    /*public function testSetCurrent() {
        $appId = 1234;
        $appClient = new AppClient(self::$client);
        $ret = json_decode($appClient->setCurrent($appId));
        $this->assertEquals($ret->path, "/apps/{$appId}/current");
        $this->assertEmpty($ret->body);
    }*/

}