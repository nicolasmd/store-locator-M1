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

class Sinabs_Storelocator_Model_Attribute_Backend_Image extends Mage_Eav_Model_Entity_Attribute_Backend_Abstract
{

    /**
     * Save uploaded file and set its name to storelocator point
     *
     * @param Varien_Object $object
     */
    public function afterSave($object)
    {
        $value = $object->getData($this->getAttribute()->getName());

        if (is_array($value) && !empty($value['delete'])) {
            $object->setData($this->getAttribute()->getName(), '');
            $this->getAttribute()->getEntity()
                ->saveAttribute($object, $this->getAttribute()->getName());
            return;
        }

        $path = Mage::getBaseDir('media') . DS . Mage::helper('storelocator')->getPointImageDir();

        try {
            $uploader = new Mage_Core_Model_File_Uploader($this->getAttribute()->getName());
            $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
            $uploader->setAllowRenameFiles(false);
            $uploader->setFilesDispersion(false);
            $result = $uploader->save($path);

            $object->setData($this->getAttribute()->getName(), Mage::helper('storelocator')->getPointImageDir($result['file']));
            $this->getAttribute()->getEntity()->saveAttribute($object, $this->getAttribute()->getName());
        } catch (Exception $e) {
        	Mage::logException($e);
            return;
        }
    }
}
