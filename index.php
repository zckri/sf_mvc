<?php
require "vendor/autoload.php";
define("CONTROLLERS","src/Kapo/Controllers/");

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;


$locator = new FileLocator(array(__DIR__));
$loader = new YamlFileLoader($locator);
$routes = $loader->load('routes.yml');

// $finder = new Finder();

// $iterator = $finder->files()->name('*.php')->in(CONTROLLERS);

// $routes = new RouteCollection();

// // Fill the routing table with controller names
// foreach($iterator as $controller)
//  {
//  	$cname = preg_replace('/\.[^.]*$/', '', $controller->getFilename());
//  	$cn = preg_replace('/controller|\.php/', '', strtolower($controller->getFilename()));
//  	$link = "/{$cn}";
//  	$route = new Route(strtolower($link), array('controller' => $cname));
//  	$routes->add($cname, $route);
//  }

$request = Request::createFromGlobals();

$context = new RequestContext();
$context->fromRequest($request);

$matcher = new UrlMatcher($routes, $context);

if($request->query->has('r')){
	try{
		$arr = $matcher->match($request->query->get('r'));
	}catch(Exception $e){
		echo '[Route not found!]';
		die();
	}
	if(isset($arr['_controller'])){
		list($controllerName,$actionName) = explode('::',$arr['_controller']);
		
		if(isset($controllerName) && isset($actionName)){
			include_once CONTROLLERS.$controllerName.'.php';
			$runClass = 'Kapo\\Controllers\\'.$controllerName;
			$run = new $runClass();
			$run->$actionName();
		}
	}
}
