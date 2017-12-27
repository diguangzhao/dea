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

		// 判断是否为 Dea 命名空间
		if (array_shift($parsePath) == 'Dea') {

			if (!$parsePath[0]) {
				throw new Exception("Error: Class {$class} Not Found! ", 1);
			}

			//是否在APP目录下
			if (array_key_exists($parsePath[0], self::$APP_SPACE)) {
				$path = APP_PATH . '/' . implode('/', $parsePath) . '.php';
			} else {
				$path = SYSTEM_PATH . '/' . implode('/', $parsePath) . '.php';
			}

			require_once $path;
		}

	}

	public static function start() {
		error_reporting(E_ALL & ~E_NOTICE);
        spl_autoload_register('\Dea\Core::autoload');
        $composer_path = ROOT_PATH.'/vendor/autoload.php';
        if (file_exists($composer_path)) {
            require_once $composer_path;
        }

        \Dea\Config::setup();
        
        $config = \Dea\Config::get();

        \Dea\Controller\Test::setup();

	}
}