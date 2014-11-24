<?php

class Edge_ResponsiveImages_Model_Observer
{
    protected $_queueProductGenerate = false;

    public function productSaveBefore($event)
    {
        $product = $event->getProduct();

        $mediaGallery = $product->getMediaGallery();
        $images = json_decode($mediaGallery['images'], true);

        foreach ($images as $image){
            if (preg_match('/\.tmp$/', $image['file'])){
                $this->_queueProductGenerate = true;
            }
        }
    }

    public function productSaveAfter($event)
    {
        if ($this->_queueProductGenerate){
            Mage::helper('responsiveimages/generate')->generateProduct($event->getProduct());
        }
    }

    public function categorySaveAfter($event)
    {
        $category = $event->getCategory();

        if (is_string($category->getImage()) || is_string($category->getThumbnail())) {
            Mage::helper('responsiveimages/generate')->generateCategory($category);
        }
    }
}