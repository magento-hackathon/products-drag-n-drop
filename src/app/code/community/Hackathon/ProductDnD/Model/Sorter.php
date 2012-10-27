<?php
/**
 * Created by JetBrains PhpStorm.
 * User: flagbit
 * Date: 27.10.12
 * Time: 16:49
 * To change this template use File | Settings | File Templates.
 */
class Hackathon_ProductDnD_Model_Sorter extends Mage_Core_Model_Abstract
{
    public function changeProductPosition($categoryId, $productId, $neighborId) {

        $modified = 0;
        $category = Mage::getModel('catalog/category')->load($categoryId);

        /* @var $category Mage_Catalog_Model_Category */
        $positions = $oldPositions = $category->getProductsPosition();
        $flippedPositions = array_flip($positions);
        if (!in_array($productId, $flippedPositions) || !in_array($neighborId, $flippedPositions)) {
            return false;
        }

        ksort($flippedPositions);
        $positionKeys = array_keys($flippedPositions);

        $originalProductPosition = $positions[$productId];
        $originalNeighborPosition = $positions[$neighborId];

        if ($originalProductPosition < $originalNeighborPosition) {
            $positionKeys = array_reverse($positionKeys);

            foreach ($positionKeys as $key => $value) {
                if ($value > $originalNeighborPosition) {
                    continue;
                }
                if ($value <= $originalProductPosition) {
                    break;
                }

                $positions[$flippedPositions[$value]] = $positions[$flippedPositions[$positionKeys[$key + 1]]];
            }
        }
        else {
            foreach ($positionKeys as $key => $value) {
                if ($value < $originalNeighborPosition) {
                    continue;
                }
                if ($value >= $originalProductPosition) {
                    break;
                }

                $positions[$flippedPositions[$value]] = $positions[$flippedPositions[$positionKeys[$key + 1]]];
            }
        }

        $positions[$productId] = $originalNeighborPosition;

        if ($oldPositions != $positions) {
            Mage::app()->setCurrentStore(0);
            $category->setPostedProducts($positions);
            $category->save();
            $modified = 1;
        }

        return $modified;
    }
}
