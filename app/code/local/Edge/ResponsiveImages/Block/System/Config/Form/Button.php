<?php

class Edge_ResponsiveImages_Block_System_Config_Form_Button extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('responsiveimages/system/config/button.phtml');
    }

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $button = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(array(
                'id'    => 'responsiveimages_button',
                'label' => $this->helper('adminhtml')->__('Generate Images'),
                'onclick' => "window.location.href = '" . Mage::helper('adminhtml')->getUrl('responsiveimages/admin/generate') . "'"
            ));

        return $button->toHtml();
    }
}