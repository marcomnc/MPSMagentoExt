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

class MpsSistemi_Catalog_Block_Adminhtml_Category_Tab_Product extends Mage_Adminhtml_Block_Catalog_Category_Tab_Product {
    
    
    public function __construct() {
        
        parent::__construct();
        
        $this->setAdditionalJavaScript('
                if (typeof(MpsProduct) === "undefined") {
                    var MpsProduct = {};
                }
                MpsProduct.PopUpCategoryProduct = Class.create();
                MpsProduct.PopUpCategoryProduct.prototype = {
                    initialize: function () {
                        this.win = null;
                    },        
                    openPopup : function(url) {
                        if (this.win && !this.win.closed) {
                            this.win.close();
                        }

                        this.win = window.open(url, "",
                                "width=1000,height=700,resizable=1,scrollbars=1");
                        this.win.focus();
                    }
                };
                
                var popupcategoryproduct = new MpsProduct.PopUpCategoryProduct();
                '
        );
        
    }    
    /**
     * Override della funzoine base per visualizzare il tipo di prodotto
     * @return type
     */
    protected function _prepareColumns()
    {
        if (!$this->getCategory()->getProductsReadonly()) {
            $this->addColumn('in_category', array(
                'header_css_class' => 'a-center',
                'type'      => 'checkbox',
                'name'      => 'in_category',
                'values'    => $this->_getSelectedProducts(),
                'align'     => 'center',
                'index'     => 'entity_id'
            ));
        }
        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('catalog')->__('ID'),
            'sortable'  => true,
            'width'     => '60',
            'index'     => 'entity_id'
        ));
        $this->addColumn('name', array(
            'header'    => Mage::helper('catalog')->__('Name'),
            'index'     => 'name'
        ));
        $this->addColumn('sku', array(
            'header'    => Mage::helper('catalog')->__('SKU'),
            'width'     => '80',
            'index'     => 'sku'
        ));
        $this->addColumn('type',
            array(
                'header'=> Mage::helper('catalog')->__('Type'),
                'width' => '60px',
                'index' => 'type_id',
                'type'  => 'options',
                'options' => Mage::getSingleton('catalog/product_type')->getOptionArray(),
                'value'   => Mage::getStoreConfig('mpscatalog_options/category/default_product_type')
        ));
        $this->addColumn('price', array(
            'header'    => Mage::helper('catalog')->__('Price'),
            'type'  => 'currency',
            'width'     => '1',
            'currency_code' => (string) Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE),
            'index'     => 'price',            
        ));
        $this->addColumn('position', array(
            'header'    => Mage::helper('catalog')->__('Position'),
            'width'     => '1',
            'type'      => 'number',
            'index'     => 'position',
            'editable'  => !$this->getCategory()->getProductsReadonly()
            //'renderer'  => 'adminhtml/widget_grid_column_renderer_input'
        ));
        
        $this->addColumn( 'image', 
            array(
                'header'    => Mage::helper('catalog')->__('Image'),
                'type'      => 'text',
                'filter'    => false,
                'sortable'  => false,
                'frame_callback' => array($this, 'decorateImage'),
            ) 
        );
        
        $this->addColumn('action',
            array(
                'header'    => Mage::helper('catalog')->__('Action'),
                'type'      => 'text',
                'getter'     => 'getId',
                'filter'    => false,
                'sortable'  => false,
                'frame_callback' => array($this, 'decorateAction'),
        ));
        
        $this->addColumn('delete',
            array(
                'header'    => Mage::helper('catalog')->__('Remove'),
                'type'      => 'text',
                'filter'    => false,
                'sortable'  => false,
                'frame_callback' => array($this, 'decorateRemove'),
        ));

        return Mage_Adminhtml_Block_Widget_Grid::_prepareColumns();
    }
    
    public function decorateAction($value, $row, $column, $isExport) {
        $cell = '';
               
        $url = Mage::helper("adminhtml")->getUrl("adminhtml/catalog_product/edit/",array("id" => $row->getId(), "popup" => 1));
        $cell = '<a class="popup-category" onClick="popupcategoryproduct.openPopup(this.href);return false;" href="' . $url . '">' . Mage::helper('catalog')->__('Edit'). '</a>';
        
        return $cell;
    }
    
    public function decorateRemove($value, $row, $column, $isExport) {
        $cell = '';
               
        $url = Mage::helper("adminhtml")->getUrl("adminhtml/catalog_product/delete/",array("id" => $row->getId(), "popup" => 1));
        $cell = '<a class="popup-category" onClick="confirmSetLocation(\''.Mage::helper('catalog')->__('Are you sure?').'\', \'$url\');" href="' . $url . '">' . Mage::helper('catalog')->__('Remove'). '</a>';
        
        return $cell;
    }
    
    public function decorateImage($value, $row, $column, $isExport) {

       $product = Mage::getModel('catalog/product')->Load($row->getEntityId());
       $img = $product->getImage();
       $cell = "";
       if ($img != "" && $img != "no_image" && $img != "no_selection") {       
        $imgUrl = Mage::helper('catalog/image')->init($product, 'image')->resize(75);
       
           $cell = "<center>"
               . "<a href=\"#\" onclick=\"window.open('$imgUrl', '$img')\" title=\"$img\""
               . " url=\"$imgUrl\" id=\"imageurl\">"
               . "<img src=\"$imgUrl\" width=\"75\">"
               . "</a>"
               . "</center>";           
       }
       return $cell;
    }
    
}

