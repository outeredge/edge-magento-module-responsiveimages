<?php

class Edge_ResponsiveImages_Model_System_Config_Source_TagType
{
    public function toOptionArray()
    {
        return array(
            array(
                'value' => 'picture',
                'label' => Mage::helper('adminhtml')->__('Picture')
            ),
            array(
                'value' => 'img',
                'label' => Mage::helper('adminhtml')->__('Img')
            )
        );
    }
}
