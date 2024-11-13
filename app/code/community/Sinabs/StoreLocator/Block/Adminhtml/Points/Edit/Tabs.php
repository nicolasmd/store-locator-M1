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

class Sinabs_Storelocator_Block_Adminhtml_Points_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
			'label' => $this->__('Store Information'),
			'title' => $this->__('Store Information'),
			'content' => $this->getLayout()->createBlock('storelocator/adminhtml_points_edit_tab_form')->toHtml()
		));
		
		$this->addTab('business_hours', array(
			'label' => $this->__('Business hours'),
			'title' => $this->__('Business hours'),
			'content' => $this->getLayout()->createBlock('storelocator/adminhtml_points_edit_tab_hours')->toHtml()
		));
		
		$this->addTab('attributes', array(
			'label' => $this->__('Attributes'),
			'title' => $this->__('Attributes'),
			'content' => $this->getLayout()->createBlock('storelocator/adminhtml_points_edit_tab_attributes')->toHtml()
		));
		
		return parent::_beforeToHtml();
	}

    /**
     * @inheritDoc
     */
	protected function _prepareLayout()
	{
		$this->getLayout()->getBlock('head')->addCss('sinabs/storelocator/styles.css');
		$this->getLayout()->getBlock('head')->addJs('sinabs/storelocator/adminhtml/map.js');
		parent::_prepareLayout();
	}
}