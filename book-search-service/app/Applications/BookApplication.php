<?php

namespace App\Applications;

use App\Infrastructure\ElasticsearchConn;
use App\Transformers\BookTransformer;
use Exception;

class BookApplication implements IBookApplication
{
    public $callbackCreateListener;
    public $callbackUpdateListener;
    public $callbackDeleteListener;

    public function __construct(ElasticsearchConn $elastic)
    {
        $this->callbackCreateListener = function ($message) use ($elastic) {
            try {
                $book = BookTransformer::fromJsonListener($message->body, true);
                $elastic->storeIndex(self::BOOK_INDEX, $book['id'], $book);
            } catch (Exception $e) {
                print($e->getMessage());
            }
        };

        $this->callbackUpdateListener = function ($message) use ($elastic) {
            try {
                $book = BookTransformer::fromJsonListener($message->body, true);
                $elastic->updateIndex(self::BOOK_INDEX, $book['id'], $book);
            } catch (Exception $e) {
                print($e->getMessage());
            }
        };

        $this->callbackDeleteListener = function ($message) use ($elastic) {
            try {
                $book = BookTransformer::fromJsonListener($message->body, true);
                $elastic->deleteIndex(self::BOOK_INDEX, $book['id']);
            } catch (Exception $e) {
                print($e->getMessage());
            }
        };
    }
}
