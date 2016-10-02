<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Hoa\Event\Bucket;

use Hoa\Websocket\Server as Websocket;

use Hoa\Socket\Server as SocketServ;

class StartSocketServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'socket:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        $websocket = new Websocket(
            new SocketServ('ws://localhost:8889')
        );
        $websocket->on('open', function (Bucket $bucket) {
            echo 'new connection', "\n";

            return;
        });
        $websocket->on('message', function (Bucket $bucket) {
            $data = $bucket->getData();
            echo '> message ', $data['message'], "\n";
            $bucket->getSource()->send($data['message']);
            echo '< echo', "\n";

            return;
        });
        $websocket->on('close', function (Bucket $bucket) {
            echo 'connection closed', "\n";

            return;
        });
        $websocket->run();
    }
}
