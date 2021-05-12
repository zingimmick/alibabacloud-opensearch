<?php
/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */

use OpenSearch\Generated\Suggestion\ReSearch;
use OpenSearch\Generated\Suggestion\SuggestParams;
use OpenSearch\Util\SuggestUrlParamsBuilder;

class SuggestUrlParamsBuilderTest extends PHPUnit_Framework_TestCase
{
    public function initReSearchDataProvider(): array
    {
        return [
            [ReSearch::HOMONYM, 'homonym'],
            [null, null],
        ];
    }
    /**
     * @test
     * @dataProvider initReSearchDataProvider
     */
    public function initReSearch($reSearch, $expected): void
    {
        $searchParams = new SuggestParams();
        $searchParams->reSearch = $reSearch;

        $urlParamsBuilder = new SuggestUrlParamsBuilder($searchParams);
        $params = $urlParamsBuilder->getHttpParams();
        $paramKey = 're_search';
        if (isset($expected)) {
            $this->assertEquals($expected, $params[$paramKey]);
        } else {
            $this->assertArrayNotHasKey($paramKey, $params);
        }
    }

    public function initQueryDataProvider(): array
    {
        return [
            ['阿里巴巴', '阿里巴巴'],
            ['foo', 'foo'],
            [null, null],
        ];
    }
    /**
     * @test
     * @dataProvider initQueryDataProvider
     */
    public function initQuery($query, $expected): void
    {
        $searchParams = new SuggestParams();
        $searchParams->query = $query;

        $urlParamsBuilder = new SuggestUrlParamsBuilder($searchParams);
        $params = $urlParamsBuilder->getHttpParams();
        $paramKey = 'query';
        if (isset($expected)) {
            $this->assertEquals($expected, $params[$paramKey]);
        } else {
            $this->assertArrayNotHasKey($paramKey, $params);
        }
    }

    public function initUserIdDataProvider(): array
    {
        return [
            ['阿里巴巴', '阿里巴巴'],
            ['foo', 'foo'],
            [null, null],
        ];
    }
    /**
     * @test
     * @dataProvider initUserIdDataProvider
     */
    public function initUserId($userId, $expected): void
    {
        $searchParams = new SuggestParams();
        $searchParams->userId = $userId;

        $urlParamsBuilder = new SuggestUrlParamsBuilder($searchParams);
        $params = $urlParamsBuilder->getHttpParams();
        $paramKey = 'user_id';
        if (isset($expected)) {
            $this->assertEquals($expected, $params[$paramKey]);
        } else {
            $this->assertArrayNotHasKey($paramKey, $params);
        }
    }

    public function initHitsDataProvider(): array
    {
        return [
            [123, 123],
            [0, 0],
            [-1, -1],
            [null, null],
        ];
    }
    /**
     * @test
     * @dataProvider initHitsDataProvider
     */
    public function initHits($hits, $expected): void
    {
        $searchParams = new SuggestParams();
        $searchParams->hits = $hits;

        $urlParamsBuilder = new SuggestUrlParamsBuilder($searchParams);
        $params = $urlParamsBuilder->getHttpParams();
        $paramKey = 'hit';
        if (isset($expected)) {
            $this->assertEquals($expected, $params[$paramKey]);
        } else {
            $this->assertArrayNotHasKey($paramKey, $params);
        }
    }
}