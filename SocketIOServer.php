<?php
use Workerman\Worker;
use Workerman\WebServer;
use Workerman\Autoloader;
use PHPSocketIO\SocketIO;

// composer autoload
include __DIR__ . '/vendor/autoload.php';

// =======Channel server========
$channel = new Channel\Server();

$io = new SocketIO(2020);

// ========ChannelAdapter========
$io->on('workerStart', function()use($io){
    $io->adapter('\PHPSocketIO\ChannelAdapter');
});

$io->on('connection', function($socket)use($io){
    echo 'Client Connected. ';
    $io->emit('update display', 'TEST');



    // $socket->on('update display', function ($data)use($io){
    //     echo 'database change. ';

    //     // $data = 'MSG from server.';
    //     $io->emit('update display', $data);
    // });
});

// $web = new WebServer('http://0.0.0.0:2022');
Worker::runAll();