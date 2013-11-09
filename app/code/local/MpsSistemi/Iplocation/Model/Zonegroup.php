<?php

/**
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *  
 *
 * @category    
 * @package     
 * @copyright   Copyright (c) 2013 Mps Sistemi (http://www.mps-sistemi.it)
 * @author      MPS Sistemi S.a.s - Marco Mancinelli <marco.mancinelli@mps-sistemi.it>
 *
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
