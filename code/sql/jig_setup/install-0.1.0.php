<?php
/**
 * Atwix
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

 * @category    Atwix Mod
 * @package     Atwix_Jig
 * @author      Atwix Core Team
 * @copyright   Copyright (c) 2012 Atwix (http://www.atwix.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/* @var $installer Mage_Eav_Model_Entity_Setup */

$installer = $this;

$installer->startSetup();

$attributeSettings = array(
    'group'    => 'General',
    'label'    => 'Fixture',
    'visible'  => false,
    'type'     => 'int',
    'input'    => 'text',
    'system'   => true,
    'required' => false,
    'global'   => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'default'  => '0',
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'visible_on_front' => false,
    'is_configurable' => false,
    'user_defined' => false
);

/* Add the new attribute 'fixture_product' to mark all created products for testing purposes */

$installer->addAttribute('catalog_product', 'fixture_product', $attributeSettings);
$installer->endSetup();
