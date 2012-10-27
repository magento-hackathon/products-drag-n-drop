<?php

class Hackathon_ProductDnD_Adminhtml_ProductDnDController extends Mage_Adminhtml_Controller_Action
{
    public function ajaxBlockAction(){
        $this->getResponse()->setBody('ajax action controller');
        return;
    }
}