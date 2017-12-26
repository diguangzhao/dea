<?php
namespace Dea;

class Core {

	private static $APP_SPACE = [
		'Controller' 	=> APP_PATH . '/Controller',
		'Model' 		=> APP_PATH . '/Model',
		'Module' 		=> APP_PATH . '/Module'
	];

	public function __construct() {

	}

	public static function autoload(string $class) {
		$parsePath = explode('\\', $class);
		$path = SYSTEM_PATH;

		// 判断是否为 Dea 命名空间
		if (array_shift($parsePath) == 'Dea') {
			$path1 = array_shift($parsePath);

			if (!$path1) {
				throw new Exception("Error: Class {$class} Not Found! ", 1);
			}

			//是否在APP目录下
			if (array_key_exists($path1, self::$APP_SPACE)) {
				$path = SYSTEM_PATH . "/application/{$path1}/" . implode('/', $parsePath) . '.php';
			} else {
				$path = SYSTEM_PATH . "/application/system/{$path1}" . implode('/', $parsePath) . '.php';
			}
			require_once $path;
		}

	}

	public static function start() {
		error_reporting(E_ALL & ~E_NOTICE);
        spl_autoload_register('\Dea\Core::autoload');
        $composer_path = SYSTEM_PATH.'/vendor/autoload.php';

        \Dea\Controller\Test::setup();
        if (file_exists($composer_path)) {
            require_once $composer_path;
        }

	}
}