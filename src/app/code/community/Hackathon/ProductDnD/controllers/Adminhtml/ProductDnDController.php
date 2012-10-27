<?php

class Hackathon_ProductDnD_Adminhtml_ProductDnDController extends Mage_Adminhtml_Controller_Action
{
    public function ajaxBlockAction(){

        $categoryId = (int) $this->getRequest()->getParam('categoryId');
        $neighborId = (int) $this->getRequest()->getParam('neighbourId');
        $productId = (int) $this->getRequest()->getParam('productId');

        $sortModel = Mage::getModel('hackathon_productdnd/sorter');
        $sortModel->changeProductPosition($categoryId, $productId, $neighborId);

        $this->getResponse()->setBody(
            Mage::app()->getRequest()->getParam('categoryId') . ' - ' . Mage::app()->getRequest()->getParam('productId') . ' - ' . Mage::app()->getRequest()->getParam('neighbourId')
        );
    }
}