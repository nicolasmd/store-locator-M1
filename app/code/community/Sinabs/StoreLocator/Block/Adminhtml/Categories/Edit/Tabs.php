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

class Sinabs_Storelocator_Block_Adminhtml_Categories_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * @inheritDoc
     */
	public function __construct()
	{
		parent::__construct();
		$this->setId('storelocator_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle($this->__('General Information'));
	}

    /**
     * @inheritDoc
     */
	protected function _beforeToHtml()
	{
		$this->addTab('general_section', array(
			'label' => $this->__('Category Information'),
			'title' => $this->__('Category Information'),
			'content' => $this->getLayout()->createBlock('storelocator/adminhtml_categories_edit_tab_form')->toHtml()
		));
		
		return parent::_beforeToHtml();
	}
}