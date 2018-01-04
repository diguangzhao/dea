<?php

namespace Dea\App\Controller;

class Hello extends \Dea\Controller\CGI\Base {

    public function __index($params = null) {
    	var_dump('__index');
    	return 123;
    }

    public function actionA() {
    	return V('test');

    }
}