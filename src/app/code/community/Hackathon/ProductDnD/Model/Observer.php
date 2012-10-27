<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mike
 * Date: 27.10.12
 * Time: 13:54
 * To change this template use File | Settings | File Templates.
 */
class Hackathon_ProductDnD_Model_Observer
{
    /**
     * Adds layout handles based on configuration.
     *
     * @param Varien_Event_Observer $observer
     */
    public function addActivationLayoutHandles($observer)
    {
        $request = Mage::app()->getRequest();
        if (Mage::helper('hackathon_productdnd')->isActivated()
            && $request->getModuleName() == 'catalog'
            && $request->getControllerName() == 'category'
            && $request->getActionName() == 'view') {
            $layout = $observer->getLayout();
            $update = $layout->getUpdate();
            $update->addHandle('hackathon_productdnd_enabled');
        }
    }
}