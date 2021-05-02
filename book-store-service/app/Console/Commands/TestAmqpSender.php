<?php

namespace App\Console\Commands;

use App\Infrastructure\Amqp;
use Illuminate\Console\Command;

class TestAmqpSender extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test-cmd:amqp-sender';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Amqp Sender';

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
        $data = [
            'id' => 12,
            'name' => 'Rojak Kholer',
            'year' => '2019'
        ];
        
        $amqp->publish($data, Amqp::TYPE_EXCHANGE_CREATE);
        $amqp->setClose();
    }
}
