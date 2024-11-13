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

class Sinabs_Storelocator_Block_Adminhtml_Categories_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * @inheritDoc
     */
	public function __construct()
	{
		$this->_objectId = 'category_id';
		$this->_controller = 'adminhtml_categories';
		$this->_blockGroup = 'storelocator';
		
		parent::__construct();
		
		$this->_updateButton('save', 'label', 'Save');
		$this->_updateButton('delete', 'label', 'Delete');
	}

    /**
     * @inheritDoc
     */
	public function getHeaderText()
	{
		if (($data = Mage::registry('category_data')) && $data->getId()) {
			return $this->__('Edit Category %s (ID : %d)', $this->htmlEscape($data->getName()), $data->getId());
		} else {
			return $this->__('Add Category');
		}
	}
}