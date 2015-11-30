<?php
namespace Akzo\Scheme;
use \Respect\Validation\Validator as v;

class DAOImpl extends \Native5\Db\BaseDbDAO implements \Akzo\Scheme\DAO
{
    public function __construct() {
        parent::__construct();
    }

    public function loadSchemeByCode($schemeId) {
        try {
            return 
                \Akzo\Scheme
                    ::with(
                        array(
                            'initiator',
                            'reviewer',
                            'approver'
                        )
                    )
                    ->where('code', 'like', $schemeId)
                    ->get()
                    ->first();
                    
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }

    }

    public function getInitiatedScheme(\Akzo\User $user, $schemeId) {
        try {
            return 
                $user
                    ->initiatedSchemes()
                    ->with(
                        array(
                            'initiator',
                            'reviewer',
                            'approver'
                        )
                    )
                    ->where('code', 'like', $schemeId)
                    ->get()
                    ->first();
                    
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }

    }

    public function getAllInitiatedSchemes(\Akzo\User $user, $schemeState = \Akzo\Scheme\State::STAGED) {
        $GLOBALS['logger']->info("STATE: ".PRINT_R($schemeState,1));
        try {
            return 
                $user
                    ->initiatedSchemes()
                    ->with(
                        array(
                            'initiator',
                            'reviewer',
                            'approver'
                        )
                    )
                    ->where('state', 'not like', \Akzo\Scheme\State::STAGED)
                    ->orderBy('created_at', 'DESC')
                    ->get();
                    
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function getAllDraftSchemes(\Akzo\User $user) {
        try {
            return 
                $user
                    ->initiatedSchemes()
                    ->with(
                        array(
                            'initiator',
                            'reviewer',
                            'approver'
                        )
                    )
                    ->where('state', 'like', \Akzo\Scheme\State::STAGED)
                    ->orderBy('created_at', 'DESC')
                    ->get();
                    
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function getToBeReviewedScheme(\Akzo\User $user, $schemeId) {
        try {
            return 
                $user
                    ->toBeReviewedSchemes()
                    ->where('code', 'like', $schemeId)
                    ->orderBy('created_at', 'DESC')
                    ->get()
                    ->first();
                    
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function getAllToBeReviewedSchemes(\Akzo\User $user, $schemeState = \Akzo\Scheme\State::STAGED) {
        try {
            return 
                $user
                    ->toBeReviewedSchemes()
                    ->with(
                        array(
                            'initiator',
                            'reviewer',
                            'approver'
                        )
                    )
                    ->where('state', 'not like', \Akzo\Scheme\State::STAGED)
                    ->orderBy('created_at', 'DESC')
                    ->get();
                    
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function getReviewedByState(\Akzo\User $user, $schemeState = \Akzo\Scheme\State::STAGED) {
        try {
            return 
                $user
                    ->toBeReviewedSchemes()
                    ->with(
                        array(
                            'initiator',
                            'reviewer',
                            'approver'
                        )
                    )
                    ->where('state', 'like', $schemeState)
                    ->orderBy('created_at', 'DESC')
                    ->get();
                    
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }
    public function getinitiatedByState(\Akzo\User $user, $schemeState = \Akzo\Scheme\State::STAGED) {
        try {
            return 
                $user
                    ->initiatedSchemes()
                    ->with(
                        array(
                            'initiator',
                            'reviewer',
                            'approver'
                        )
                    )
                    ->where('state', 'like', $schemeState)
                    ->orderBy('created_at', 'DESC')
                    ->get();
                    
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }
    public function getApprovedByState(\Akzo\User $user, $schemeState = \Akzo\Scheme\State::STAGED) {
        try {
            return 
                $user
                    ->toBeApprovedSchemes()
                    ->with(
                        array(
                            'initiator',
                            'reviewer',
                            'approver'
                        )
                    )
                    ->where('state', 'like', $schemeState)
                    ->orderBy('created_at', 'DESC')
                    ->get();
                    
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function getToBeApprovedScheme(\Akzo\User $user, $schemeId) {
        try {
            return 
                $user
                    ->toBeApprovedSchemes()
                    ->where('code', 'like', $schemeId)
                    ->orderBy('created_at', 'DESC')
                    ->get()
                    ->first();
                    
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function getAllToBeApprovedSchemes(\Akzo\User $user, $schemeState = \Akzo\Scheme\State::STAGED) {
        try {
            return 
                $user
                    ->toBeApprovedSchemes()
                    ->with(
                        array(
                            'initiator',
                            'reviewer',
                            'approver'
                        )
                    )
                    ->where('state', 'not like', \Akzo\Scheme\State::STAGED)
                    ->orderBy('created_at', 'DESC')
                    ->get();
                    
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function getToBePayoutApprovedScheme(\Akzo\User $user, $schemeId) {
        try {
            return 
                $user
                    ->toBePayoutApprovedSchemes()
                    ->where('code', 'like', $schemeId)
                    ->orderBy('created_at', 'DESC')
                    ->get()
                    ->first();
                    
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function getAllToBePayoutApprovedSchemes(\Akzo\User $user, $schemeState = \Akzo\Scheme\State::STAGED) {
        try {
            return 
                $user
                    ->toBePayoutApprovedSchemes()
                    ->with(
                        array(
                            'initiator',
                            'reviewer',
                            'approver'
                        )
                    )
                    ->where('state', 'not like', \Akzo\Scheme\State::STAGED)
                    ->orderBy('created_at', 'DESC')
                    ->get();
                    
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function addSchemeTransition(\Akzo\User $user, \Akzo\Scheme $scheme, $stateTransition, $comments) {
        try {
            $transition = new \Akzo\Scheme\Transition;
            $transition->scheme()->associate($scheme);
            $transition->user()->associate($user);
            $transition->type = $stateTransition;
            $transition->comments = $comments;

            return $transition->save();
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }

    public function loadSchemeTransitions(\Akzo\Scheme $scheme) {
        try {
            return $scheme->transitions->all();
        } catch (\PDOException $e) {
            $GLOBALS['logger']->info("Error: ".$e->getMessage());
            throw new \InvalidArgumentException(
                \Akzo\Product\ErrorMessages::PROCESS_ERROR, 
                \Native5\Core\Http\StatusCodes::BAD_REQUEST
            );
        }
    }
}
