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

class Sinabs_Storelocator_Adminhtml_CategoriesController extends Mage_Adminhtml_Controller_Action
{
    /**
     * @inheritDoc
     */
	public function _initAction()
	{
		$this->loadLayout()->_setActiveMenu('cms');
		return $this;
	}

    /**
     * @inheritDoc
     */
	public function indexAction()
	{
		$this->_forward('list');
	}

    /**
     * @inheritDoc
     */
	public function listAction()
	{
		$this->_initAction()
			->_addContent($this->getLayout()->createBlock('storelocator/adminhtml_categories'))
			->renderLayout();
	}

    /**
     * @inheritDoc
     */
	public function newAction()
	{
		$this->_forward('edit');
	}

    /**
     * @inheritDoc
     */
	public function editAction()
	{
		$pointId = $this->getRequest()->getParam('category_id');
		$point = Mage::getModel('storelocator/categories')->load($pointId);
		
		Mage::register('category_data', $point);
		
		$this->_initAction()
			->_addContent($this->getLayout()->createBlock('storelocator/adminhtml_categories_edit'))
			->_addLeft($this->getLayout()->createBlock('storelocator/adminhtml_categories_edit_tabs'))
			->renderLayout();
	}

    /**
     * @inheritDoc
     */
	public function saveAction()
	{
		if ($data = $this->getRequest()->getPost()) {
			$model = Mage::getModel('storelocator/categories');
			$model->setData($data);
			
			try {
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The category was saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				
				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('storelocator/adminhtml_category/edit', array('category_id', $model->getId()));
					return;
				}
				
				$this->_redirect('*/*/list');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				
				$this->_redirect('*/*/edit', array('category_id', $this->getRequest()->getParam('category_id')));
				return;
			}
		}
	}

    /**
     * @inheritDoc
     */
	public function deleteAction()
	{
		if($id = $this->getRequest()->getParam('category_id')) {
			try {
				Mage::getModel('storelocator/categories')->load($id)->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess('The category has been deleted');
				$this->_Redirect('*/*/list');
				return;
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/list');
				return;
			}
		}
	}

    /**
     * @inheritDoc
     */
	public function massDeleteAction()
	{
		$ids = $this->getRequest()->getParam('storelocator');
		if (!is_array($ids)) {
			Mage::getSingleton('adminhtml/session')->addError($this->__('Please select store(s)'));
		} else {
			try {
				foreach ($ids as $id) {
					Mage::getModel('storelocator/categories')->load($id)->delete();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Total of %d record(s) were successfully deleted', count($ids)));
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
		}
		$this->_redirect('*/*/index');
	}
}