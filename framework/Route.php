<?php


namespace framework;


class Route
{
	public static $routes = [
		'/user/info' => [
			'GET',
			'app\controllers\User@getUserInfo'
		]
	];
}

