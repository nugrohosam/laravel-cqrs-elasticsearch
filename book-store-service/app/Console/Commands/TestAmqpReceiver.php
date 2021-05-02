<?php

namespace App\Console\Commands;

use App\Infrastructure\Amqp;
use Illuminate\Console\Command;

class TestAmqpReceiver extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test-cmd:amqp-receiver';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Amqp Receiver';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $amqp = new Amqp();
        $amqp->receiving(Amqp::TYPE_EXCHANGE_CREATE, function ($message) {
            print($message);
        });
        $amqp->setClose();
    }
}
