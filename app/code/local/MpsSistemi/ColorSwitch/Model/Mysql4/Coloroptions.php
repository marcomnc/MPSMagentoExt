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
class MpsSistemi_ColorSwitch_Model_Mysql4_Coloroptions extends Mage_Core_Model_Mysql4_Abstract
{
    
    protected function _construct()
    {
        $this->_init('mpsswitcher/coloroptions', 'entity_id');
    }

    
}

?>
