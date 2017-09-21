<?php

namespace Kisphp\Elastica;

class ElasticConfiguration
{
    /**
     * @var array
     */
    protected $servers = [];

    /**
     * @param string $host
     * @param int $port
     *
     * @return $this
     */
    public function addServer($host, $port)
    {
        $this->servers[] = [
            'host' => $host,
            'port' => $port,
        ];

        return $this;
    }

    /**
     * @return array
     */
    public function getServers()
    {
        return $this->servers;
    }
}
