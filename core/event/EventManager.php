<?php

namespace core\event;


use core\exception\ExceptionHandler;
use core\validation\validators\ParamValidator;

class EventManager {

    private $exceptionHandler = null;

    private $event      = null;
    private $parameters = null;
    private $paramValidator = null;

    private $validEvent = false;

    public function getEvent($parameters) {
        if (is_array($parameters)) {
            $this->parameters = $parameters;
            $this->validEvent = $proceed = $this->getParamValidator()
                            ->init($parameters)
                            ->validate();
            if ($proceed) {
                $this->event = $this->create();
                return $this->event;
            }
            $this->getExceptionHandler()->throw(NOT_EXISTING_EVENT, [
                'name' => $this->getEventName()
            ]);
        }
    }

    public function trigger($parameters = null) {

    }

    public function getEventName() {
        if ($this->validEvent) {
            return ucfirst($this->parameters['name']) . 'Event';
        }
        return '';
    }

    private function create() {
        $name     = $this->getEventName();
        $location = $this->getEventLocation();
        $event    = $location . $name;
        return new $event();
    }

    private function getParamValidator() {
        if (is_null($this->paramValidator)) {
            $this->paramValidator = new ParamValidator();
        }
        return $this->paramValidator;
    }

    private function getEventLocation() {
        if ($this->validEvent) {
            $serviceSign = $this->getParamValidator()->isService();
            $location    = 'events\\';
            if ($serviceSign) {
                $location = 'core\event\events\\';
            }
            return $location;
        }
    }

    private function getExceptionHandler() {
        if (is_null($this->exceptionHandler)) {
            $this->exceptionHandler = new ExceptionHandler();
        }
        return $this->exceptionHandler;
    }
}