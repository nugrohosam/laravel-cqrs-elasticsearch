<?php

namespace App\Applications;

use App\Infrastructure\ElasticsearchConn;

class BookSearchApplication implements IBookApplication
{

    private $elastic;

    public function __construct(ElasticsearchConn $elastic)
    {
        $this->elastic = $elastic;
    }

    public function getSearch($search)
    {
        $index = self::BOOK_INDEX;
        $body  = [
            'query' => [
                'bool' => [
                    'should' => [
                        [
                            'query_string' => [
                                'query' => "(name:*$search*)"
                            ]
                        ],
                        [
                            'query_string' => [
                                'query' => "(year:*$search*)"
                            ]
                        ],
                    ],
                    'filter' => [
                        'bool' => [
                            'should' => [
                                [
                                    'bool' => [
                                        'must' => [
                                            'exists' => [
                                                'field' => 'name'
                                            ]
                                        ]
                                    ],
                                    'bool' => [
                                        'must' => [
                                            'exists' => [
                                                'field' => 'year'
                                            ]
                                        ]
                                    ],
                                ],
                            ]
                        ]
                    ]
                ]
            ]
        ];


        return $this->elastic->getIndex($index, $body);
    }
}
