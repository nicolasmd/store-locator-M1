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


class Sinabs_Storelocator_Block_Adminhtml_Categories_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * @inheritDoc
     */
	protected function _prepareForm()
	{
		$registry = Mage::registry('category_data');
		
		$form = new Varien_Data_Form();
		
		$fieldset = $form->addFieldset('general', array(
			'legend' => $this->__('General Information')
		));
		
		if($registry->getId()) {
			$fieldset->addField('category_id', 'hidden', array(
				'name' => 'category_id'
			));
		}
		
		$fieldset->addField('name', 'text', array(
			'name' => 'name',
			'label' => $this->__('Name'),
			'title' => $this->__('Name'),
			'required' => true
		));
		
		$fieldset->addField('icon', 'image', array(
			'name' => 'Icon',
			'label' => $this->__('Icon'),
			'title' => $this->__('Icon'),
			'required' => false
		));
		
		if ($registry->getData()) {
			$form->setValues($registry->getData());
		}
		
		$this->setForm($form);
		
		return parent::_prepareForm();
	}
}