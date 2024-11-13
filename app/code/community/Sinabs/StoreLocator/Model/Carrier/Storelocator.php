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

class Sinabs_Storelocator_Model_Carrier_Storelocator extends Mage_Shipping_Model_Carrier_Abstract implements Mage_Shipping_Model_Carrier_Interface
{
	protected $_code = 'storelocator';

    /**
     * @inheritDoc
     */
	public function collectRates(Mage_Shipping_Model_Rate_Request $request)
	{
		if (!Mage::getStoreConfig('carriers/' . $this->_code . '/active')) {
			return false;
		}
		
		$result = Mage::getModel('shipping/rate_result');
		$method = Mage::getModel('shipping/rate_result_method');
		
		$method->setCarrier($this->_code);
		$method->setCarrierTitle($this->getConfigData('title'));
		$method->setMethod($this->_code);
		$method->setMethodTitle($this->getConfigData('title'));
		$method->setPrice($this->_getCalculationPrice());
		
		$result->append($method);
		
		return $result;
	}

    /**
     * @inheritDoc
     */
	public function getAllowedMethods()
	{
		return array($this->_code => $this->getConfigData('name'));
	}

    /**
     * @inheritDoc
     */
	protected function _getCalculationPrice()
	{
		return (false != ($price = Mage::getStoreConfig('carriers/' . $this->_code . '/price')) ? $price : 0);
	}
}