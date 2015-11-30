<?php
namespace Native5\Ui\Card;

class Service {
    private $_data;
    private $_dao;

    /**
     * 
     * @var Singleton
     */
    private static $instance;

    private function __construct() {
        global $logger;
        $this->_data = array();
        $this->_dao = new \Akzo\Reminder\DAOImpl();
    }

    public static function getInstance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     *
     * Insert reminder into Database
     */
    public function saveReminder($uid, $guid, $title, $desc, $dateStr) {
        if(!$this->_valid($title, $desc, $dateStr)) return false;

        $reminder = new \Akzo\Reminder();
        $reminder->setUser($uid);
        $reminder->setGUID($guid);
        $reminder->setTitle($title);
        $reminder->setDetails($desc);

        try {
            $reminder->setScheduled($dateStr);
        } catch(Exception $e) {
            $logger->debug('Cannot save reminder : Invalid Date format supplied');
            return false;
        }
        return $this->_dao->saveReminder($reminder);
    }

    public function deleteReminder($uid, $id) {
        return $this->_dao->deleteReminder($uid, $id);
    }

    public function findRemindersForUser($uid) {
        return $this->_dao->getReminders($uid);
    }

    private function _valid($title, $desc, $date) {
        return true;
    }
}

