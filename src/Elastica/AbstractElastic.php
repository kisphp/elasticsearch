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
        $id = empty($objectData[static::IDENTIFIER]) ? null : $objectData[static::IDENTIFIER];

        return $this->client->index([
            'index' => $this->createIndexName(),
            'type' => static::ES_TYPE_NAME,
            'id' => $id,
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
        $del = $this->client->delete([
            'index' => $this->createIndexName(),
            'type' => static::ES_TYPE_NAME,
            'id' => $objectId,
        ]);

        return $del;
    }

    public function hasObjectById($objectId)
    {
        try {
            $a = $this->getObject($objectId);
            dump(__METHOD__ . '::' . __LINE__);
            dump($a);die;
        } catch (\Exception $e) {
            return false;
        }

        return true;
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
    public function searchObject(array $criteria = [])
    {
        $params = [
            'index' => $this->createIndexName(),
            'type' => static::ES_TYPE_NAME,
        ];

        if (!empty($criteria)) {
            $params['body'] = [
                'query' => [
                    'match' => $criteria,
                ],
            ];
        }

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
