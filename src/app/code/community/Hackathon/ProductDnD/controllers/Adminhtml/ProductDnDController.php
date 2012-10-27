<?php

class Hackathon_ProductsDnD_Adminhtml_ProductDnDController extends Mage_Adminhtml_Controller_Action
{
    public function ajaxBlockAction(){
        $output = $this->getLayout()->createBlock('Hackathon_ProductsDnD_Block_View')->toHtml();
        $this->getResponse()->setBody($output);
        return;
    }
}