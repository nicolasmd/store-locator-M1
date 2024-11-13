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

class Sinabs_Storelocator_Block_Adminhtml_Points_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Gmaps API Url
     */
	const URL_GMAPS_API = 'https://maps.googleapis.com/maps/api/js?sensor=false';

    /**
     * Configure store edition form
     *
     * @inheritDoc
     */
	protected function _prepareForm()
	{
		$registry = Mage::registry('point_data');
		
		$form = new Varien_Data_Form();
		
		$general = $form->addFieldset('general', array(
			'legend' => $this->__('General Information')
		));
		
		$general->addType('externaljs', 'Sinabs_Storelocator_Block_Adminhtml_Form_Element_ExternalJs');
		
		$general->addField('google_maps_api', 'externaljs', array(
			'src' => self::URL_GMAPS_API
		));
		
		if($registry->getId()) {
			$general->addField('entity_id', 'hidden', array(
				'name' => 'entity_id'
			));
		}
		
		$general->addField('name', 'text', array(
			'name' => 'name',
			'label' => $this->__('Name'),
			'title' => $this->__('Name'),
			'required' => true
		));
		
		$general->addField('is_active', 'select', array(
			'name' => 'is_active',
			'label' => $this->__('Enabled'),
			'title' => $this->__('Enabled'),
			'required' => true,
			'values' => array(
				array('label' => $this->__('Yes'), 'value' => 1),
				array('label' => $this->__('No'), 'value' => 0),
			)
		));
		
		if(!Mage::app()->isSingleStoreMode()) {
			$general->addField('store_id', 'multiselect', array(
				'name' => 'stores[]',
				'label' => $this->__('Store View'),
				'title' => $this->__('Store View'),
				'required' => true,
				'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true)
			));
		}
		
		$general->addField('active_shipping', 'select', array(
			'name' => 'active_shipping',
			'label' => $this->__('Active Shipping'),
			'title' => $this->__('Active Shipping'),
			'required' => true,
			'values' => array(
				array('label'	=> $this->__('Yes'), 'value' => 1),
				array('label' => $this->__('No'), 'value' => 0)
			)
		));
		
		$categories = array();
		foreach (Mage::getModel('storelocator/categories')->getCollection() as $category) {
			$categories[] = array(
				'label' => $category->getName(),
				'value' => $category->getId()
			);
		}
		
		$general->addField('category_id', 'multiselect', array(
			'name' => 'categories[]',
			'label' => $this->__('Categories'),
			'title' => $this->__('Categories'),
			'required' => false,
			'values' => $categories
		));
		
		$general->addField('image', 'image', array(
			'label' => $this->__('Image'),
			'name' => 'image',
			'required' => false
		));
		
		$general->addField('description', 'textarea', array(
			'name' => 'description',
			'label' => $this->__('Description'),
			'title' => $this->__('Description'),
			'required' => false
		));
		
		$general->addField('phone', 'text', array(
			'name' => 'phone',
			'label' => $this->__('Phone'),
			'title' => $this->__('Phone'),
			'required' => false
		));
		
		$general->addField('email', 'text', array(
			'name' => 'email',
			'label' => $this->__('Email'),
			'title' => $this->__('Email'),
			'required' => false
		));
		
		$general->addField('external_id', 'text', array(
			'name' => 'external_id',
			'label' => $this->__('External ID'),
			'title' => $this->__('External ID'),
			'required' => false
		));
		
		$address = $form->addFieldset('address', array(
			'legend' => $this->__('Address')
		));
		
		$address->addType('jsbutton', 'Sinabs_Storelocator_Block_Adminhtml_Form_Element_JsButton');
		$address->addType('geomap', 'Sinabs_Storelocator_Block_Adminhtml_Form_Element_Geomap');
		
		$address->addField('street1', 'text', array(
			'name' => 'street1',
			'label' => $this->__('Street 1'),
			'title' => $this->__('Street 1'),
			'required' => true
		));
		
		$address->addField('street2', 'text', array(
			'name' => 'street2',
			'label' => $this->__('Street 2'),
			'title' => $this->__('Street 2'),
			'required' => false
		));
		
		$address->addField('zipcode', 'text', array(
			'name' => 'zipcode',
			'label' => $this->__('Zipcode'),
			'title' => $this->__('Zipcode'),
			'required' => true
		));
		
		$address->addField('city', 'text', array(
			'name' => 'city',
			'label' => $this->__('City'),
			'title' => $this->__('City'),
			'required' => true
		));
		
		$address->addField('country', 'text', array(
			'name' => 'country',
			'label' => $this->__('Country'),
			'title' => $this->__('Country'),
			'required' => true
		));
		
		$address->addField('lat', 'text', array(
			'name' => 'lat',
			'label' => $this->__('Latitude'),
			'title' => $this->__('Latitude'),
			'required' => false
		));
		
		$address->addField('lng', 'text', array(
			'name' => 'lng',
			'label' => $this->__('Longitude'),
			'title' => $this->__('Longitude'),
			'required' => false
		));
		
		$address->addField('geolocation', 'jsbutton', array(
			'id' => 'button_geolocation',
			'label' => $this->__('Geolocate'),
			'onclick' => 'GMaps.geolocate();',
			'class' => 'show-hide'
		));
		
		$address->addField('geomap', 'geomap', array(
			'label' => $this->__('Map'),
			'name' => 'geomap'
		));
		
		if ($registry->getData()) {
			$form->setValues($registry->getData());
		}
		
		$this->setForm($form);
		
		return parent::_prepareForm();
	}
}