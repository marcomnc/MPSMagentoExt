<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Type
 *
 * @author doctor
 */
class MpsSistemi_Catalog_Model_Adminhtml_System_Source_Catalog_Product_Type  
{
    
    public function toOptionArray()
    {
         $types[] = array("value" => "", "label" => "");
         
        foreach (Mage::getSingleton('catalog/product_type')->getOptionArray() as $k=>$v) {
           $types[] = array("value" => "$k", "label" => "$v");
        }
        
        return $types;
    }
}
