<?php
namespace Native5\Ui\Card\Page;

class Builder {
    private $_name;
    private $_cards;

    public function getName() {
        return $this->_name;
    }

    public function setName($name) {
        $this->_name = $name;
        return $this;
    }

    public function getCards() {
        return $this->_cards;
    }

    public function setCards($cards) {
        $this->_cards = $cards;
        return $this;
    }

    public function addCard(\Native5\Ui\Card $card) {
        $this->_cards[] = $card;
        return $this;
    }

    public function build() {
        return new \Native5\Ui\Card\Page($this);
    }

}

