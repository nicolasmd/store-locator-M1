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

class Sinabs_Storelocator_Model_Resource_Points_Collection extends Mage_Eav_Model_Entity_Collection_Abstract
{
    /**
     * @inheritDoc
     */
	public function _construct()
	{
		$this->_init('storelocator/points');
	}

    /**
     * Add store filter
     *
     * @param $store
     * @return $this
     */
	public function addStoreFilter($store = null)
	{
		if ($store === null) {
			$store = Mage::app()->getStore()->getId();
		}
		
		if (!Mage::app()->isSingleStoreMode()) {
			if ($store instanceof Mage_Core_Model_Store) {
				$store = array($store->getId());
			}
			
			$this->getSelect()
				->joinLeft(
                    array('stores_table' => $this->getTable('storelocator/stores')),
                    'main_table.entity_id = stores_table.entity_id', array())
				->where('stores_table.store_id in (?)', array(0, $store));
			return $this;
		}
		return $this;
	}

    /**
     * Add city filter
     *
     * @param $city
     * @return $this
     */
	public function addCityFilter($city)
	{
        // @todo : reecrire cette requete
		$select = $this->getSelect()
			->from($this->getTable('storelocator/points'))
			->where('main_table.city = ?', $city);
		return $this;
	}

    /**
     * Add categories filter
     *
     * @param $categories
     * @return $this
     */
    public function addCategoryFilter($categories)
    {
        $this->getSelect()
              ->joinLeft(array('categories_table' =>
                  $this->getTable('storelocator/points_categories')), 'e.entity_id = categories_table.entity_id', array())
              ->where('categories_table.category_id in (?)', $categories);
        return $this;
    }

    /**
     * Add radius filter (in km)
     *
     * @param $radius
     * @param $lat
     * @param $lng
     * @return $this
     */
	public function addRadiusFilter($radius, $lat, $lng)
	{
		$formula = "6371*acos(cos(radians($lat))*cos(radians(main_table.lat))*cos(radians(main_table.lng)-
		    radians($lng))+sin(radians($lat))*sin(radians(main_table.lat)))";
		
		$select = $this->getSelect()
			->from($this->getTable('storelocator/points'))
			->where("$formula <= ?", $radius);
		return $this;
	}
}