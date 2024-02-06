<?php

namespace App;

class Router
{
    private $handlers = [];
    private $notFoundHandler;
    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';

    public function get($path, $handler)
    {
        $this->addHandler(self::METHOD_GET, $path, $handler);
    }

    public function post($path, $handler)
    {

        $this->addHandler(self::METHOD_POST, $path, $handler);
    }

    public function addNotFoundHandler($handler)
    {
        $this->notFoundHandler = $handler;

    }

    public function addHandler($method, $path, $handler)
    {
        $this->handlers[$method . $path] = [
            'path' => $path,
            'method' => $method,
            'handler' => $handler
        ];     // $this->handlers = ["GET/about" => ['path' => $path,'method' => $method,'handler' => $handler]]
    }

    public function run()
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI']);
        $requestPath = $requestUri['path']; // '/about'
        $method = $_SERVER['REQUEST_METHOD']; // 'GET'
        $callback = null;
        foreach ($this->handlers as $handler) {
            if ($handler['path'] === $requestPath && $method === $handler['method']) {
                $callback = $handler['handler'];
            }
        }
        if (is_string($callback)) {
            $parts = explode('::', $callback);

            if (is_array($parts)) {
                $className = array_shift($parts);

                $handler = new $className;

                $method = array_shift($parts);

                $callback = [$handler, $method];
            }
        }
        if (!$callback) {
            header("HTTP/1.0 Not Found");
            if (!empty ($this->notFoundHandler)) {
                $callback = $this->notFoundHandler;
            }
        }
        call_user_func_array($callback, [
            array_merge($_GET, $_POST)
        ]);
    }
}