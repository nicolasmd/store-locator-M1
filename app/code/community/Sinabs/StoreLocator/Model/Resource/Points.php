<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @package     Sinabs_StoreLocator
 * @author      Nicolas Marchand
 * @copyright   Copyright (c) 2017 Sinabs
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Sinabs_Storelocator_Model_Resource_Points extends Mage_Eav_Model_Entity_Abstract
{
    /**
     * @inheritDoc
     */
	public function _construct()
	{
		$resource = Mage::getSingleton('core/resource');
        $this->setType('storelocator_points');
        $this->setConnection(
            $resource->getConnection('storelocator_read'),
            $resource->getConnection('storelocator_write')
        );
	}

    /**
     * Populate store model with categories and stores after loading
     *
     * @param Varien_Object $model
     * @return mixed
     */
	protected function _afterLoad(Varien_Object $model)
	{
        // Categories
		$categories = $this->_getReadAdapter()
			->select()
			->from($this->getTable('storelocator/points_categories'))
			->where('entity_id = ?', $model->getId());
			
		if ($data = $this->_getReadAdapter()->fetchAll($categories)) {
			$categoriesArray = array();
			foreach ($data as $category) {
				$categoriesArray[] = $category['category_id'];
			}
			$model->setData('category_id', $categoriesArray);
		}
        
        // Stores
        $stores = $this->_getReadAdapter()
            ->select()
            ->from($this->getTable('storelocator/stores'))
            ->where('entity_id = ?', $model->getId());
            
        if ($data = $this->_getReadAdapter()->fetchAll($stores)) {
            $storesArray = array();
            foreach ($data as $store) {
                $storesArray[] = $store['store_id'];
            }
            $model->setData('store_id', $storesArray);
        }
		
		return parent::_afterLoad($model);
	}


    /**
     * Save store model with categories and stores
     *
     * @param Varien_Object $object
     * @return mixed
     */
	protected function _afterSave(Varien_Object $object)
	{
	    // Categories
		$condition = $this->_getWriteAdapter()->quoteInto('entity_id = ?', $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('storelocator/points_categories'), $condition);
        
		if ($object->getData('categories')) {
			foreach ((array) $object->getData('categories') as $category) {
				$categoriesArray = array();
				$categoriesArray['entity_id'] = $object->getId();
				$categoriesArray['category_id'] = $category;
				$this->_getWriteAdapter()->insert($this->getTable('storelocator/points_categories'), $categoriesArray);
			}
		}
		
        // Stores
        $condition = $this->_getWriteAdapter()->quoteInto('entity_id = ?', $object->getId());
        $this->_getWriteAdapter()->delete($this->getTable('storelocator/stores'), $condition);
        
        if (!$object->getData('stores')) {
            $storesArray = array();
            $storesArray['entity_id'] = $object->getId();
            $storesArray['store_id'] = 0;
            $this->_getWriteAdapter()->insert($this->getTable('storelocator/stores'), $storesArray);
        } else {
            foreach ((array) $object->getData('stores') as $store) {
                $storesArray = array();
                $storesArray['entity_id'] = $object->getId();
                $storesArray['store_id'] = $store;
                $this->_getWriteAdapter()->insert($this->getTable('storelocator/stores'), $storesArray);
            }
        }
		return parent::_afterSave($object);
	}
}