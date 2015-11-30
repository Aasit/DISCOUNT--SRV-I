<?php
namespace Akzo\Scheme;

use Akzo\Order\DAOImpl as OrderDAO;
use Akzo\Order\StagingDataStore;
use Akzo\Order\SapTextFileTranslator;

use Akzo\Order\FTP\FTPConfig;
use Akzo\Order\FTP\FTPConfigFactory;
use Akzo\Order\FTP\FTPConnector;

class StateMachine extends \Finite\StateMachine\StateMachine {
    protected $_scheme;

    public function __construct(\Akzo\Scheme $scheme) {
        $this->_scheme = $scheme;
        parent::__construct($this->_scheme);

        $stateMachineDescription = array(
            'class'       => '\Akzo\Scheme',
            'states'      => array(
                \Akzo\Scheme\State::CREATED => array(
                    'type'       => \Finite\State\StateInterface::TYPE_INITIAL,
                    'properties' => array('deletable' => true, 'editable' => true)
                ),
                \Akzo\Scheme\State::STAGED => array(
                    'type'       => \Finite\State\StateInterface::TYPE_NORMAL,
                    'properties' => array('deletable' => true, 'editable' => true)
                ),
                \Akzo\Scheme\State::TO_BE_REVIEWED => array(
                    'type'       => \Finite\State\StateInterface::TYPE_NORMAL,
                    'properties' => array('deletable' => false, 'editable' => false)
                ),
                \Akzo\Scheme\State::TO_BE_APPROVED => array(
                    'type'       => \Finite\State\StateInterface::TYPE_NORMAL,
                    'properties' => array('deletable' => false, 'editable' => false)
                ),
                \Akzo\Scheme\State::APPROVED => array(
                    'type'       => \Finite\State\StateInterface::TYPE_FINAL,
                    'properties' => array('deletable' => false, 'editable' => false)
                ),
                \Akzo\Scheme\State::UPDATE_REQUESTED => array(
                    'type'       => \Finite\State\StateInterface::TYPE_NORMAL,
                    'properties' => array('deletable' => true, 'editable' => true)
                )
            ),
            'transitions' => array(
                \Akzo\Scheme\StateTransition::STAGE_SCHEME => array(
                    'from' => array(\Akzo\Scheme\State::CREATED),
                    'to' => \Akzo\Scheme\State::STAGED
                ),
                \Akzo\Scheme\StateTransition::UPDATE_STAGED_SCHEME => array(
                    'from' => array(\Akzo\Scheme\State::STAGED),
                    'to' => \Akzo\Scheme\State::STAGED
                ),
                \Akzo\Scheme\StateTransition::INITIATE_CREATED_SCHEME => array(
                    'from' => array(\Akzo\Scheme\State::CREATED),
                    'to' => \Akzo\Scheme\State::TO_BE_REVIEWED
                ),
                \Akzo\Scheme\StateTransition::INITIATE_STAGED_SCHEME => array(
                    'from' => array(\Akzo\Scheme\State::STAGED),
                    'to' => \Akzo\Scheme\State::TO_BE_REVIEWED
                ),
                \Akzo\Scheme\StateTransition::REVIEW_SCHEME  => array(
                    'from' => array(\Akzo\Scheme\State::TO_BE_REVIEWED),
                    'to' => \Akzo\Scheme\State::TO_BE_APPROVED
                ),
                \Akzo\Scheme\StateTransition::APPROVE_SCHEME  => array(
                    'from' => array(\Akzo\Scheme\State::TO_BE_APPROVED),
                    'to' => \Akzo\Scheme\State::APPROVED
                ),
                \Akzo\Scheme\StateTransition::REQUEST_SCHEME_UPDATE => array(
                    'from' => array(
                        \Akzo\Scheme\State::TO_BE_REVIEWED,
                        \Akzo\Scheme\State::TO_BE_APPROVED
                    ),
                    'to' => \Akzo\Scheme\State::UPDATE_REQUESTED
                ),
                \Akzo\Scheme\StateTransition::REQUEST_SCHEME_REVIEW  => array(
                    'from' => array(\Akzo\Scheme\State::TO_BE_APPROVED),
                    'to' => \Akzo\Scheme\State::TO_BE_REVIEWED
                ),
                \Akzo\Scheme\StateTransition::UPDATE_SCHEME  => array(
                    'from' => array(\Akzo\Scheme\State::UPDATE_REQUESTED),
                    'to' => \Akzo\Scheme\State::UPDATE_REQUESTED
                ),
                \Akzo\Scheme\StateTransition::INITIATE_UPDATED_SCHEME  => array(
                    'from' => array(\Akzo\Scheme\State::UPDATE_REQUESTED),
                    'to' => \Akzo\Scheme\State::TO_BE_REVIEWED
                ),
                \Akzo\Scheme\StateTransition::EDIT_APPROVED_SCHEME  => array(
                    'from' => array(\Akzo\Scheme\State::APPROVED),
                    'to' => \Akzo\Scheme\State::UPDATE_REQUESTED
                )
            ),
            'callbacks' => array(
                'after' => array(
                    array(
                        'from' => \Akzo\Scheme\State::CREATED,
                        'to' => \Akzo\Scheme\State::STAGED,
                        'do' => function($scheme, $event) {
                            \Akzo\Scheme\Service::getInstance()->createSaveScheme($scheme);
                        }
                    ),
                    array(
                        'from' => \Akzo\Scheme\State::STAGED,
                        'to' => \Akzo\Scheme\State::STAGED,
                        'do' => function($scheme, $event) {
                            \Akzo\Scheme\Service::getInstance()->updateSaveScheme($scheme);
                        }
                    ),
                    array(
                        'from' => \Akzo\Scheme\State::UPDATE_REQUESTED,
                        'to' => \Akzo\Scheme\State::UPDATE_REQUESTED,
                        'do' => function($scheme, $event) {
                            \Akzo\Scheme\Service::getInstance()->updateSaveScheme($scheme);
                        }
                    ),
                    array(
                        'from' => \Akzo\Scheme\State::CREATED,
                        'to' => \Akzo\Scheme\State::TO_BE_REVIEWED,
                        'do' => function($scheme, $event) {
                            \Akzo\Scheme\Service::getInstance()->createSaveScheme($scheme);

                            // TODO: Merge this will the below savePublicTransition function
                            // Send notification to initiator, reviewer, approver for sending request for re-review of scheme
                            \Akzo\Scheme\Notifier::sendNotification($scheme, $event->getTransition());

                            // TODO: Merge this will the above sendNotification function
                            // Save the state transition
                            \Akzo\Scheme\Service::getInstance()->savePublicTransition($scheme, $event->getTransition());
                        }
                    ),
                    array(
                        'from' => \Akzo\Scheme\State::STAGED,
                        'to' => \Akzo\Scheme\State::TO_BE_REVIEWED,
                        'do' => function($scheme, $event) {
                            \Akzo\Scheme\Service::getInstance()->updateSaveScheme($scheme);

                            // TODO: Merge this will the below savePublicTransition function
                            // Send notification to initiator, reviewer, approver for sending request for re-review of scheme
                            \Akzo\Scheme\Notifier::sendNotification($scheme, $event->getTransition());

                            // TODO: Merge this will the above sendNotification function
                            // Save the state transition
                            \Akzo\Scheme\Service::getInstance()->savePublicTransition($scheme, $event->getTransition());
                        }
                    ),
                    array(
                        'from' => \Akzo\Scheme\State::UPDATE_REQUESTED,
                        'to' => \Akzo\Scheme\State::TO_BE_REVIEWED,
                        'do' => function($scheme, $event) {
                            \Akzo\Scheme\Service::getInstance()->updateSaveScheme($scheme);

                            // TODO: Merge this will the below savePublicTransition function
                            // Send notification to initiator, reviewer, approver for sending request for re-review of scheme
                            \Akzo\Scheme\Notifier::sendNotification($scheme, $event->getTransition());

                            // TODO: Merge this will the above sendNotification function
                            // Save the state transition
                            \Akzo\Scheme\Service::getInstance()->savePublicTransition($scheme, $event->getTransition());
                        }
                    ),
                    array(
                        'from' => \Akzo\Scheme\State::TO_BE_REVIEWED,
                        'to' => \Akzo\Scheme\State::UPDATE_REQUESTED,
                        'do' => function($scheme, $event) {
                            // Just update the state of scheme in the database
                            $scheme->save();

                            // TODO: Merge this will the below savePublicTransition function
                            // Send notification to initiator, reviewer, approver for sending request for re-review of scheme
                            \Akzo\Scheme\Notifier::sendNotification($scheme, $event->getTransition());

                            // TODO: Merge this will the above sendNotification function
                            // Save the state transition
                            \Akzo\Scheme\Service::getInstance()->savePublicTransition($scheme, $event->getTransition());
                        }
                    ),
                    array(
                        'from' => \Akzo\Scheme\State::TO_BE_REVIEWED,
                        'to' => \Akzo\Scheme\State::TO_BE_APPROVED,
                        'do' => function($scheme, $event) {
                            // Just update the state of scheme in the database
                            $scheme->save();

                            // TODO: Merge this will the below savePublicTransition function
                            // Send notification to initiator, reviewer, approver for sending request for re-review of scheme
                            \Akzo\Scheme\Notifier::sendNotification($scheme, $event->getTransition());

                            // TODO: Merge this will the above sendNotification function
                            // Save the state transition
                            \Akzo\Scheme\Service::getInstance()->savePublicTransition($scheme, $event->getTransition());
                        }
                    ),
                    array(
                        'from' => \Akzo\Scheme\State::TO_BE_APPROVED,
                        'to' => \Akzo\Scheme\State::UPDATE_REQUESTED,
                        'do' => function($scheme, $event) {
                            // Just update the state of scheme in the database
                            $scheme->save();

                            // TODO: Merge this will the below savePublicTransition function
                            // Send notification to initiator, reviewer, approver for sending request for re-review of scheme
                            \Akzo\Scheme\Notifier::sendNotification($scheme, $event->getTransition());

                            // TODO: Merge this will the above sendNotification function
                            // Save the state transition
                            \Akzo\Scheme\Service::getInstance()->savePublicTransition($scheme, $event->getTransition());
                        }
                    ),
                    array(
                        'from' => \Akzo\Scheme\State::TO_BE_APPROVED,
                        'to' => \Akzo\Scheme\State::TO_BE_REVIEWED,
                        'do' => function($scheme, $event) {
                            // Just update the state of scheme in the database
                            $scheme->save();

                            // TODO: Merge this will the below savePublicTransition function
                            // Send notification to initiator, reviewer, approver for sending request for re-review of scheme
                            \Akzo\Scheme\Notifier::sendNotification($scheme, $event->getTransition());

                            // TODO: Merge this will the above sendNotification function
                            // Save the state transition
                            \Akzo\Scheme\Service::getInstance()->savePublicTransition($scheme, $event->getTransition());
                        }
                    ),
                    array(
                        'from' => \Akzo\Scheme\State::TO_BE_APPROVED,
                        'to' => \Akzo\Scheme\State::APPROVED,
                        'do' => function($scheme, $event) {
                            // Just update the state of scheme in the database
                            $scheme->save();
                            $schemeID = $scheme->code;
                            $schemeService = \Akzo\Scheme\Service::getInstance();
                            $schemeService->initiatePDFCreation($schemeID);

                            // Send notification to initiator, reviewer, approver for intimating that scheme has been approved
                            \Akzo\Scheme\Notifier::sendNotification($scheme, $event->getTransition());

                            // TODO: Merge this will the sendNotification function
                            // Save the state transition
                            \Akzo\Scheme\Service::getInstance()->savePublicTransition($scheme, $event->getTransition());
                        }
                    ),
                    array(
                        'from' => \Akzo\Scheme\State::APPROVED,
                        'to' => \Akzo\Scheme\State::UPDATE_REQUESTED,
                        'do' => function($scheme, $event) {
                            // Just update the state of scheme in the database
                            $scheme->save();

                            // TODO: Merge this will the below savePublicTransition function
                            // Send notification to initiator, reviewer, approver for sending request for re-review of scheme
                            \Akzo\Scheme\Notifier::sendNotification($scheme, $event->getTransition());

                            // TODO: Merge this will the above sendNotification function
                            // Save the state transition
                            \Akzo\Scheme\Service::getInstance()->savePublicTransition($scheme, $event->getTransition());
                        }
                    )
                )
            )
        );

        $loader = new \Finite\Loader\ArrayLoader($stateMachineDescription);
        $loader->load($this);
        $this->initialize();
    }

}

