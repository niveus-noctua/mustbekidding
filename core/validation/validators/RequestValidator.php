<?php

namespace core\validation\validators;


use core\service\ServiceManager;
use core\validation\Validator;

class RequestValidator extends Validator {

    public function init($value) {
        return parent::init($value);
    }

    public function validate() {
        $sm = new ServiceManager();
        $exceptionService = $sm->get('exception_service');
        $this->setResult(['result' => true]);
        return parent::validate();
    }

}