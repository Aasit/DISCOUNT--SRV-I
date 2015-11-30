<?php
namespace Native5\Ui\Card;

class Page {
    private $_name;
    private $_cards;

    public function __construct(\Native5\Ui\Card\Page\Builder $builder) {
        $this->_name = $builder->getName();
        $this->_cards = $builder->getCards();
    }

    public static function createBuilder() {
        return new \Native5\Ui\Card\Page\Builder();
    }

    public function getName() {
        return $this->_name;
    }

    public function getCards() {
        return $this->_cards;
    }

}

