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

class Sinabs_Storelocator_Block_Adminhtml_Points_Edit_Tab_Hours extends Mage_Adminhtml_Block_Widget_Form
{

    /**
     * Configure store opening hours form
     *
     * @inheritDoc
     */
	protected function _prepareForm()
	{
		$registry = Mage::registry('point_data');
		if ($registry->getId()) {
			$hours = unserialize($registry->getBusinessHours());
		}
		
		$form = new Varien_Data_Form();
		
		$fieldset = $form->addFieldset('hours', array(
			'legend' => $this->__('Business hours')
		));
		
		$fieldset->addField('monday', 'text', array(
			'name' => 'monday',
			'label' => $this->__('Monday'),
			'title' => $this->__('Monday'),
			'value' => isset($hours['monday']) ? $hours['monday'] : null,
			'after_element_html' => '<small>Format: HH:MM - HH:MM / HH:MM - HH:MM</small>'
		));
		
		$fieldset->addField('tuesday', 'text', array(
			'name' => 'tuesday',
			'label' => $this->__('Tuesday'),
			'title' => $this->__('Tuesday'),
			'value' => isset($hours['tuesday']) ? $hours['tuesday'] : null
		));
		
		$fieldset->addField('wednesday', 'text', array(
			'name' => 'wednesday',
			'label' => $this->__('Wednesday'),
			'title' => $this->__('Wednesday'),
			'value' => isset($hours['wednesday']) ? $hours['wednesday'] : null
		));
		
		$fieldset->addField('thursday', 'text', array(
			'name' => 'thursday',
			'label' => $this->__('Thursday'),
			'title' => $this->__('Thursday'),
			'value' => isset($hours['thursday']) ? $hours['thursday'] : null
		));
		
		$fieldset->addField('friday', 'text', array(
			'name' => 'friday',
			'label' => $this->__('Friday'),
			'title' => $this->__('Friday'),
			'value' => isset($hours['friday']) ? $hours['friday'] : null
		));
		
		$fieldset->addField('saturday', 'text', array(
			'name' => 'saturday',
			'label' => $this->__('Saturday'),
			'title' => $this->__('Saturday'),
			'value' => isset($hours['saturday']) ? $hours['saturday'] : null
		));
		
		$fieldset->addField('sunday', 'text', array(
			'name' => 'sunday',
			'label' => $this->__('Sunday'),
			'title' => $this->__('Sunday'),
			'value' => isset($hours['sunday']) ? $hours['sunday'] : null
		));
		
		$this->setForm($form);
		return parent::_prepareForm();
	}
}