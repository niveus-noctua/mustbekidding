<?php


namespace core\event;


class Event extends AbstractEvent {

    private $action = null;

    public function trigger() {
        if (is_null($this->action)) {
            return;
        }
        //if ()
    }

}