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

class Sinabs_Storelocator_Model_System_Config_Source_Frontend_Units
{
	const UNIT_KM = 1;
	
	const UNIT_MI = 2;

    /**
     * Source model for frontend unit
     * @return array[]
     */
	public function toOptionArray()
	{
		return array(
			array(
				'value' => self::UNIT_KM,
				'label' => Mage::helper('storelocator')->__('Kilometers')
			),
			array(
				'value' => self::UNIT_MI,
				'label' => Mage::helper('storelocator')->__('Miles')
			)
		);
	}
}