<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mike
 * Date: 27.10.12
 * Time: 13:54
 * To change this template use File | Settings | File Templates.
 */
class Hackathon_ProductDnD_Model_Observer extends Mage_Core_Block_Template
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
	
	/**
	 * Adds the sortable.js to the head of the page after the ajax-Request for the category-products
	 * was loaded
	 * 
	 * @param Varien_Event_Observer $observer
	 */
	 public function addSortableScript($observer)
	 {
	 	$this->setTemplate('hackathon/productdnd/sortable.phtml');
		// Mage::log(get_class_methods($this));
		$content = $observer->getResponse()->getContent();
		$additional = $this->toHtml();
		Mage::log($additional);
		$content .= $additional;
	 }
}