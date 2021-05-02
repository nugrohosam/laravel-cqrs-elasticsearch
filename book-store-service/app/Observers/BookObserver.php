<?php

namespace App\Observers;

use App\Infrastructure\Amqp;
use App\Models\Book;

class BookObserver
{
    private $amqp;

    public function __construct(Amqp $amqp)
    {
        $this->amqp = $amqp;
    }

    public function created(Book $book)
    {
        $this->amqp->publish($book->toArray(), Amqp::TYPE_EXCHANGE_CREATE);
        $this->amqp->setClose();
    }

    public function updated(Book $book)
    {
        $this->amqp->publish($book->toArray(), Amqp::TYPE_EXCHANGE_UPDATE);
        $this->amqp->setClose();
    }

    public function forceDelete(Book $book)
    {
        $this->amqp->publish($book->toArray(), Amqp::TYPE_EXCHANGE_DELETE);
        $this->amqp->setClose();
    }
}
