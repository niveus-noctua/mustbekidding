<?php

namespace core\validation\validators;


use core\validation\Validator;

class RequestValidator extends Validator {

    public function init($value) {
        return parent::init($value);
    }

    public function validate() {
        $this->setResult(true);
        return parent::validate();
    }

}