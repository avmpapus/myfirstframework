<?php

namespace vendor\core;

class Router{

     public function __construct(){
     	echo '<h1>привет мир</h1>';
     }


     protected static $routes = [];
     protected static $route = [];

     public static function add($regexp, $route = []){
             self::$routes[$regexp] = $route;
     }


     public static function getRoutes(){
     	return self::$routes;
     }

     public static function getRoute(){
     	return self::$route;
     }

     public static function matchRoute($url){
          foreach(self::$routes as $pattern => $route){
          	if(preg_match("#$pattern#i",$url, $matches)){
          		foreach($matches as $k => $v){
                         if(is_string($k)){
                              $route[$k] = $v;
                         }
                    }
                    if(!isset($route['action'])){
                         $route['action'] = 'index';
                    }
                    $route['controller'] = self::upperCamelCase($route['controller']);
                    self::$route = $route;
          		return true;
          	}
          }
          return false;
     }


     //перенаправляет URL по корректному маршруту
     //@param string $url входящий URL
     //@return void
     public static function dispatch($url){
           if(self::matchRoute($url)){
               $controller = 'app\controllers\\' . self::$route['controller'];
               debug(self::$route);
               if(class_exists($controller)){
                    $cObj = new $controller;
                    $action = self::lowerCamelCase(self::$route['action']) . 'Action';
                    if(method_exists($cObj, $action)){
                         $cObj->$action();
                    }else{
                    echo "Метод $controller::$action не найден";
               }
           }
           else
           {
                echo "controller $controller not found";
           }
          }
           else
           {
               http_response_code(404);
               include '404.html';
           
           }
     }

protected static function upperCamelCase($name){
/*      $name = str_replace('-',' ',$name);
     $name = ucwords($name);
     $name = str_replace(' ','',$name);
 */
     return str_replace(' ','',ucwords(str_replace('-',' ',$name)));
}

protected static function LowerCamelCase($name){
     return lcfirst(self::upperCamelCase($name));
}
}
