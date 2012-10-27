<?php
/**
 * Created by JetBrains PhpStorm.
 * User: flagbit
 * Date: 27.10.12
 * Time: 17:21
 * To change this template use File | Settings | File Templates.
 */
class Hackathon_ProductDnD_Block_Json_Products extends Mage_Core_Block_Template
{
    protected function getProductJson()
    {
        $productCollection = Mage::getSingleton('catalog/layer')->getProductCollection();
        $productIds = $productCollection->getLoadedIds();

        return json_encode($productIds);
    }


    protected function getCategoryId()
    {
        return Mage::getSingleton('catalog/layer')->getCurrentCategory()->getId();
    }
}
