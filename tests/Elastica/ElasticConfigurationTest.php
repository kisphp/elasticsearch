<?php

namespace tests\Lumas;

use Kisphp\Elastica\ElasticConfiguration;
use PHPUnit\Framework\TestCase;

class ElasticConfigurationTest extends TestCase
{
    public function test_configuration()
    {
        $config = new ElasticConfiguration();
        $config->addServer('localhost', 9200);

        self::assertSame([
            [
                'host' => 'localhost',
                'port' => 9200,
            ],
        ], $config->getServers());
    }
}
