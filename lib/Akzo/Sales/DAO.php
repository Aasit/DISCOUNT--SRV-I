<?php
namespace Akzo\Sales;

interface DAO
{
    // Read
    public function getSalesDataByDealerCodes($data);
    public function getSalesTargetsByDealerCodes($data);
    public function loadSalesDataFromDealerIDs($dealerIDs, $period);
    public function loadSalesDataFromDealer(\Akzo\Dealer $dealer, $period);
}