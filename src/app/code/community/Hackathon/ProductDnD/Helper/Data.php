<?php
/**
 * Created by JetBrains PhpStorm.
 * User: flagbit
 * Date: 27.10.12
 * Time: 13:57
 * To change this template use File | Settings | File Templates.
 */
class Hackathon_ProductDnD_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_DRAGNDROP_ALLOW_IPS = 'catalog/dragndrop/allow_ips';
    const XML_PATH_DRAGNDROP_ACTIVE_BACKEND = 'catalog/dragndrop/active_backend';
    const XML_PATH_DRAGNDROP_ACTIVE_FRONTEND = 'catalog/dragndrop/active_frontend';

    /**
     * @param Mage_Core_Model_Store $store
     * @return bool
     */
    public function isActivated($store = null)
    {

        if (Mage::getDesign()->getArea() == 'adminhtml') {
            return Mage::getStoreConfig(self::XML_PATH_DRAGNDROP_ACTIVE_BACKEND);
        }

        if (is_null($store)) {
            $store = Mage::app()->getStore();
        }
        if (!$store instanceof Mage_Core_Model_Store) {
            $store = Mage::app()->getStore($store);
        }

        $allow = Mage::getStoreConfigFlag(self::XML_PATH_DRAGNDROP_ACTIVE_FRONTEND, $store);

        $allowedIps = Mage::getStoreConfig(self::XML_PATH_DRAGNDROP_ALLOW_IPS, $store->getId());
        $remoteAddr = Mage::helper('core/http')->getRemoteAddr();
        if ($allow && !empty($allowedIps) && !empty($remoteAddr)) {
            $allowedIps = preg_split('#\s*,\s*#', $allowedIps, null, PREG_SPLIT_NO_EMPTY);
            if (array_search($remoteAddr, $allowedIps) === false
                && array_search(Mage::helper('core/http')->getHttpHost(), $allowedIps) === false) {
                $allow = false;
            }
        }

        return $allow;
    }

}
