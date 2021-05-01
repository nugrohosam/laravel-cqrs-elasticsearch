<?php

namespace App\Http\Controllers;

use App\Infrastructure\ElasticsearchConn;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request, ElasticsearchConn $elastic)
    {
        $search = $request->search ?? '';
        $searchArr = str_split($search);
        $search = implode('*', $searchArr);

        $index = 'book_id';
        $body  = [
            'query' => [
                'bool' => [
                    'must' => [
                        'query_string' => [
                            'query' => "(name:*$search*)"
                        ]
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
                                    ]
                                ],
                            ]
                        ]
                    ]
                ]
            ]
        ];


        $response = $elastic->getIndex($index, $body);
        return response()->json($response);
    }

    public function store(Request $request, ElasticsearchConn $elastic)
    {
        $dataArray = $request->data ?? null;
        if (!$dataArray) {
            return;
        }

        $index = 'book_id';
        $id = null;

        foreach ($dataArray as $data) {
            $id = $data['id'];
            $body = $data;
            $response = $elastic->storeIndex($index, $id, $body);
        }

        return response()->json($response);
    }
}
