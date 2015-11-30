<?php
namespace Native5\Ui\Card;

class Builder {
    private $_page;
    private $_name;
    private $_state;

    public function getPage() {
        return $this->_page;
    }

    public function setPage($page) {
        $this->_page = $page;
        return $this;
    }

    public function getName() {
        return $this->_name;
    }

    public function setName($name) {
        $this->_name = $name;
        return $this;
    }

    public function getState() {
        return $this->_state;
    }

    public function setState($state) {
        $this->_state = $state;
        return $this;
    }

    public function build() {
        return new \Native5\Ui\Card($this);
    }

}

