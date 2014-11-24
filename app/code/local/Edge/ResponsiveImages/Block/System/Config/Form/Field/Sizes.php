<?php

class Edge_ResponsiveImages_Block_System_Config_Form_Field_Sizes extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    /**
     * @var Edge_ResponsiveImages_Block_System_Config_Form_Field_Section
     */
    protected $_sectionRenderer;

    /**
     * Retrieve section column renderer
     *
     * @return Edge_ResponsiveImages_Block_System_Config_Form_Field_Section
     */
    protected function _getSectionRenderer()
    {
        if (!$this->_sectionRenderer) {
            $this->_sectionRenderer = $this->getLayout()->createBlock(
                'responsiveimages/system_config_form_field_section', '',
                array('is_render_to_js_template' => true)
            );
            $this->_sectionRenderer->setExtraParams('style="width:120px"');
        }
        return $this->_sectionRenderer;
    }

    /**
     * Prepare to render
     */
    protected function _prepareToRender()
    {
        $this->addColumn('section', array(
            'label' => Mage::helper('adminhtml')->__('Section'),
            'renderer' => $this->_getSectionRenderer()
        ));
        $this->addColumn('size', array(
            'label' => Mage::helper('adminhtml')->__('Size'),
            'style' => 'width:60px'
        ));
        $this->addColumn('viewport', array(
            'label' => Mage::helper('adminhtml')->__('Viewport Width'),
            'style' => 'width:60px'
        ));
        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('cataloginventory')->__('Add Size');
    }

    /**
     * Prepare existing row data object
     *
     * @param Varien_Object
     */
    protected function _prepareArrayRow(Varien_Object $row)
    {
        $row->setData(
            'option_extra_attr_' . $this->_getSectionRenderer()->calcOptionHash($row->getData('section')),
            'selected="selected"'
        );
    }
}