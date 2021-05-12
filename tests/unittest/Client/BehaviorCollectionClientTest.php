<?php

use OpenSearch\Client\OpenSearchClient;
use OpenSearch\Client\BehaviorCollectionClient;

class BehaviorCollectionClientTest extends PHPUnit_Framework_TestCase {

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
    	$searchAppName = "fx_data_collection_test_7";
		$behaviorCollectionName = "51";

		$searchDocListPage  = "search_doc_list_page_name";
		$docDetailPage      = "doc_detail_page_name";
		$detailPageStayTime = 100;
		$objectId           = "record_pk_name";
		$opsRequestMisc     = "{\"request_id\":\"153432217417441333635673\", \"scm\":\"a.b.c.d\"}";

		$behaviorCollectionClient = new BehaviorCollectionClient(self::$client);
		$behaviorCollectionClient->addSearchDocClickRecord($searchDocListPage, $docDetailPage, $detailPageStayTime, $objectId, $opsRequestMisc);

		$ret = $behaviorCollectionClient->commit($searchAppName, $behaviorCollectionName);

		$this->assertEquals($ret['path'], "/app-groups/{$searchAppName}/data-collections/{$behaviorCollectionName}/actions/bulk");

        $body = json_decode($ret['body']);
        $fields = $body[0]->fields;

        $this->assertEquals($body[0]->cmd, 'ADD');
        $this->assertEquals($fields->event_id, 2001);
        $this->assertEquals($fields->sdk_type, "opensearch_sdk");
        $this->assertEquals($fields->sdk_version, "v3.2.0");
        $this->assertEquals($fields->page, "doc_detail_page_name");
        $this->assertEquals($fields->arg1, "search_doc_list_page_name");
        $this->assertEquals($fields->arg2, "");
        $this->assertEquals($fields->arg3, 100);
        $this->assertEquals($fields->args, "object_id=record_pk_name,object_type=ops_search_doc,ops_request_misc={\"request_id\":\"153432217417441333635673\", \"scm\":\"a.b.c.d\"}");
    }

    public function testPush() {
    	$searchAppName = "fx_data_collection_test_7";
		$behaviorCollectionName = "51";

		$cmd    = "ADD";
		$fields = array(
    		'event_id'    => 2001,
    		'sdk_type'    => 'opensearch_sdk',
    		'sdk_version' => 'v3.2.0',
    		'page' => "doc_detail_page_name",
    		'arg1' => "search_doc_list_page_name",
    		'arg2' => "",
    		'arg3' => 100,
    		'args' => "object_id=record_pk_name,object_type=ops_search_doc,ops_request_misc={\"request_id\":\"153432217417441333635673\", \"scm\":\"a.b.c.d\"}",
    	);
		$recordsJson = json_encode([['cmd' => $cmd, 'fields' => $fields]]);

		$behaviorCollectionClient = new BehaviorCollectionClient(self::$client);
		$ret = $behaviorCollectionClient->push($recordsJson, $searchAppName, $behaviorCollectionName);

		$this->assertEquals($ret['path'], "/app-groups/{$searchAppName}/data-collections/{$behaviorCollectionName}/actions/bulk");

        $body = json_decode($ret['body']);
        $fields = $body[0]->fields;

        $this->assertEquals($body[0]->cmd, 'ADD');
        $this->assertEquals($fields->event_id, 2001);
        $this->assertEquals($fields->sdk_type, "opensearch_sdk");
        $this->assertEquals($fields->sdk_version, "v3.2.0");
        $this->assertEquals($fields->page, "doc_detail_page_name");
        $this->assertEquals($fields->arg1, "search_doc_list_page_name");
        $this->assertEquals($fields->arg2, "");
        $this->assertEquals($fields->arg3, 100);
        $this->assertEquals($fields->args, "object_id=record_pk_name,object_type=ops_search_doc,ops_request_misc={\"request_id\":\"153432217417441333635673\", \"scm\":\"a.b.c.d\"}");
    }
}