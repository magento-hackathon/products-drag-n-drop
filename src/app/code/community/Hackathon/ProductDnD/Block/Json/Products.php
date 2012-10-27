<?php
/**
 * Created by JetBrains PhpStorm.
 * User: flagbit
 * Date: 27.10.12
 * Time: 17:21
 * To change this template use File | Settings | File Templates.
 */
class Hackathon_ProductDnD_Block_Json_Products extends Mage_Core_Block_Abstract
{
    protected function _toHtml()
    {
        $layer = Mage::getSingleton('catalog/layer');
        $productCollection = $layer->getProductCollection();
        $productIds = $productCollection->getLoadedIds();

        return '<script type="text/javascript">var dndproducts = "' . json_encode($productIds) . '"; var dndcategory = ' . $layer->getCurrentCategory()->getId() . ';--></script>';
    }
}
