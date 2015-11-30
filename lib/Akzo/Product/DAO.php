<?php
namespace Akzo\Product;

interface DAO
{
    // Read
    public function getProductByName($name);
    public function getProductByCode($code);
    public function getAllProducts();
    public function getSubBrandByName($name);
    public function getSubBrandByCode($code);
    public function getAllSubBrands();
    public function getProductsFromSubBrand(\Akzo\Product\SubBrand $subBrand);
    public function getAllClusters();
    public function getProductsFromCluster(\Akzo\Product\Cluster $cluster);
    public function getAllGroups();
    public function searchClusters($token);
    public function searchSubBrands($token);
    public function searchGroups($token);
    public function searchProducts($token);
    public function getSubBrandsFromCluster($token);
    public function getGroupsFromSubbrand($token);
    public function getProductsFromGroup($token);

}
