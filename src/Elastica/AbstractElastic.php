<?php

namespace Kisphp\Elastica;

use Elasticsearch\Client;

abstract class AbstractElastic
{
    const ES_INDEX_NAME = 'abstract_elasticsearch';
    const ES_TYPE_NAME = 'elasticsearch';

    /**
     * Primary key of the object.
     */
    const IDENTIFIER = 'id';

    /**
     * @var Client
     */
    protected $client;

    /**
     * @param \Elasticsearch\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param array $objectData
     *
     * @return array
     */
    public function indexObject(array $objectData)
    {
        return $this->client->index([
            'index' => $this->createIndexName(),
            'type' => static::ES_TYPE_NAME,
            'id' => $objectData[static::IDENTIFIER],
            'body' => $objectData,
        ]);
    }

    /**
     * @param array $objectData
     *
     * @return array
     */
    public function updateObject(array $objectData)
    {
        return $this->client->update([
            'index' => $this->createIndexName(),
            'type' => static::ES_TYPE_NAME,
            'id' => $objectData[static::IDENTIFIER],
            'body' => [
                'doc' => $objectData,
            ],
        ]);
    }

    /**
     * @param int $objectId
     *
     * @return array
     */
    public function deleteObject($objectId)
    {
        return $this->client->delete([
            'index' => $this->createIndexName(),
            'type' => static::ES_TYPE_NAME,
            'id' => $objectId,
        ]);
    }

    /**
     * @param int $objectId
     *
     * @return array
     */
    public function getObject($objectId)
    {
        return $this->client->get([
            'index' => $this->createIndexName(),
            'type' => static::ES_TYPE_NAME,
            'id' => $objectId,
        ]);
    }

    /**
     * @param array $criteria
     *
     * @return array
     */
    public function searchObject(array $criteria)
    {
//        $criteria = [
//            'content' => 'content',
//        ];

        $params = [
            'index' => $this->createIndexName(),
            'type' => static::ES_TYPE_NAME,
            'body' => [
                'query' => [
                    'match' => $criteria,
                ],
            ],
        ];

        return $this->client->search($params);
    }

    /**
     * @return string
     */
    protected function createIndexName()
    {
        return static::ES_INDEX_NAME;
    }
}
