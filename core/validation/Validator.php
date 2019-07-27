<?php


namespace core\validation;


class Validator extends AbstractValidator {

    private $result;

    public function init($value) {
        return $this;
    }

    public function validate() {
        return $this->result;
    }

    protected function setResult($result) {
        $this->result = $result;
    }

}