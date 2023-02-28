<?php
//данная функция сообщает разработчику о несуществующей переменной, 
//если он ее не инициализировал
error_reporting(-1);

use vendor\core\Router;


$query = rtrim($_SERVER['QUERY_STRING'], '/');

define('www', __DIR__);
define('CORE',dirname(__DIR__) . '/vendor/core/');
define('ROOT',dirname(__DIR__));
define('APP',dirname(__DIR__) . '/app');



//echo $query = $_SERVER['QUERY_STRING'];

//require '../vendor/core/Router.php';

require '../vendor/libs/functions.php';

/* require '../app/controllers/Main.php'; */

 //require '../app/controllers/Posts.php';

/*require '../app/controllers/PostsNew.php'; */

//require '/public/index.php';

spl_autoload_register(function($class){
	$file = ROOT . '/' . str_replace('\\','/',$class) . '.php';
	//$file = APP . "/controllers/$class.php";
	if(is_file($file)){
		require_once $file;
	}
});

$router = new Router();

/*
Router::add('posts/add',['controller'=>'Posts','action'=>'add']);

Router::add('posts/',['controller'=>'Posts','action'=>'index']);

Router::add('',['controller'=>'Main','action'=>'index']);
*/

Router::add('^pages/?(?P<action>[a-z-]+)?$',['controller'=>'Posts']);

Router::add('^$',['controller'=>'Main','action'=>'index']);

Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?');


debug(Router::getRoutes());

Router::dispatch($query);

/*
if(Router::matchRoute($query)){
	debug(Router::getRoutes());
}else{
   echo'<h1>404</h1>';
}
*/
