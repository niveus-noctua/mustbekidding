<?php

namespace core\event;

use core\exception\ExceptionHandler;
use core\validation\validators\ParamValidator;

class EventManager {

    private $exceptionHandler = null;

    /**
     * @var Event $event
     */
    private $event      = null;
    private $parameters = null;
    private $paramValidator = null;

    private $validEvent = false;
    private $canTrigger = false;

    public function getEvent($parameters) {
        if (is_array($parameters)) {
            $this->parameters = $parameters;
            $this->validEvent = $proceed = $this->getParamValidator()
                            ->init($parameters)
                            ->validate();
            if ($proceed) {
                $this->event = $this->create();
                $this->canTrigger = true;
                return $this;
            }
            $this->getExceptionHandler()->throw(NOT_EXISTING_EVENT, [
                'name' => $this->getEventName()
            ]);
        }
    }

    public function trigger() {
        if ($this->canTrigger) {
            $this->event->trigger();
        }
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