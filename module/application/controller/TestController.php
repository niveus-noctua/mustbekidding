<?php


namespace module\application\controller;


class TestController {

    public function testAction() {
        $html = "
            <div align='center' style='padding-top: 100px'>
                <a href='move' style='text-decoration: none'>
                    <input type='button' value='Переходи'>
                </a>
            </div>
        ";
        echo $html;
    }

    public function moveAction() {
        $html = "
            <div align='center' style='padding-top: 100px'>
                <a href='test' style='text-decoration: none'>
                    <input type='button' value='А теперь обратно'>
                </a>
            </div>
        ";
        echo $html;
    }

}