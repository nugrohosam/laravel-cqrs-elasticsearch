<?php

namespace App\Console\Commands;

use App\Applications\BookApplication;
use App\Infrastructure\Amqp;
use Illuminate\Console\Command;

class ListenUpdateAmqp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'listen:book-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Receiver Updated Book';

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
    public function handle(BookApplication $bookApp, Amqp $amqp)
    {
        $amqp->receiving(Amqp::TYPE_EXCHANGE_CREATE, $bookApp->callbackUpdateListener);
        $amqp->setClose();
    }
}
