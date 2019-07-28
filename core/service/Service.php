<?php


namespace core\service;


use core\Config;
use core\service\services\ExceptionService;

class Service extends AbstractService {

    protected static $global = null;
    protected static $local  = null;

    const SERVICE = ['service' => []];

    public static function get($name, $options = null) {
        //получаем пользовательский и служебный конфиги для проверки на наличие classmap
        if (is_null(self::$global)) self::$global = Config::global();
        if (is_null(self::$local))  self::$local  = Config::local();
        if (!self::$global) {
            self::$global = [];
        }
        if (!self::$local)  {
            self::$local  = [];
        }

        /**
         * Если указаны дополнительные параметры для
         * служебных сервисов - выполняем сперва их,
         * затем пытаемся найти необходимый сервис
         *
         */
        if (array_key_exists('service', $options)) {
            foreach ($options['service'] as $actionType) {
                $action = self::getAction($actionType);
                self::doAction($action);
            }
            $instance = self::locate($name, self::$global['class_map']);
            if ($instance) {
                return new $instance();
            } else {
                self::throwServiceError($name);
            }
        }

        /**
         * Пытаемся найти пользовательский сервис,
         * при его отсутствии выбрасываем ошибку
         */
        $instance = self::locate($name, self::$local['class_map']);
        if ($instance) {
            return new $instance;
        } else {
            self::throwServiceError($name);
        }



    }

    private static function throwServiceError($name) {
        /**
         * Запрашивается сервис обработки ошибок
         *
         * @var $exceptionService ExceptionService
         */
        $exceptionService = Service::get('handler_service', ['service' => ['use_service_map']]);
        $exceptionHandler = $exceptionService::get('handler');
        $exceptionHandler->throw(NOT_EXISTING_SERVICE, [
            'name' => $name
        ]);
    }

    private static function locate($name, $classmap) {
        if (is_array($classmap)) {
            if (array_key_exists($name, $classmap)) {
                $location = $classmap[$name];
                if (class_exists($location)) {
                    return $location;
                }
                return false;
            }
            return false;
        }
        return false;
    }

    private static function doAction($action) {
        if (method_exists(Service::class, $action)) {
            Service::$action();
        }
    }

    private static function getAction($actionType) {
        $action = [
            'use_service_map' => 'overrideClassmap'
        ];
        return $action[$actionType];
    }

    protected static function overrideClassmap() {
        self::$global['class_map'] = self::serviceClassmap();
    }

    protected static function serviceClassmap() {
        return [
            'handler_service' => 'core\service\services\ExceptionService'
        ];
    }

}