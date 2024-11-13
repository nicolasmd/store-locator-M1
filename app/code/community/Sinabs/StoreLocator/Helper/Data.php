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

class Sinabs_Storelocator_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * XML paths for default position in Gmaps
     */
	const XML_PATH_STORELOCATOR_FRONTEND_LAT = 'storelocator/frontend/lat';
	const XML_PATH_STORELOCATOR_FRONTEND_LNG = 'storelocator/frontend/lng';
	const XML_PATH_STORELOCATOR_FRONTEND_ZOOM = 'storelocator/frontend/zoom';
	
	/**
	 * Retrieve point image URL
	 *
	 * @param string $image
	 * @return string
	 */
	public function getPointImageUrl($imageName)
	{
		return Mage::getBaseUrl('media') . 'sinabs' . DS . 'storelocator' . DS . 'points' . DS . $imageName;
	}
	
	/**
	 * Retrieve directory path
	 *
	 * @param string $imageName
	 * @return string
	 */
	public function getPointImageDir($imageName = null)
	{
		return 'sinabs' . DS . 'storelocator' . DS . 'points' . DS . $imageName;
	}

    /**
     * Get zoom level (Gmaps)
     *
     * @return mixed
     */
	public function getZoomLevel()
	{
		return Mage::getStoreConfig(self::XML_PATH_STORELOCATOR_FRONTEND_ZOOM);
	}

    /**
     * Getd default map position
     * @return array
     */
	public function getLatLngCenter()
	{
		return array(
			'lat' => Mage::getStoreConfig(self::XML_PATH_STORELOCATOR_FRONTEND_LAT),
			'lng' => Mage::getStoreConfig(self::XML_PATH_STORELOCATOR_FRONTEND_LNG),
		);
	}
}