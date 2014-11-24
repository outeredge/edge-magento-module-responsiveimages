<?php

class Edge_ResponsiveImages_AdminController extends Mage_Adminhtml_Controller_Action
{
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