<?php

namespace Tests\Feature;

use App\Infrastructure\ElasticsearchConn;
use Tests\TestCase;

class ElasticSearchTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testConnection()
    {
        $elastic = new ElasticsearchConn();
    }
}
