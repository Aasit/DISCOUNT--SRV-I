<?php
namespace Akzo\Geography;

interface DAO
{
    // Read
    public function getZonesInRegion(\Akzo\Geography\Region $region);
    public function getDepotsInZone(\Akzo\Geography\Zone $zone);
    public function getDealersInDepot(\Akzo\Geography\Depot $depot);
    public function getDealerIDsUnderZM(\Akzo\User\ZM $zm);
    public function getDealersInZone(\Akzo\Geography\Zone $zone, $token);
    public function getDealersInRegion(\Akzo\Geography\Region $region, $token);
    public function getAllRegions();
    public function searchRegions($token);
    public function getAllZones();
    public function searchZones($token);
    public function getAllDepots();    
    public function searchDepots($token);
    public function getAllDealers();
    public function getDealerByName($name);
    public function getDealerByCode($code);
    public function getZoneByName($name);
    public function getRegionByName($name);
    public function getdepotByCode($code);
}