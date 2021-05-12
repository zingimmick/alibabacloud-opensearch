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

use OpenSearch\Generated\Search\RankType;
use OpenSearch\Generated\Search\SearchParams;
use OpenSearch\Util\UrlParamsBuilder;

class UrlParamsBuilderTest extends PHPUnit_Framework_TestCase
{
    public function initRankCavaScriptDataProvider(): array
    {
        return [
            [RankType::CAVA_SCRIPT, 'cava_script'],
            [RankType::EXPRESSION, 'expression'],
            [null, null],
        ];
    }
    /**
     * @test
     * @dataProvider initRankCavaScriptDataProvider
     */
    public function initRankCavaScript($rankType, $expected): void
    {
        $searchParams = new SearchParams();
        $searchParams->rank->secondRankType = $rankType;

        $urlParamsBuilder = new UrlParamsBuilder($searchParams);
        $params = $urlParamsBuilder->getHttpParams();
        $paramKey = 'second_rank_type';
        if (isset($expected)) {
            $this->assertEquals($expected, $params[$paramKey]);
        } else {
            $this->assertArrayNotHasKey($paramKey, $params);
        }
    }
}