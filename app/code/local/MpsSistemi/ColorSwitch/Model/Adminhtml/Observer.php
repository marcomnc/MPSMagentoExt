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
class MpsSistemi_ColorSwitch_Model_Adminhtml_Observer {
    
    /**
     * Salvataggio 
     * @param type $observer
     */
    public function on_attribute_after_save($observer) {
        
       $data = $observer->getAttribute()->getData();

        foreach ($data['option']['value'] as $value => $val) {
            
            if (!is_numeric($value)) {
                //new record
                continue;
            }

            //Controllo se il record è stato cancellato            
            if (isset($data['option']['delete'][$value]) && $data['option']['delete'][$value] == 1) {
                $model = Mage::getModel('mpsswitcher/coloroptions')->Load($value, 'option_id');
                if ($model->getId() > 0) {
                    $model->delete();
                }
            } else {

		$_fileName = "";                
                if (isset($_FILES['filename']['name'][$value]) && $_FILES['filename']['name'][$value] != "") {
                    try {
                        $_fileName = "";
                        $uploader = new Varien_File_Uploader("filename[$value]");

                        $uploader->setAllowedExtensions(array('jpg'));
                        $uploader->setAllowRenameFiles(false);
                        $uploader->setFilesDispersion(false);

                        $result = $uploader->save(Mage::getModel('mpsswitcher/coloroptions')->getUploadDir(), $_FILES['filename']['name'][$value] );
                        
                        $_fileName = $result['file'];

                    } catch (Exception $ex) {
                        Mage::getSingleton('adminhtml/session')
                                ->addError(Mage::helper('mpsswitcher')->__(
                                        'Errore in fase di Memorizzazione del file ' . $_FILES['filename']['name'][$value]) ."\n" . 
                                        $ex->getMessage());
                    }
		}

		$model = Mage::getModel('mpsswitcher/coloroptions')->Load($value, 'option_id');
                if ($model->getId() == 0) {
                    $model = Mage::getModel('mpsswitcher/coloroptions');
                    $model->setData('option_id', $value);
		    $_curfile = '';
                } else {
		    $_curfile = $model->getData('img_url');
		}

                if (isset($data['filename_delete'][$value]) && $data['filename_delete'][$value] = "1") {
                    $model->deleteImageFile();
                    $_fileName = "";
                }

		if ($_fileName != '') {
		    $_curfile = $_fileName;
		}
                
                $model->setData('attribute_id', $data['attribute_id']);
                $model->setData('img_url', $_curfile);
                $model->setData('color_hex', isset($data['color_hex'][$value]) ? $data['color_hex'][$value]: '');             
                $model->Save();
            }
        }
                
    }
    
}
