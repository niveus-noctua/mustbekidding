<?php


namespace core;


class Config {

    /**
     * возвращает служебный
     * конфигурационный файл проекта
     *
     *
     * @return array
     */
    public static function global() {
        $config = require_once 'config/config.php';
        if ($config) return $config;
    }

    /**
     * возвращает пользовательский
     * конфигурационный файл проекта
     *
     * @return array
     */
    public static function local() {
        $config = require_once './config/config.php';
        if ($config) return $config;
    }

}