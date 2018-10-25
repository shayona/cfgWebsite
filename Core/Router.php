<?php

/**
 * Router
 *
 * @author Palash Sharma <hi@palashsharma.com>
 * @copyright 2018 Palash Sharma
 */

namespace Core;

class Router {

  /**
   * Associative array of routes (the routing table)
   * @var array
   */
  protected $routes = [];

  /**
   * Parameters from the matched route
   * @var array
   */
  protected $params = [];

  /**
   * Add a route to the routing table
   *
   * @param string $route  The route URL
   * @param array  $params Parameters (controller, action, etc.)
   *
   * @return void
   */
  public function add($route, $params = []) {
    $route = preg_replace('/\//', '\\/', $route);

    $route = preg_replace('/\{([A-Za-z.\s_-]+)\}/', '(?P<\1>[A-Za-z.\s_-]+)', $route);

    $route = preg_replace('/\{([A-Za-z.\s_-]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

    $route = '/^' . $route . '$/i';

    $this->routes[$route] = $params;
  }

  /**
   * Get all the routes from the routing table
   *
   * @return array
   */
  public function getRoutes() {
    return $this->routes;
  }

  /**
   * Match the route to the routes in the routing table, setting the $params
   * property if a route is found.
   *
   * @param string $url The route URL
   *
   * @return boolean  true if a match found, false otherwise
   */
  public function match($url) {
    foreach ($this->routes as $route => $params) {
      if (preg_match($route, $url, $matches)) {
        foreach ($matches as $key => $match) {
          if (is_string($key)) {
            $params[$key] = $match;
          }
        }

        $this->params = $params;
        
        return true;
      }
    }
    return false;
  }

  /**
   * Get the currently matched parameters
   *
   * @return array
   */
  public function getParams() {
    return $this->params;
  }

  /**
   * Dispatch the route, creating the controller object and running the
   * action method
   *
   * @param string $url The route URL
   *
   * @return void
   */
  public function dispatch($url){
    $url = $this->removeQueryStringVariables($url);

    if ($this->match($url)) {
      $controller = $this->params['controller'];
      $controller = $this->convertToStudlyCaps($controller);
      $controller = $this->getNamespace() . $controller;

      if (class_exists($controller)) {
        $controller_object = new $controller($this->params);

        $action = $this->params['action'];
        $action = $this->convertToCamelCase($action);

        if (preg_match('/action$/i', $action) == 0) {
          $controller_object->$action();
        } else {
          throw new \Exception("Method $action in controller $controller cannot be called directly - remove the Action suffix to call this method");
        }
      } else {
        throw new \Exception("Controller class $controller not found");
      }
    } else {
      throw new \Exception('No route matched.');
    }
  }

  /**
   * Convert the string with hyphens to StudlyCaps,
   * e.g. post-authors => PostAuthors
   *
   * @param string $string The string to convert
   *
   * @return string
   */
  protected function convertToStudlyCaps($string) {
    return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
  }

  /**
   * Convert the string with hyphens to camelCase,
   * e.g. add-new => addNew
   *
   * @param string $string The string to convert
   *
   * @return string
   */
  protected function convertToCamelCase($string) {
    return lcfirst($this->convertToStudlyCaps($string));
  }

  /**
   * Remove the query string variables from the URL (if any). As the full
   * query string is used for the route, any variables at the end will need
   * to be removed before the route is matched to the routing table.
   *
   * @param string $url The full URL
   *
   * @return string The URL with the query string variables removed
   */
  protected function removeQueryStringVariables($url) {
    if ($url != '') {
      $parts = explode('&', $url, 2);

      if (strpos($parts[0], '=') === false) {
        $url = $parts[0];
      } else {
        $url = '';
      }
    }

    $url = rtrim($url, '/');

    return $url;
  }

  /**
   * Get the namespace for the controller class. The namespace defined in the
   * route parameters is added if present.
   *
   * @return string The request URL
   */
  protected function getNamespace() {
    $namespace = 'App\Controllers\\';

    if (array_key_exists('namespace', $this->params)) {
      $namespace .= $this->params['namespace'] . '\\';
    }

    return $namespace;
  }
}
