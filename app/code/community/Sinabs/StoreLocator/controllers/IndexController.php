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

class Sinabs_Storelocator_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * Is module active
     */
	const XML_PATH_ENABLED_FRONTEND = 'storelocator/frontend/active';

    /**
     * @inheritDoc
     */
	public function indexAction()
	{
		if (!Mage::getStoreConfig(self::XML_PATH_ENABLED_FRONTEND)) {
			$this->_redirect('/');
		}
		
		$this->loadLayout();
		$this->renderLayout();
	}

    /**
     * @inheritDoc
     */
	public function postAction()
	{
		$resource = Mage::getModel('storelocator/points');
		
		if ($this->getRequest()->getParam('display_mode') == 1) {
			$radius = $this->getRequest()->getParam('radius');
			$lat = $this->getRequest()->getParam('lat');
			$lng = $this->getRequest()->getParam('lng');

			$points = $resource
				->getCollection()
				->addRadiusFilter($radius, $lat, $lng)
				->toArray();
		} else {
			$city = $this->getRequest()->getParam('cities');
            if(trim($city) != '') {
				if (is_numeric($city)) {
					$filterBy = 'zipcode';
					if (strlen($city) >= 2) {
						$city = array('like' => substr($city, 0, 2) . '%');
					}
				} else {
					$filterBy = 'city';
				}

				$points = $resource
					->getCollection()
					->addAttributeToSelect('*')
					->addAttributeToFilter($filterBy, $city);

				$country = $this->getRequest()->getParam('countries', '');
				if ($country != '') {
					$points->addAttributeToFilter('country', $country);
				}
				
			} else {
				$country = $this->getRequest()->getParam('countries', '');
				$points = $resource
					->getCollection()
					->addAttributeToSelect('*');
				$points->addAttributeToFilter('country', $country);;
			}

			$points->load()
				->toArray();
			
		}
		$this->getResponse()->setBody(Zend_Json::encode($points));
	}

    /**
     * Ajax controller method for city autocomplete
     * @return void
     */
    public function suggestAction()
    {
        $query = $this->getRequest()->getParam('q', false);
        $points = array();
        
        if ($query && $query != '') {
            $collection = Mage::getModel('storelocator/points')
                ->getCollection()
                ->addAttributeToSelect('*');
                
            if (is_numeric($query)) {
                $filterBy = 'zipcode';
            } else {
                $filterBy = 'city';
            }
            
            $collection->addAttributeToFilter($filterBy, array('like' => '%' . $query . '%'));
            
            foreach ($collection as $point) {
                $data = $point->getData($filterBy);
                if (!in_array($data, $points)) {
                    $points[] = $data;
                }
                
            }
        }
        
        $this->getResponse()->setBody(Zend_Json::encode($points));
    }
}
