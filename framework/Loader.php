<?php


namespace framework;


class Loader
{
	private static $prefixLengthsPsr4 = [
		'app\\' => 4,
		'framework\\' => 10
	];
	private static $prefixPsr4 = [
		'app\\' => __DIR__ . '/..' . '/app',
		'framework\\' => __DIR__
	];

	public static function register ()
	{
		spl_autoload_register(function ($className) {
			$logicalPathPsr4 = strtr($className, '\\', DIRECTORY_SEPARATOR) . '.php';

			foreach (self::$prefixLengthsPsr4 as $prefix => $length) {
				if (0 == strpos($className, $prefix)) {
					$dir = self::$prefixPsr4[$prefix];
					if (is_file($file = $dir . DIRECTORY_SEPARATOR . substr($logicalPathPsr4, $length))) {
						include_once $file;
					}
				}
			}
		}, true, true);
	}
}