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
        $config = include 'config/config.php';
        if (!is_null($config)) return $config;
    }

    /**
     * возвращает пользовательский
     * конфигурационный файл проекта
     *
     * @return array
     */
    public static function local() {
        $config = include './config/config.php';
        if (!is_null($config)) return $config;
    }

}