<?php

namespace Framework;

use App\controllers\ErrorController;

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
    public function registerRoutes($method, $uri, $action)
    {
        list($controller, $controllerMethod) = explode('@', $action);

        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllermethod' => $controllerMethod
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
     * Route the request
     * @param mixed $uri
     * @param mixed $method
     * @return void
     */

    public function route($uri)
    {

        $requestMethod = $_SERVER['REQUEST_METHOD'];

        // check for method input
        if ($requestMethod === 'POST' && $_POST['_method']) {
            $requestMethod = strtoupper($_POST['_method']);
        }
        foreach ($this->routes as $route) {
            //split the current uri into segments
            $uriSegments = explode('/', trim($uri));

            //split the route uri into segments
            $routeSegments = explode('/', trim($route['uri']));

            $match = true;
            // Check if the number of segment match
            if (count($uriSegments) === count($routeSegments) && strtoupper($route['method']) === $requestMethod) {
                $params2 = [];
                $match = true;

                for ($i = 0; $i < count($uriSegments); $i++) {
                    // if the uri not match and there is no param 
                    if ($routeSegments[$i] !== $uriSegments[$i] && !preg_match('/\{(.+?)\}/', $routeSegments[$i])) {
                        $match = false;
                        break;
                    }

                    //check for the params and to $params array
                    if (preg_match('/\{(.+?)\}/', $routeSegments[$i], $matches)) {
                        $params2[$matches[1]] = $uriSegments[$i];
                    }
                }
                if ($match) {
                    $controller = 'App\\controllers\\' . $route['controller'];
                    $controllerMethod = $route['controllermethod'];

                    //instantiate controller and call the method
                    $controllerInstance = new $controller();
                    $controllerInstance->$controllerMethod($params2);
                    return;
                }
            }
        }
        ErrorController::notFound();
    }
}
