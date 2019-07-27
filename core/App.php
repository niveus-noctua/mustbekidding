<?php

namespace core;

use core\router\Router as Router;


class App {

    private $options = null;

    /**
     * @var Router $router
     */
    private $router  = null;

    public function init($options = null) {
        $this->options = $options;
        $this->router  = new Router();
        return $this;
    }

    public function run() {
        $this->router->process();
    }

}