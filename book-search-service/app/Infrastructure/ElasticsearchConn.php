<?php

namespace App\Infrastructure;

use Elasticsearch\ClientBuilder;

class ElasticsearchConn
{
    private $client;

    public function __construct()
    {
        $hosts = [
            'http://localhost:9200'
        ];

        $this->client = ClientBuilder::create()
            ->setHosts($hosts)
            ->build();
    }
    
    public function getIndex($index, $body)
    {
        $params = [
            'index'     => $index,
            'body'      => $body
        ];

        $response = $this->client->search($params);
        return $response;
    }

    public function storeIndex($index, $id, $body)
    {
        $params = [
            'index'     => $index,
            'id'        => $id,
            'body'      => $body
        ];

        $response = $this->client->index($params);
        return $response;
    }
}
