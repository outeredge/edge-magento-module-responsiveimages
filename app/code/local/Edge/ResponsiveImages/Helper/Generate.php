<?php

class Edge_ResponsiveImages_Helper_Generate extends Mage_Core_Helper_Abstract
{
    protected $_sizes = array();

    public function __construct()
    {
        $sizesSerialized = Mage::getStoreConfig('catalog/responsiveimages/sizes');
        if (!$sizesSerialized) {
            return;
        }

        $sizes = @unserialize($sizesSerialized);
        if (empty($sizes)) {
            return;
        }

        $dir = Mage::getBaseDir('media') . DS . 'catalog' . DS . 'responsiveimages' . DS;
        if (!file_exists($dir)) {
            mkdir($dir);
        }

        foreach ($sizes as $key=>$size) {
            $sizes[$key]['dir'] = $dir . $size['size'];
            if (!file_exists($sizes[$key]['dir'])) {
                mkdir($sizes[$key]['dir']);
            }
        }

        $this->_sizes = $sizes;
    }

    /**
     * Generate a single category images
     */
    public function generateCategory($category)
    {
        if (empty($this->_sizes)) {
            return;
        }

        $categoryImageDir = DS . 'catalog' . DS . 'category';

        foreach (array('image', 'thumbnail') as $imageType) {
            $imageName = DS . $category->getData($imageType);

            foreach ($this->_sizes as $size) {
                if ($size['section'] !== 'category_view') {
                    continue;
                }

                $imagePath = $size['dir'] . $imageName;
                if (!file_exists($imagePath)) {
                    $image = new Varien_Image(Mage::getBaseDir('media') . $categoryImageDir . $imageName);
                    $image->resize($size['size']);
                    $image->save($imagePath);
                }
            }
        }
    }

    /**
     * Generate a single products images
     */
    public function generateProduct($product)
    {
        if (empty($this->_sizes)) {
            return;
        }

        $productImageDir = DS . 'catalog' . DS . 'product';

        $mediaGallery = $product->getMediaGalleryImages();
        if ($mediaGallery && !empty($mediaGallery)) {
            foreach ($mediaGallery as $image) {
                $imageName = $image->getFile();

                foreach ($this->_sizes as $size) {
                    if ($size['section'] === 'category_view') {
                        continue;
                    }

                    $imagePath = $size['dir'] . $imageName;
                    if (!file_exists($imagePath)) {
                        $image = new Varien_Image(Mage::getBaseDir('media') . $productImageDir . $imageName);
                        $image->resize($size['size']);
                        $image->save($imagePath);
                    }
                }
            }
        }
    }

    /**
     * Generate all images for the system
     */
    public function generateAll()
    {
        if (empty($this->_sizes)) {
            return;
        }

        $products = Mage::getModel('catalog/product')
            ->getCollection();

        foreach ($products as $product) {
            $product->load('media_gallery');
            $this->generateProduct($product);
        }

        $categories = Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToSelect(array('image', 'thumbnail'));

        foreach ($categories as $category) {
            $this->generateCategory($category);
        }

        return true;
    }
}