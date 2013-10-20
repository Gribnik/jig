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

class Atwix_Jig_Helper_Data extends Mage_Core_Helper_Data
{

    const JIG_IPSUM_PARAGRAPH = <<<EOD
At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium
voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati
cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est
laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero
tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat
facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam
et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et
molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis
voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat
EOD;
    const MAX_NAME_WORDS_COUNT = 4;
    const MAX_DESCRIPTION_WORDS_COUNT = 15;
    const PRODUCTS_COUNT = 10;

    private $_chunks = array();

    // Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

    public function getKitchenActionUrl($action)
    {
        $url = Mage::helper("adminhtml")->getUrl('atwix_jig/kitchen/' . $action);

        return $url;
    }

    public function generateProducts($visibility, $categoryIds, $websites)
    {
        for ($iterator = 0; $iterator < self::PRODUCTS_COUNT; $iterator++) {
            if (false === $this->generateSimpleProduct($visibility, $categoryIds, $websites)) {
                return false;
            }
        }

        return true;
    }

    public function generateSimpleProduct($visibility, $categoryIds, $websites)
    {
        $product = Mage::getModel('catalog/product');
        $defaultAttributeSet = Mage::getModel('catalog/product')->getDefaultAttributeSetId();
        $product->setSku(strtotime("now"))
            ->setName($this->_getChunk(rand(1, self::MAX_NAME_WORDS_COUNT)))
            ->setDescription($this->_getChunk(rand(1, self::MAX_DESCRIPTION_WORDS_COUNT)))
            ->setShortDescription($this->_getChunk(rand(1, self::MAX_DESCRIPTION_WORDS_COUNT)))
            ->setPrice(rand(1, 1000))
            ->setTypeId('simple')
            ->setAttributeSetId($defaultAttributeSet)
            ->setCategoryIds($categoryIds)
            ->setVisibility($visibility)
            ->setStatus(1)
            ->setTaxClassId(0)
            ->setWeight('1')
            ->setStockData(array('is_in_stock' => 1, 'qty' => 999))
            ->setCreatedAt(strtotime('now'))
            ->setFixtureProduct('69');
        $product->setWebsiteIds($websites);
        $this->_assignImages($product);

        /* TODO: check required attributes in the attribute set */

        try {
            $product->save();
            return true;
        } catch (Exception $e) {
            Mage::log($e->getMessage(), NULL, 'atwix_jig.log', true);
        }

        return false;
    }

    protected function _assignImages($product)
    {
        return $this;
    }

    protected function _getChunk($count)
    {
        $chunk = '';
        if (count($this->_chunks) == 0) {
            $ipsumNoNl = str_replace("\n", " ", self::JIG_IPSUM_PARAGRAPH); // Remove new lines
            $this->_chunks = explode(' ', $ipsumNoNl);
        }
        if ($count != count($this->_chunks)) {
            $limitStartPoint = count($this->_chunks) - $count;
            $randStartPoint = rand(0, $limitStartPoint);
            $chunkArray = array();
            for ($chunkIndex = $randStartPoint, $iterator = 1; $iterator <= $count; $iterator++, $chunkIndex++) {
                array_push($chunkArray, $this->_chunks[$chunkIndex]);
            }
            $chunk = implode(' ', $chunkArray);
        } else {
            $chunk = self::JIG_IPSUM_PARAGRAPH;
        }

        return $chunk;
    }

    public function getCurrentWebsite()
    {
        $code = Mage::getSingleton('adminhtml/config_data')->getWebsite();
        if (strlen($code) > 0) {
            $websiteId = Mage::getModel('core/website')->load($code)->getId();
        } else {
            $websiteId = Mage::app()->getWebsite()->getId();
        }

        return $websiteId;
    }
}