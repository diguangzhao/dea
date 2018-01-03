<?php

class HttpServer {

    //单例模式：httpserver 实例
    public static $instance;

    public static $get;
    public static $post;
    public static $header;

    public static $http;
    public static $server;

    public function __construct($host = '127.0.0.1', $port = '9301') {

        if (!self::$instance) {

            $http = new swoole_http_server($host, $port);
            $http->set(
                [
                    'worker_num' => 16,
                    // 'daemonize' => true,
                    'max_request' => 10000,
                    'dispatch_mode' => 1
                ]
            );

            $http->on('WorkerStart' , array( $this , 'onWorkerStart'));

            $http->on("request", array($this, 'onRequest'));

            echo "hello \n";

            $http->start();

        } else {
            return self::$instance;
        }
    }

    public function onWorkerStart(swoole_server $server, int $worker_id) {
        echo "work start \n";
    }

    public function onRequest(swoole_http_request $request, swoole_http_response $response) {
        var_dump($request);
        $response->end("<h1>Hello Swoole. #".rand(1000, 9999)."</h1>");
    }

}

$server = new HttpServer('0.0.0.0');
