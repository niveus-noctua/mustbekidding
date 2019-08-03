<?php

namespace module\application\controller;

use core\controller\AbstractController;

class IndexController extends AbstractController {

    public function indexAction() {
        echo 'Привет из пользовательского тестового контроллера';
    }

}