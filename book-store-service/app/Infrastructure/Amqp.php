<?php

namespace App\Infrastructure;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Amqp
{
    const TYPE = 'book';
    const TYPE_EXCHANGE_CREATE = 'create-' . self::TYPE;
    const TYPE_EXCHANGE_UPDATE = 'update-' . self::TYPE;
    const TYPE_EXCHANGE_DELETE = 'delete-' . self::TYPE;

    private $channel;
    private $connection;

    public function __construct()
    {
        $host = config('amqp.host');
        $port = config('amqp.port');
        $user = config('amqp.user');
        $password = config('amqp.password');

        $this->connection = new AMQPStreamConnection($host, $port, $user, $password);
        $this->channel = $this->connection->channel();
    }

    public function publish(array $data, string $typeExchange)
    {
        $this->channel->exchange_declare($typeExchange, 'topic', false, false, true);

        $dataJson = json_encode($data);
        $msg = new AMQPMessage($dataJson);

        $this->channel->basic_publish($msg, $typeExchange);
    }

    public function setClose()
    {
        $this->channel->close();
        $this->connection->close();
    }

    public function receiving(string $typeExchange, $functionCallback)
    {
        $this->channel->exchange_declare($typeExchange, 'topic', false, false, true);

        list($queueName,,) = $this->channel->queue_declare("", false, false, true, false);

        $this->channel->queue_bind($queueName, $typeExchange);

        $this->channel->basic_consume($queueName, '', false, true, false, false, $functionCallback);

        while ($this->channel->is_open()) {
            $this->channel->wait();
        }
    }
}
