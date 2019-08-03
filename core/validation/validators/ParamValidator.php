<?php

namespace core\validation\validators;

use core\service\ServiceManager;
use core\validation\Validator;

/**
 * TODO: Валидатор должен:
 *          - валидировать наличие обязательных параметров
 *          - валидировать существование класса ивента
 *          - валидация класса ивента должна происходить в зависимости
 *            от того принадлежит ли ивент пользователю, либо же является
 *            служебным
 */

class ParamValidator extends Validator {

    public function init($value) {

        return parent::init($value);
    }

    //TODO: пока явно передаю true для проверки,
    //      в дальнейшем изменить
    public function validate() {

        $sm = new ServiceManager();
        $exceptionService = $sm->get('exception_service');
        $this->setResult(['result' => true]);

        return parent::validate();
    }

    //TODO: пока возвращает явно true,
    //      должна быть проверка есть ли в параметрах
    //      ключ массива 'service'

    /**
     * Возвращает true если ивент является
     * служебным
     *
     * @return bool
     */
    public function isService() {
        return true;
    }

}