<?php

class Edge_ResponsiveImages_Helper_Data extends Mage_Core_Helper_Abstract
{
    protected $_usePicture;
    protected $_mediaPath;

    public function __construct()
    {
        $this->_usePicture = Mage::getStoreConfig('catalog/responsiveimages/type') === 'picture';
        $this->_mediaPath = Mage::getBaseUrl('media') . 'catalog' . DS . 'responsiveimages' . DS;
    }

    public function getCategoryImageHtml($category)
    {
        $imageUrl = $category->getImage();
        $imageLabel = $category->getName();

        $baseImgSrc = $category->getImageUrl();

        return $this->getImageHtml('category_view', $baseImgSrc, $imageUrl, $imageLabel);
    }

    public function getProductImageHtml($section, $product, $imageType)
    {
        $imageUrl = $product->getData($imageType);
        $imageLabel = $product->getData($imageType . '_label');
        if (empty($imageLabel)) {
            $imageLabel = $product->getName();
        }

        $baseImgSrc = Mage::helper('catalog/image')->init($product, $imageType);

        $html = $this->getImageHtml($section, $baseImgSrc, $imageUrl, $imageLabel);
        if ($section === 'product_view' && Mage::getStoreConfig('catalog/responsiveimages/link')) {
            return '<a href="' . $baseImgSrc . '">' . $html . '</a>';
        }

        return $html;
    }

    public function getImageHtml($section, $baseImgSrc, $imageUrl, $imageLabel)
    {
        if ($this->_usePicture) {
            $html = '<picture>';
            foreach ($this->getSizes($section) as $size){
                $html.= '<source media="(max-width: ' . $size['viewport'] . 'px)" srcset="' . $this->_mediaPath . $size['size'] . DS . $imageUrl . '">';
            }
            $html.= '<img src="' . $baseImgSrc . '" alt="' . $imageLabel . '">';
            $html.= '</picture>';
        }
        else {
            $sources = array();
            foreach ($this->getSizes($section) as $size){
                $sources[] = $this->_mediaPath . $size['size'] . $imageUrl . ' ' . $size['viewport'] . 'w';
            }

            $html = '<img src="' . $baseImgSrc . '" srcset="' . implode(', ', $sources) . '" alt="' . $imageLabel . '"';
        }
        return $html;
    }

    public function getSizes($section)
    {
        $sizesSerialized = Mage::getStoreConfig('catalog/responsiveimages/sizes');
        $sizes = @unserialize($sizesSerialized);
        usort($sizes, array($this, 'sortSizes'));

        foreach ($sizes as $key=>$size){
            if ($size['section'] !== $section){
                unset($sizes[$key]);
            }
        }

        return $sizes;
    }

    private function sortSizes($a, $b)
    {
        if ($a['viewport'] == $b['viewport']){
            return 0;
        }
        return ($a['viewport'] < $b['viewport']) ? -1 : 1;
    }
}