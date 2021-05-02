<?php

namespace App\Infrastructure;

use Elasticsearch\ClientBuilder;

class ElasticsearchConn
{
    private $client;

    public function __construct()
    {

        $portsStr = config('elasticsearch.ports');
        $ports = explode(',', $portsStr);
        $host = config('elasticsearch.host');
        $hosts = [];

        foreach ($ports as $port) {
            $hosts[] = 'http://' . $host . ':' . $port;
        }

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

    public function updateIndex($index, $id, $body)
    {
        $params = [
            'index'     => $index,
            'id'        => $id,
            'body'      => $body
        ];

        $response = $this->client->update($params);
        return $response;
    }

    public function deleteIndex($index, $id)
    {
        $params = [
            'index'     => $index,
            'id'        => $id
        ];

        $response = $this->client->delete($params);
        return $response;
    }
}
