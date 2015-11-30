<?php
namespace Native5\Ui\Card;

interface DAO
{
    // Create OR Update if already present
    public function setCard($uid, $page, $name, $state = \Native5\Ui\Card\State::OPENED);

    // Read
    public function getPage($uid, $page);
    public function getCard($uid, $page, $name, $state = "%");

    // Delete
    public function deleteCard($uid, $page, $name, $state = "%");
    //public function deletePage($uid, $page);
}
