<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Zone
 *
 * @author marcoma
 */
class  MpsSistemi_Iplocation_Model_Zonegroup extends Mage_Core_Model_Abstract
{
    
    protected function _construct()
    {        
        $this->_init('mpslocation/zonegroup');
    }
    
    public function getId() {
        return $this->getEntityId();
    }
    
    public function _beforeDelete() {
        
        $zone = Mage::getModel('mpslocation/zone')
                        ->getCollection()
                        ->addAttributeTofilter('group_id', $this->getId());
        foreach ($zone as $z) {
            Mage::throwException(Mage::Helper('mpslocation')->__('Ci sono zone collegate al gruppo'));
        }
        return $this;
    }
    
    public function getName() {
        return $this->getResource()->getName();
    }
    
    public function setName($object) {
        $this->getResource()->setName($object);
    }
}

?>
