<?php


namespace framework;


class Main
{
	public static function run ()
	{
		$uri = $_SERVER['REQUEST_URI'];
		$method = $_SERVER['REQUEST_METHOD'];
		// 假设我们的框架仅支持GET以及POST两种请求方式
		if ($method == 'GET') {
			$uri = explode('?', $uri)[0];
			$data = $_GET;
		} else {
			$data = $_POST;
		}

		if (empty(Route::$routes[$uri]) || Route::$routes[$uri][0] != $method) {
			header("HTTP/1.1 " . 404);
			return;
		}

		list($controller, $function) = explode('@', Route::$routes[$uri][1]);
		if (!class_exists($controller)) {
			header("HTTP/1.1 " . 500);
			return;
		}
		$instance = new $controller();
		if (!method_exists($instance, $function)) {
			header("HTTP/1.1 " . 500);
			return;
		}

		$resp = $instance->$function($data);
		echo json_encode($resp);
	}
}