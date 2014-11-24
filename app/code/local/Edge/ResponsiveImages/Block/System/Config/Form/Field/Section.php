<?php

class Edge_ResponsiveImages_Block_System_Config_Form_Field_Section extends Mage_Core_Block_Html_Select
{
    public function setInputName($value)
    {
        return $this->setName($value);
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    public function _toHtml()
    {
        $this->addOption('product_view', 'Product View');
        $this->addOption('product_list', 'Product List');
        $this->addOption('category_view', 'Category View');
        return parent::_toHtml();
    }
}