<?php

namespace Dea\App\Controller;

class Hello extends \Dea\Controller\CGI {

    static function setup() {
        var_dump('hello');
    }

    public function actionA() {
    	var_dump(func_get_args());
    }
}