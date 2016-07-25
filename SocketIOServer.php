<?php
use Workerman\Worker;
use Workerman\WebServer;
use Workerman\Autoloader;
use PHPSocketIO\SocketIO;

// composer autoload
include __DIR__ . '/vendor/autoload.php';

// Channel Server
$channel = new Channel\Server();
$io = new SocketIO(2020);

// Channel Adapter
$io->on('workerStart', function()use($io){
    $io->adapter('\PHPSocketIO\ChannelAdapter');
});
$io->on('connection', function($socket)use($io){
    echo 'client_onnected.';
});

Worker::runAll();