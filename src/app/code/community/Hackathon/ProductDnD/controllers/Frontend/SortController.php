<?php
/**
 * Created by JetBrains PhpStorm.
 * User: flagbit
 * Date: 27.10.12
 * Time: 16:38
 * To change this template use File | Settings | File Templates.
 */
class Hackathon_ProductDnD_Frontend_SortController extends Mage_Core_Controller_Front_Action
{
    public function changeProductPositionAction()
    {
        if (!Mage::helper('hackathon_productdnd')->isActivated()) {
            return false;
        }

        $request = $this->getRequest();
        $categoryId = (int) $request->getParam('categoryId');
        $productId = (int) $request->getParam('productId');
        $neighborId = (int) $request->getParam('neighbourId');

        $result = Mage::getModel('hackathon_productdnd/sorter')->changeProductPosition($categoryId, $productId, $neighborId);
        $this->getResponse()->setBody(
            json_encode($result)
        );
    }
}
