<?php

class Hackathon_ProductDnD_Adminhtml_ProductDnDController extends Mage_Adminhtml_Controller_Action
{
    public function ajaxBlockAction(){

        $categoryId = (int) $this->getRequest()->getParam('categoryId');
        $neighborId = (int) $this->getRequest()->getParam('neighbourId');
        $productId = (int) $this->getRequest()->getParam('productId');

        $sortModel = Mage::getModel('hackathon_productdnd/sorter');
        $_response = $sortModel->changeProductPosition($categoryId, $productId, $neighborId);

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($_response));
    }
}