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

class Sinabs_Storelocator_Block_Adminhtml_Form_Element_ExternalJs extends Varien_Data_Form_Element_Abstract
{
    /**
     * @inheritDoc
     * @param $attributes
     */
	public function __construct($attributes = array())
	{
		parent::__construct($attributes);
	}

    /**
     * @inheritDoc
     */
	public function getElementHtml()
	{
		return '<script type="text/javascript" src="' . $this->getSrc() . '"></script>';
	}
}