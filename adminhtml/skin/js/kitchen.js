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

var atwixJigKitchen = Class.create();

atwixJigKitchen.prototype = {

    initialize: function(url) {
    },

    generateProducts: function(requestPath) {
        response = this._sendRequest({}, requestPath);
        if (response.status == 'ok') {
            alert('the request has been completed successfully');
        }
    },

    _sendRequest: function(params, url) {
        var response = {};
        new Ajax.Request(url, {
            method:     'get',
            parameters: params,
            onSuccess: function(response) {
                jsonResponse = response.responseText.evalJSON();
                response = jsonResponse;
            },
            onFailure: function() {
                response.status = 'error';
                response.text = 'Cannot complete request'
            }
        })
    }
}