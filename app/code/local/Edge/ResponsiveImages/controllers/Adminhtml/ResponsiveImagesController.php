<?php

class Edge_ResponsiveImages_Adminhtml_ResponsiveImagesController extends Mage_Adminhtml_Controller_Action
{
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('system/config/catalog');
    }
    
    public function generateAction()
    {
        $success = Mage::helper('responsiveimages/generate')->generateAll();
        if ($success) {
            Mage::getSingleton('adminhtml/session')->addSuccess('The images have been generated.');
        } else {
            Mage::getSingleton('adminhtml/session')->addError('Could not generate the images.');
        }

        $this->_redirectReferer();
    }
}
