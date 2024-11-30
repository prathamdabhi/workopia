<?php

class Router
{
    protected $routes = [];

    /**
     * ADDA NEW ROUTE
     *
     * @param String $method
     * @param String $uri
     * @param String $controller
     * @return void
     */
    public function registerRoutes($method, $uri, $controller)
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller
        ];
    }
    /**
     * ADD A GET ROUTE
     * @param  String $uri
     * @param String $controller
     * @return void
     */
    public function get($uri, $controller)
    {
        $this->registerRoutes('GET', $uri, $controller);
    }

    /**
     * ADD A POST ROUTE
     * @param  String $uri
     * @param String $controller
     * @return void
     */
    public function post($uri, $controller)
    {
        $this->registerRoutes('POST', $uri, $controller);
    }

    /**
     * ADD A PUT ROUTE
     * @param  String $uri
     * @param String $controller
     * @return void
     */
    public function put($uri, $controller)
    {
        $this->registerRoutes('PUT', $uri, $controller);
    }

    /**
     * ADD A DELETE ROUTE
     * @param  String $uri
     * @param String $controller
     * @return void
     */
    public function delete($uri, $controller)
    {
        $this->registerRoutes('DELETE', $uri, $controller);
    }

    /**
     * load error page
     * @param int $code
     * @return void
     */

    public function error($code = 404)
    {
        http_response_code($code);
        loadView("error/$code");
        exit();
    }

    /**
     * Route the request
     * @param mixed $uri
     * @param mixed $method
     * @return void
     */

    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === $method) {
                require getPatch('App/' . $route['controller']);
                echo $route['controller'];
                return;
            }
        }
        $this->error();
    }
}
