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

class Sinabs_Storelocator_Adminhtml_PointsController extends Mage_Adminhtml_Controller_Action
{
    /**
     * @inheritDoc
     */
	protected function _initAction()
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
	public function newAction()
	{
		$this->_forward('edit');
	}

    /**
     * @inheritDoc
     */
	public function listAction()
	{
		$this->_initAction()
			->_addContent($this->getLayout()->createBlock('storelocator/adminhtml_points'))
			->renderLayout();
	}

    /**
     * @inheritDoc
     */
	public function editAction()
	{
		$pointId = $this->getRequest()->getParam('entity_id');
		$point = Mage::getModel('storelocator/points')->load($pointId);
		
		Mage::register('point_data', $point);
		
		$this->_initAction()
			->_addContent($this->getLayout()->createBlock('storelocator/adminhtml_points_edit'))
			->_addLeft($this->getLayout()->createBlock('storelocator/adminhtml_points_edit_tabs'))
			->renderLayout();
	}

    /**
     * @inheritDoc
     */
	public function saveAction()
	{
		if ($data = $this->getRequest()->getPost()) {
			
			$data['business_hours'] = $this->_formatBusinessHours($data);
			
			if (isset($data['stores'])) {
				if ($data['stores'][0] == 0) {
					unset($data['stores']);
					$data['stores'] = array();
					$stores = Mage::getSingleton('adminhtml/system_store')->getStoreCollection();
					foreach ($stores as $store) {
						$data['stores'][] = $store->getId();
					}
				}
			}
			
			$model = Mage::getModel('storelocator/points');
			$model->setData($data);
            
			try {
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The store was saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				
				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('storelocator/adminhtml_point/edit', array('entity_id', $model->getId()));
					return;
				}
				
				$this->_redirect('*/*/list');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				
				$this->_redirect('*/*/edit', array('entity_id', $this->getRequest()->getParam('entity_id')));
				return;
			}
		}
	}

    /**
     * @inheritDoc
     */
	public function deleteAction()
	{
		if($id = $this->getRequest()->getParam('entity_id')) {
			try {
				Mage::getModel('storelocator/points')->load($id)->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess('The store has been deleted');
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
					Mage::getModel('storelocator/points')->load($id)->delete();	
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Total of %d record(s) were successfully deleted', count($ids)));
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
		}
		$this->_redirect('*/*/index');
	}

    /**
     * @inheritDoc
     */
	private function _formatBusinessHours($data)
	{
		return serialize(array(
			'monday' => $data['monday'],
			'tuesday' => $data['tuesday'],
			'wednesday' => $data['wednesday'],
			'thursday' => $data['thursday'],
			'friday' => $data['friday'],
			'saturday' => $data['saturday'],
			'sunday' => $data['sunday']
		));
	}
}