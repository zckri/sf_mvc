<?php
require "vendor/autoload.php";
define("CONTROLLERS","src/Kapo/Controllers/");

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;


// Loads YML routes
$locator = new FileLocator(array(__DIR__));
$loader = new YamlFileLoader($locator);
$routes = $loader->load('routes.yml');


// FOR obtaining $_GET with fancy HttpFoundation 
$request = Request::createFromGlobals();
$context = new RequestContext();
$context->fromRequest($request);

// Init URL matcher
$matcher = new UrlMatcher($routes, $context);

// isset($_GET['r'])
if($request->query->has('r')){
	try{
		$arr = $matcher->match($request->query->get('r'));
	}catch(Exception $e){
		echo '[404: Route not found!]';
		die();
	}
	if(isset($arr['_controller'])){
		list($controllerName,$actionName) = explode('::',$arr['_controller']);
		
		if(isset($controllerName) && isset($actionName)){
			print_r($arr);
			include_once CONTROLLERS.$controllerName.'.php';
			$runClass = 'Kapo\\Controllers\\'.$controllerName;
			$run = new $runClass();
			$run->$actionName();
		}
	}
}
