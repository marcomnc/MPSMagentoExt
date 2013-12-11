<pre>
<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
  
define("MAGE_BASE_DIR", ".".DIRECTORY_SEPARATOR);

define("BASE_STORE", 1);
require_once(MAGE_BASE_DIR.'app/Mage.php'); //Path to Magento
umask(0);
Mage::app();

$read = Mage::getSingleton('core/resource')->getConnection('core_read');
$write = Mage::getSingleton('core/resource')->getConnection('core_write');

/*$r = $write->insert('catalog_product_entity', 
                        array('entity_type_id'     => 4,
                              'attribute_set_id'   => 4,
                              'type_id'            => 'configurable',
                              'sku'                => 'cippalippa',
                              'has_options'        => 1,
                              'required_options'   => 1));
                              
print_r($r);
*/

$cat = Mage::getModel("catalog/category")->getCollection()
                            ->AddAttributeToFilter("name", $name)
                            ->AddFieldToFilter('parent_id', $father);

print_r($cat->getSelect()->__toString());