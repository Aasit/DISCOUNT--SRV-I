<?php
namespace Native5\Ui\Card;

use \Respect\Validation\Validator as v;

class DAOImpl extends \Native5\Db\BaseDbDAO implements \Native5\Ui\Card\DAO
{
    const QUERIES_FILE = 'queries.cfg.yml';
    private $_uiConfig;

    public function __construct() {
        parent::__construct();
        $this->_uiConfig = $GLOBALS['app']->getConfiguration()->getRawConfiguration('ui');
        // Load the sql queries file
        parent::loadQueries(__DIR__.DIRECTORY_SEPARATOR.self::QUERIES_FILE);
    }

    public function setCard($uid, $page, $name, $state = \Native5\Ui\Card\State::OPENED)
    {
        $valArr = array(
            ':UID' => $uid,
            ':NAME' => $name,
            ':PAGE' => $page,
            ':STATE1' => $state,
            ':STATE2' => $state
        );

        if (!($this->_validateEntries($valArr))) {
            return false;
        }

        // insert, if present update - Handled using unique constraint on ( uid, name, page )
        // FIXME: Using raw queries. However this is the most optimized method provided by mysql
        return self::$db->connection()->statement(
            $this->queries['Insert or Update Card'],
            $valArr
        );
    }

    public function getPage($uid, $page)
    {
        $valArr = array(
            ':UID' => $uid,
            ':PAGE' => $page,
            ':NAME' => ($name = "%"),
            ':STATE' => ($state = "%")
        );

        if (!($this->_validateEntries($valArr))) {
            return false;
        }

        $cardsCollection = $this->_loadCardsCommon($uid, $page, $name, $state);
        
        if ($cardsCollection->isEmpty()) {
            return array();
        }

        return $cardsCollection->all();
    }

    public function getCard($uid, $page, $name, $state = '%')
    {
        $valArr = array(
            ':UID' => $uid,
            ':PAGE' => $page,
            ':NAME' => $name,
            ':STATE' => $state
        );
        if (!$this->_validateEntries($valArr)) {
            return false;
        }

        $cardsCollection = $this->_loadCardsCommon($uid, $page, $name, $state);
        
        if ($cardsCollection->isEmpty()) {
            return array();
        }

        return $cardsCollection->first();
    }

    public function deleteCard($uid, $page, $name, $state = "%")
    {
        $valArr = array(
            ':UID' => $uid,
            ':PAGE' => $page,
            ':NAME' => $name,
            ':STATE' => $state
        );

        if (!($this->_validateEntries($valArr))) {
            return false;
        }

        \Akzo\User::where('code', 'like', $uid)
            ->first()
            ->cards()
                ->where('page', 'like', $page, 'and')
                ->where('name', 'like', $name, 'and')
                ->where('state', 'like', $state)
                ->delete();

        return true;
    }

    // ************ Private Functions Follow ************* //

    private function _loadCardsCommon($uid, $page, $name, $state)
    {
        return
            \Akzo\User::where('code', 'like', $uid)
                ->first()
                ->cards()
                    ->where('page', 'like', $page, 'and')
                    ->where('name', 'like', $name, 'and')
                    ->where('state', 'like', $state)
                    ->get();
    }

    // TODO: Should throw exception - currently catches it and return false / null
    private function _validateEntries($valueArr)
    {
        $validUid = true;
        $validPage = true;
        $validName = true;
        $validState = true;
        $minNumericVal = $this->_uiConfig["card"]["minNumericLength"];
        $maxNumericVal = $this->_uiConfig["card"]["maxNumericLength"];
        $minStrVal = $this->_uiConfig["card"]["minStringLength"];
        $maxStrVal = $this->_uiConfig["card"]["maxStringLength"];

        $validateNumber = v::numeric()->noWhitespace()->length($minNumericVal, $maxNumericVal);
        $validateString = v::string()->noWhitespace()->length($minStrVal, $maxStrVal);

        if (array_key_exists(":UID", $valueArr) && $valueArr[":UID"] !== "%") {
            $validUid = $validateNumber->validate($valueArr[":UID"]);
        }

        if (!$validUid) {
            throw new \InvalidArgumentException(
                'Invalid UID',
                \Native5\Core\Http\StatusCodes::NOT_ACCEPTABLE
            );
        }

        if (array_key_exists(":PAGE", $valueArr) && $valueArr[":PAGE"] !== "%") {
            $validPage = $validateString->validate($valueArr[":PAGE"]);
        }

        if (!$validPage) {
            throw new \InvalidArgumentException(
                'Invalid Page',
                \Native5\Core\Http\StatusCodes::NOT_ACCEPTABLE
            );
        }

        if (array_key_exists(":NAME", $valueArr) && $valueArr[":NAME"] !== "%") {
            $validName = $validateString->validate($valueArr[":NAME"]);
        }

        if (!$validName) {
            throw new \InvalidArgumentException(
                'Invalid Name',
                \Native5\Core\Http\StatusCodes::NOT_ACCEPTABLE
            );
        }

        if (array_key_exists(":STATE1", $valueArr) && $valueArr[":STATE1"] !== "%") {
            $validState = $validateString->validate($valueArr[":STATE1"]);
        } elseif (array_key_exists(":STATE", $valueArr) && $valueArr[":STATE"] !== "%") {
            $validState = $validateString->validate($valueArr[":STATE"]);
        }

        if (!$validState) {
            throw new \InvalidArgumentException(
                'Invalid State',
                \Native5\Core\Http\StatusCodes::NOT_ACCEPTABLE
            );
        }

        return true;
    }
}
