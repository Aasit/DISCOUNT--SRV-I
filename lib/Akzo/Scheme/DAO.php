<?php
namespace Akzo\Scheme;

interface DAO
{
    //public function saveScheme(\Akzo\User $user, $schemeJson, $schemeId, $schemeState = \Akzo\Scheme\State::STAGED);

    public function loadSchemeByCode($schemeId);

    public function getAllDraftSchemes(\Akzo\User $user);

    public function getInitiatedScheme(\Akzo\User $user, $schemeId);
    public function getAllInitiatedSchemes(\Akzo\User $user, $schemeState = \Akzo\Scheme\State::STAGED);

    public function getToBeReviewedScheme(\Akzo\User $user, $schemeId);
    public function getAllToBeReviewedSchemes(\Akzo\User $user, $schemeState = \Akzo\Scheme\State::STAGED);

    public function getToBeApprovedScheme(\Akzo\User $user, $schemeId);
    public function getAllToBeApprovedSchemes(\Akzo\User $user, $schemeState = \Akzo\Scheme\State::STAGED);

    public function getToBePayoutApprovedScheme(\Akzo\User $user, $schemeId);
    public function getAllToBePayoutApprovedSchemes(\Akzo\User $user, $schemeState = \Akzo\Scheme\State::STAGED);

    public function getReviewedByState(\Akzo\User $user, $schemeState = \Akzo\Scheme\State::STAGED);
    public function getinitiatedByState(\Akzo\User $user, $schemeState = \Akzo\Scheme\State::STAGED);
    public function getApprovedByState(\Akzo\User $user, $schemeState = \Akzo\Scheme\State::STAGED);
    

}
