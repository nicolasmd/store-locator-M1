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

$installer = $this;
$installer->startSetup();

$installer->run("
    CREATE TABLE IF NOT EXISTS {$this->getTable('sinabs_storelocator_eav_attribute')} (
        `attribute_id` smallint(5) unsigned NOT NULL COMMENT 'Attribute ID',
        `is_filterable` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Filterable',
    PRIMARY KEY (`attribute_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Store locator EAV Attribute Table';

    ALTER TABLE {$this->getTable('sinabs_storelocator_eav_attribute')}
        ADD CONSTRAINT `FK_STORELOCATOR_EAV_ATTRIBUTE_ID_EAV_ATTRIBUTE_ID` FOREIGN KEY (`attribute_id`) REFERENCES `eav_attribute` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE;
");

$installer->addEntityType('storelocator_points', array(
    'entity_model'    => 'storelocator/points',
    'table'           => 'storelocator/points',
    'increment_model' => 'eav/entity_increment_numeric',
    'increment_per_store' => 1,
    'attribute_model' => 'storelocator/resource_eav_attribute',
    'additional_attribute_table' => 'storelocator/eav_attribute'
));

$installer->createEntityTables($this->getTable('storelocator/points'));

// Static fields
$this->addAttribute('storelocator_points', 'active_shipping', array(
    'type'              => 'static',
    'label'             => 'Active shipping',
    'input'             => 'boolean',
    'class'             => '',
    'backend'           => '',
    'frontend'          => '',
    'source'            => '',
    'required'          => false,
    'user_defined'      => false,
    'default'           => false,
    'unique'            => false,
    'is_filterable'     => true
));

$this->addAttribute('storelocator_points', 'email', array(
    'type'              => 'static',
    'label'             => 'Email',
    'input'             => 'text',
    'class'             => '',
    'backend'           => '',
    'frontend'          => '',
    'source'            => '',
    'required'          => false,
    'user_defined'      => false,
    'default'           => false,
    'unique'            => false,
    'is_filterable'     => true
));

$this->addAttribute('storelocator_points', 'country', array(
    'type'              => 'static',
    'label'             => 'Country',
    'input'             => 'text',
    'class'             => '',
    'backend'           => '',
    'frontend'          => '',
    'source'            => '',
    'required'          => false,
    'user_defined'      => false,
    'default'           => false,
    'unique'            => false,
    'is_filterable'     => true
));

$this->addAttribute('storelocator_points', 'lat', array(
    'type'              => 'static',
    'label'             => 'Lat',
    'input'             => 'select',
    'class'             => '', 
    'backend'           => '',
    'frontend'          => '',
    'source'            => '',
    'required'          => false,
    'user_defined'      => false,
    'default'           => false,
    'unique'            => false,
    'is_filterable'     => true
));

$this->addAttribute('storelocator_points', 'lng', array(
    'type'              => 'static',
    'label'             => 'Lng',
    'input'             => 'select',
    'class'             => '',
    'backend'           => '',
    'frontend'          => '',
    'source'            => '',
    'required'          => false,
    'user_defined'      => false,
    'default'           => false,
    'unique'            => false,
    'is_filterable'     => true
));

$this->addAttribute('storelocator_points', 'external_id', array(
    'type'              => 'static',
    'label'             => 'External ID',
    'input'             => 'text',
    'class'             => '',
    'backend'           => '',
    'frontend'          => '',
    'source'            => '',
    'required'          => false,
    'user_defined'      => false,
    'default'           => false,
    'unique'            => false,
    'is_filterable'     => true
));

// Eav fields
$this->addAttribute('storelocator_points', 'name', array(
    'type'              => 'varchar',
    'label'             => 'Name',
    'input'             => 'text',
    'class'             => '',
    'backend'           => '',
    'frontend'          => '',
    'source'            => '',
    'required'          => true,
    'user_defined'      => false,
    'default'           => false,
    'unique'            => false,
    'is_filterable'     => true
));

$this->addAttribute('storelocator_points', 'description', array(
    'type'              => 'varchar',
    'label'             => 'Description',
    'input'             => 'text',
    'class'             => '',
    'backend'           => '',
    'frontend'          => '',
    'source'            => '',
    'required'          => false,
    'user_defined'      => false,
    'default'           => false,
    'unique'            => false,
    'is_filterable'     => true
));

$this->addAttribute('storelocator_points', 'image', array(
    'type'              => 'varchar',
    'label'             => 'Image',
    'input'             => 'text',
    'class'             => '',
    'backend'           => 'storelocator/attribute_backend_image',
    'frontend'          => '',
    'source'            => '',
    'required'          => false,
    'user_defined'      => false,
    'default'           => false,
    'unique'            => false,
    'is_filterable'     => true
));

$this->addAttribute('storelocator_points', 'phone', array(
    'type'              => 'varchar',
    'label'             => 'Phone',
    'input'             => 'text',
    'class'             => '',
    'backend'           => '',
    'frontend'          => '',
    'source'            => '',
    'required'          => false,
    'user_defined'      => false,
    'default'           => false,
    'unique'            => false,
    'is_filterable'     => true
));

$this->addAttribute('storelocator_points', 'street1', array(
    'type'              => 'varchar',
    'label'             => 'Street 1',
    'input'             => 'text',
    'class'             => '',
    'backend'           => '',
    'frontend'          => '',
    'source'            => '',
    'required'          => false,
    'user_defined'      => false,
    'default'           => false,
    'unique'            => false,
    'is_filterable'     => true
));

$this->addAttribute('storelocator_points', 'street2', array(
    'type'              => 'varchar',
    'label'             => 'Street 2',
    'input'             => 'text',
    'class'             => '',
    'backend'           => '',
    'frontend'          => '',
    'source'            => '',
    'required'          => false,
    'user_defined'      => false,
    'default'           => false,
    'unique'            => false,
    'is_filterable'     => true
));

$this->addAttribute('storelocator_points', 'zipcode', array(
    'type'              => 'varchar',
    'label'             => 'Zip code',
    'input'             => 'text',
    'class'             => '',
    'backend'           => '',
    'frontend'          => '',
    'source'            => '',
    'required'          => false,
    'user_defined'      => false,
    'default'           => false,
    'unique'            => false,
    'is_filterable'     => true
));

$this->addAttribute('storelocator_points', 'city', array(
    'type'              => 'varchar',
    'label'             => 'City',
    'input'             => 'text',
    'class'             => '',
    'backend'           => '',
    'frontend'          => '',
    'source'            => '',
    'required'          => false,
    'user_defined'      => false,
    'default'           => false,
    'unique'            => false,
    'is_filterable'     => true
));

$this->addAttribute('storelocator_points', 'business_hours', array(
    'type'              => 'varchar',
    'label'             => 'Business hours',
    'input'             => 'text',
    'class'             => '',
    'backend'           => '',
    'frontend'          => '',
    'source'            => '',
    'required'          => false,
    'user_defined'      => false,
    'default'           => false,
    'unique'            => false,
    'is_filterable'     => true
));

$installer->run("
	ALTER TABLE {$this->getTable('sinabs_storelocator_points')} 
	ADD `active_shipping` TINYINT(1) NOT NULL ,
	ADD `email` VARCHAR(255) NULL DEFAULT NULL ,
	ADD `country` VARCHAR(255) NULL DEFAULT NULL ,
	ADD `lat` FLOAT(10, 6) NOT NULL ,
	ADD `lng` FLOAT(10, 6) NOT NULL ,
	ADD `external_id` VARCHAR( 255 ) NOT NULL"
);

$installer->run("
	CREATE TABLE IF NOT EXISTS {$this->getTable('sinabs_storelocator_categories')} (
      `category_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
      PRIMARY KEY (`category_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
	
	CREATE TABLE IF NOT EXISTS {$this->getTable('sinabs_storelocator_points_categories')} (
      `entity_id` int(11) NOT NULL,
      `category_id` int(11) NOT NULL,
      PRIMARY KEY (`entity_id`,`category_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    
    CREATE TABLE IF NOT EXISTS {$this->getTable('sinabs_storelocator_points_stores')} (
      `entity_id` int(11) NOT NULL,
      `store_id` int(11) NOT NULL,
      PRIMARY KEY (`entity_id`,`store_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
	
");


$installer->endSetup();