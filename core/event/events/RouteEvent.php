<?php
namespace core\event\events;
use core\Config;
use core\event\Event as Event;
use core\service\Service;
use core\service\services\ValidatorService;


class RouteEvent extends Event {

    private $cfg     = null;
    private $host    = null;
    private $request = null;

    private $requestValidator = null;

    private $object = null;
    private $action = null;
    private $params = null;

    public function __construct() {
        $this->init();
    }

    private function init() {
        $this->cfg     = $this->getConfig();
        $this->host    = $this->cfg['host'];
        $this->request = $this->cfg['request'];
        $proceed = $this->getRequestValidator()
                        ->init($this->request)
                        ->validate();
        if ($proceed) {
            $request      = $this->trim($this->request);
            $this->params = $this->getParams($request);
            $this->object = $this->getObject($request);
            $this->action = $this->getAction($request);

            $object = 'routes\\' . $this->object;
            $this->object = new $object();
        }
    }

    private function getConfig() {
        return Config::global();
    }

    private function getRequestValidator() {
        if (is_null($this->requestValidator)) {
            $this->requestValidator = ValidatorService::get('request', Service::SERVICE);
            return $this->requestValidator;
        }
        return $this->requestValidator;
    }

    private function trim($request) {
        $request = strtok($request, '?');
        $request = ltrim($request, '/');
        $request = rtrim($request, '/');
        return $request;
    }

    private function getObject($request) {
        $object = explode('/', $request);
        $object = array_shift($object);
        return ucfirst($object) . 'Controller';
    }

    private function getAction($request) {
        $action = array_pop(explode('/', $request));
        return $action . 'Action';
    }

    private function getParams($request) {
        $params = explode('?', $request);
        if (is_array($params)) {
            $params = array_pop($params);
            return $params;
        }
    }

    public function trigger() {

        $object = $this->object;
        $action = $this->action;

        $object->$action();

        return parent::trigger();
    }

}