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

class Sinabs_Storelocator_Block_View extends Mage_Core_Block_Template
{
    /**
     * XML path for search readius
     */
	const XML_PATH_STORELOCATOR_FRONTEND_RADIUS = 'storelocator/frontend/radius';

    /**
     * XML path for default unit
     */
	const XML_PATH_STORELOCATOR_FRONTEND_UNITS = 'storelocator/frontend/units';

    /**
     *  XML path for frontend display mode
     */
	const XML_PATH_STORELOCATOR_FRONTEND_DISPLAY_MODE = 'storelocator/frontend/display_mode';

    private $_defaultRadius = array('5', '10', '20');

    /**
     * Get configured radius or default radius otherwise
     * @return array
     */
	public function getRadius()
	{
		if (($radius = (Mage::getStoreConfig(self::XML_PATH_STORELOCATOR_FRONTEND_RADIUS))) != '') {
			return explode(',', $radius);	
		} else {
			return $this->_defaultRadius;
		}
	}

    /**
     * Get configured unit
     * @return string
     */
	public function getUnit()
	{
		return Mage::getStoreConfig(self::XML_PATH_STORELOCATOR_FRONTEND_UNITS);
	}

    /**
     * Get configured display mode
     * @return string
     */
	public function getDisplayMode()
	{
		return (int)Mage::getStoreConfig(self::XML_PATH_STORELOCATOR_FRONTEND_DISPLAY_MODE);
	}
	
	// @todo : Magento V 1.4 compatibility ?
	/*public function getGeoList()
	{
		$result = array();
		$countries = Mage::getModel('storelocator/points')
			->getCollection()
			->distinct(true)
			->addAttributeToSelect('country')
			->load()
			->toArray();
		
		foreach ($countries as $country) {
			$cities = Mage::getResourceModel('storelocator/points_collection')
				->addAttributeToSelect('*')
				->addAttributeToFilter('country', $country['country'])
				->distinct(true)
				->load()
				->toArray();
				
			foreach ($cities as $city) {
				$result[$country['country']][] = $city['city'];
			}
		}

		return $result;
	}*/

    /**
     * Get store collection sorted by country
     * @return array
     */
	public function getGeoList() 
	{
		$result = array();
		$resource = Mage::getSingleton('core/resource');
		$read = $resource->getConnection('core_read');
		$table = $resource->getTableName('sinabs_storelocator_points');
		$countries = $read->fetchAll('SELECT DISTINCT country FROM ' . $table . ' ORDER BY country ASC');
		
		foreach ($countries as $country) {
			$cities = Mage::getResourceModel('storelocator/points_collection')
				->addAttributeToSelect('*')
				->addAttributeToFilter('country', $country['country'])
				->distinct(true)
				->load()
				->toArray();
				
			$distinctCities = array();
			foreach ($cities as $city) {
				$distinctCities[] = $city['city'];
			}
			$distinctCities = array_unique($distinctCities);
			sort($distinctCities, SORT_STRING);
			$result[$country['country']] = $distinctCities;
		}
		
		return $result;
	}

    /**
     * Get country search parameter
     * @return string
     */
	public function getCountryRequest()
	{
		return urldecode($this->getRequest()->getParam('country', false));
	}

    /**
     * Get city search parameter
     * @return string
     */
	public function getCityRequest()
	{
		return urldecode($this->getRequest()->getParam('city', false));
	}

    /**
     * Get store categories
     * @return mixed
     */
	public function getCategories()
	{
		return Mage::getModel('storelocator/categories')->getCollection();
	}
}