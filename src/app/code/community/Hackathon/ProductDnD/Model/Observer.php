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
            && $request->getActionName() == 'view'
            && Mage::getBlockSingleton('catalog/product_list_toolbar')->getCurrentOrder() == 'position') {
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
	 public function addSortableScriptOnEdit($observer)
	 {
         $content = $observer->getResponse()->getContent();
         $content = $this->appendScript($content);
		 $observer->getResponse()->setContent($content);
	 }

     public function addSortableScriptOnGrid($observer)
     {
         $content = $observer->getControllerAction()->getResponse()->getBody();
         $content = $this->appendScript($content);
         $observer->getControllerAction()->getResponse()->setBody($content);
     }

    public function appendScript($content)
    {
        $this->setTemplate('hackathon/productdnd/sortable.phtml');
        $additional = $this->toHtml();
        return $content . $additional;
    }
}