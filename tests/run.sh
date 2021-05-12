#!/usr/bin/env/bash

CURRENT_DIR=`dirname $0`
cd $CURRENT_DIR

chmod 777 ./phpunit-4.7.0

#./phpunit-4.7.0  --bootstrap ./Bootstrap.php  --colors --verbose  --debug  unittest/Client/BehaviorCollectionClientTest
./phpunit-4.7.0  --bootstrap ./Bootstrap.php  --colors --verbose  --debug  unittest/Client/SearchClientTest