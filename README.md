OpenSearch Data Access & Management SDK for PHP
================================================

Opensearch restful API version v3

Overview
--------
This SDK contains wrapper code used to call the OpenSearch Cloud restful API from PHP.

Prerequisites
-------------

How to start
---------------------------------
1. Downlaod the PHP SDK zip and unzip it.
2. Move the SDK to your project.
3. View the demo directory, there are some samples likes app control, document push, app search, suggest search and etc.

Changes in version 3.2.1 (date: 2019-09-12)
------------------------------------------

* FIXED: 修复 abtest 传参问题

Changes in version 3.2.0 (date: 2019-08-23)
------------------------------------------

* NEW: 数据采集 2.0

Changes in version 3.1.0 (date: 2018-09-03)
------------------------------------------

* NEW: 支持 A/B Test
* NEW: 支持 行为数据采集

Changes in version 3.0.1 (date:2017-06-09)
------------------------------------------
* 在使用arg之前先定义arg，否则在php的log level为Notice的时候会报出"Undefined variable: arg"
