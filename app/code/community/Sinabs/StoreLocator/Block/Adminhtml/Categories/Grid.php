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

class Sinabs_Storelocator_Block_Adminhtml_Categories_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * @inheritDoc
     */
	public function __construct()
	{
		parent::__construct();
		$this->setId('categoriesGrid');
		$this->setDefaultSort('category_id');
		$this->setDefaultDir('ASC');
	}

    /**
     * @inheritDoc
     */
	protected function _prepareCollection()
	{
		$collection = Mage::getModel('storelocator/categories')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

    /**
     * @inheritDoc
     */
	protected function _prepareColumns()
	{
		$this->addColumn('category_id', array(
			'header' => $this->__('ID'),
			'align' => 'left',
			'index' => 'category_id'
		));
		
		$this->addColumn('name', array(
			'header' => $this->__('Name'),
			'align' => 'left',
			'index' => 'name'
		));
		
		$this->addColumn('icon', array(
			'header' => $this->__('Icon'),
			'align' => 'left',
			'index' => 'icon'
		));
		
		return parent::_prepareColumns();
	}

    /**
     * @inheritDoc
     */
	protected function _prepareMassaction()
	{
		$this->setMassactionIdField('category_id');
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
		return $this->getUrl('*/*/edit', array('category_id' => $row->getId()));
	}
}