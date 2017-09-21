<?php

namespace tests\Elastica;

use Elasticsearch\Client;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use tests\Helpers\DemoIndexer;

class ElasticaTest extends TestCase
{
    /**
     * @var \tests\Helpers\DemoIndexer
     */
    protected $demo;

    public function setUp()
    {
        $client = $this->prophesize(Client::class);
        $client->index(Argument::any())->willReturn([
            'isOk' => true,
        ]);
        $client->update(Argument::any())->willReturn([
            'isOk' => true,
        ]);
        $client->delete(Argument::exact([
            'index' => DemoIndexer::ES_INDEX_NAME,
            'type' => DemoIndexer::ES_TYPE_NAME,
            'id' => 1,
        ]))->willReturn([
            'isOk' => true,
        ]);
        $client->get(Argument::exact([
            'index' => DemoIndexer::ES_INDEX_NAME,
            'type' => DemoIndexer::ES_TYPE_NAME,
            'id' => 1,
        ]))->willReturn([
            'isOk' => true,
        ]);
        $client = $client->reveal();

        $this->demo = new DemoIndexer($client);
    }

    public function test_insert()
    {
        $product = [
            'id' => 1,
            'title' => 'Demo product 1',
            'price' => 2000,
        ];

        $resp = $this->demo->indexObject($product);

        self::assertSame(['isOk' => true], $resp);
    }

    public function test_update()
    {
        $product = [
            'id' => 1,
            'title' => 'Demo product 1',
            'price' => 2000,
        ];

        $resp = $this->demo->updateObject($product);

        self::assertSame(['isOk' => true], $resp);
    }

    public function test_delete()
    {
        $resp = $this->demo->deleteObject(1);

        self::assertSame(['isOk' => true], $resp);
    }

    public function test_get_object()
    {
        $resp = $this->demo->getObject(1);

        self::assertSame(['isOk' => true], $resp);
    }

    public function _test_search_object()
    {
        $resp = $this->demo->searchObject(['title' => 'word']);

        self::assertSame(['isOk' => true], $resp);
    }
}
