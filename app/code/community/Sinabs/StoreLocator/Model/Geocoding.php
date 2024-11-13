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

class Sinabs_Storelocator_Model_Geocoding extends Mage_Core_Model_Abstract
{
    /**
     * Xml path for Google geo api url
     */
	const XML_PATH_STORELOCATOR_GOOGLE_GEO = 'storelocator/google/geo';

    /**
     * Xml path for Google geo api key
     */
    const XML_PATH_STORELOCATOR_GOOGLE_API_KEY = 'storelocator/google/apikey';

    /**
     * Google geo search parameters
     */
	private $_output = 'json';
	private $_sensor = 'false';
	private $_parameters;
    private $_response = null;

    /**
     * Make a call to Google Geo Api
     * @param array $args
     * @return $this
     */
	public function callApi($args = array())
	{
		$this->_parameters = $args;
		$this->_response = $this->_forgeRequest();
        return $this;
	}

    /**
     * Get API response
     * @return null
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * Get coordinates from response
     * @return array|false
     */
    public function getCoords()
    {
        if(is_null($this->getResponse())) {
            return false;
        }
        $o = ($this->getOutput() == 'json') ? json_decode($this->getResponse()) : $this->getResponse();
		if (count($o->results) > 0) {
			return $o->results[0]->geometry->location;
		}
        return false;
    }

    /**
     * Get geocoding URL from configuation
     * @return mixed
     */
	public function getGeoUrl()
	{
		return Mage::getStoreConfig(self::XML_PATH_STORELOCATOR_GOOGLE_GEO);
	}

    /**
     * Forge geo request from parameters
     * @return bool|string
     */
	private function _forgeRequest()
	{

		$url = str_replace('http:', 'https:', $this->getGeoUrl() . DS . $this->getOutput()) . '?key=' .
            XML_PATH_STORELOCATOR_GOOGLE_API_KEY . '=' . urlencode(implode(',', $this->_parameters)) .
            '&sensor=' . $this->getSensor();
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
	}

    /**
     * Setter for output
     * @param $type
     * @return void
     */
	public function setOutput($type)
	{
		$this->_output = $type;
	}

    /**
     * Setter for senser
     * @param $sensor
     * @return void
     */
	public function setSensor($sensor)
	{
		$this->_sensor = $sensor;
	}

    /**
     * Getter for output
     * @return string
     */
	public function getOutput()
	{
		return $this->_output;
	}

    /**
     * Getter for sensor
     * @return string
     */
	public function getSensor()
	{
		return $this->_sensor;
	}
}
