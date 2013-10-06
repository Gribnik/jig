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

class Atwix_Jig_KitchenController extends Mage_Adminhtml_Controller_Action
{


    protected $_jsonResponse = array();

    public function testAction()
    {
        echo 'hello world';
    }

    public function fixtureproductAction()
    {
        $productId = $this->getRequest()->getParam('pid');
        if (!is_null($productId)) {
            $product = Mage::getModel('catalog/product')->load($productId);
            $product->setFixtureProduct('69');
            try {
                $product->save();
                echo 'complete';
            } catch (Exception $e) {
                Mage::log($e->getMessage(), NULL, 'atwix_jig.log', true);
            }
        } else {
            echo 'product id is not specified';
        }
    }

    public function removeproductsAction()
    {
        $productsCollection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToFilter('fixture_product', '69');

        foreach ($productsCollection as $_product) {
            /** @var $_product Mage_Catalog_Model_Product  */
            try {
                echo 'Attemt to remove ' . $_product->getName() . "\n";
                $_product->delete();
            } catch (Exception $e) {
                Mage::log($e->getMessage(), NULL, 'atwix_jig.log', true);
            }
        }
    }

    public function generateproductsAction()
    {
        $this->_setJsonResponse('passed')->_sendJsonResponse();
    }

    protected function _setJsonResponse($text, $status = 'ok')
    {
        $this->_jsonResponse = array(
            'status' => $status,
            'text'   => $text
        );

        return $this;
    }

    protected function _sendJsonResponse()
    {
        $response = json_encode($this->_jsonResponse);
        $this->getResponse()->setBody($response);

        return $this;
    }
}