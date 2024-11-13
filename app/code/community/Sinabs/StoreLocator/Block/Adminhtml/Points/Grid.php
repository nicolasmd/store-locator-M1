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

class Sinabs_Storelocator_Block_Adminhtml_Points_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * @inheritDoc
     */
	public function __construct()
	{
		parent::__construct();
		$this->setId('pointsGrid');
		$this->setDefaultSort('entity_id');
		$this->setDefaultDir('ASC');
	}

    /**
     * Select all attributes
     *
     * @inheritDoc
     */
	protected function _prepareCollection()
	{
		$collection = Mage::getResourceModel('storelocator/points_collection')
		  ->addAttributeToSelect('*');
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

    /**
     * @inheritDoc
     */
	protected function _prepareColumns()
	{
		$this->addColumn('entity_id', array(
			'header' => $this->__('ID'),
			'align' => 'left',
			'index' => 'entity_id'
		));
		
		$this->addColumn('name', array(
			'header' => $this->__('Name'),
			'align' => 'left',
			'index' => 'name'
		));
		
		$this->addColumn('street1', array(
			'header' => $this->__('Street 1'),
			'align' => 'left',
			'index' => 'street1'
		));
		
		$this->addColumn('street2', array(
			'header' => $this->__('Street 2'),
			'align' => 'left',
			'index' => 'street2'
		));
		
		$this->addColumn('zipcode', array(
			'header' => $this->__('Zipcode'),
			'align' => 'left',
			'index' => 'zipcode'
		));
		
		$this->addColumn('city', array(
			'header' => $this->__('City'),
			'align' => 'left',
			'index' => 'city'
		));
		
		$this->addColumn('country', array(
			'header' => $this->__('Country'),
			'align' => 'left',
			'index' => 'country'
		));
		
		return parent::_prepareColumns();
	}

    /**
     * @inheritDoc
     */
	protected function _prepareMassaction()
	{
		$this->setMassactionIdField('entity_id');
		$this->getMassactionBlock()->setFormFieldName('storelocator');
		
		$this->getMassactionBlock()->addItem('delete', array(
			'label' => $this->__('Delete'),
			'url' => $this->getUrl('*/*/massDelete'),
			'confirm' => $this->__('Are you sure?')
		));
	}

    /**
     * @inheritDoc
     */
	public function getRowUrl($row)
	{
		return $this->getUrl('*/*/edit', array('entity_id' => $row->getId()));
	}
}