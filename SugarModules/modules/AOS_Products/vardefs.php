<?php
/**
 * Products, Quotations & Invoices modules.
 * Extensions to SugarCRM
 * @package Advanced OpenSales for SugarCRM
 * @subpackage Products
 * @copyright SalesAgility Ltd http://www.salesagility.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author Salesagility Ltd <support@salesagility.com>
 */

$dictionary['AOS_Products'] = array(
                                  'table'=>'aos_products',
                                  'audited'=>true,
                                  'fields'=>array (
                                      'maincode' =>
                                      array (
                                              'required' => '1',
                                              'name' => 'maincode',
                                              'vname' => 'LBL_MAINCODE',
                                              'type' => 'enum',
                                              'massupdate' => 0,
                                              'default' => 'XXXX',
                                              'comments' => '',
                                              'help' => '',
                                              'importable' => 'true',
                                              'duplicate_merge' => 'disabled',
                                              'duplicate_merge_dom_value' => '0',
                                              'audited' => 1,
                                              'reportable' => 0,
                                              'len' => 100,
                                              'options' => 'product_code_dom',
                                              'studio' => 'visible',
                                      ),
                                      'part_number' =>
                                      array (
                                              'required' => false,
                                              'name' => 'part_number',
                                              'vname' => 'LBL_PART_NUMBER',
                                              'type' => 'varchar',
                                              'massupdate' => 0,
                                              'comments' => '',
                                              'help' => '',
                                              'importable' => 'true',
                                              'duplicate_merge' => 'disabled',
                                              'duplicate_merge_dom_value' => '0',
                                              'audited' => 1,
                                              'reportable' => 0,
                                              'len' => '25',
                                      ),
                                      'category' =>
                                      array (
                                              'required' => false,
                                              'name' => 'category',
                                              'vname' => 'LBL_CATEGORY',
                                              'type' => 'enum',
                                              'massupdate' => 0,
                                              'comments' => '',
                                              'help' => '',
                                              'importable' => 'true',
                                              'duplicate_merge' => 'disabled',
                                              'duplicate_merge_dom_value' => '0',
                                              'audited' => 0,
                                              'reportable' => 0,
                                              'len' => 100,
                                              'options' => 'product_category_dom',
                                              'studio' => 'visible',
                                      ),
                                      'type' =>
                                      array (
                                              'required' => false,
                                              'name' => 'type',
                                              'vname' => 'LBL_TYPE',
                                              'type' => 'enum',
                                              'massupdate' => 0,
                                              'default' => 'Good',
                                              'comments' => '',
                                              'help' => '',
                                              'importable' => 'true',
                                              'duplicate_merge' => 'disabled',
                                              'duplicate_merge_dom_value' => '0',
                                              'audited' => 1,
                                              'reportable' => 0,
                                              'len' => 100,
                                              'options' => 'product_type_dom',
                                              'studio' => 'visible',
                                      ),
                                      'cost' =>
                                      array (
                                              'required' => '1',
                                              'name' => 'cost',
                                              'vname' => 'LBL_COST',
                                              'type' => 'currency',
                                              'massupdate' => 0,
                                              'comments' => '',
                                              'help' => '',
                                              'importable' => 'true',
                                              'duplicate_merge' => 'disabled',
                                              'duplicate_merge_dom_value' => '0',
                                              'audited' => 1,
                                              'reportable' => 0,
                                              'len' => 26,
                                              'enable_range_search' => true,
                                              'options' => 'numeric_range_search_dom',
                                      ),
                                      'currency_id' =>
                                      array (
                                              'required' => false,
                                              'name' => 'currency_id',
                                              'vname' => 'LBL_CURRENCY',
                                              'type' => 'id',
                                              'massupdate' => 0,
                                              'comments' => '',
                                              'help' => '',
                                              'importable' => 'true',
                                              'duplicate_merge' => 'disabled',
                                              'duplicate_merge_dom_value' => 0,
                                              'audited' => 0,
                                              'reportable' => 0,
                                              'len' => 36,
                                              'studio' => 'visible',
                                              'function' =>
                                              array (
                                                      'name' => 'getCurrencyDropDown',
                                                      'returns' => 'html',
                                              ),
                                      ),
                                      'price' =>
                                      array (
                                              'required' => '1',
                                              'name' => 'price',
                                              'vname' => 'LBL_PRICE',
                                              'type' => 'currency',
                                              'massupdate' => 0,
                                              'comments' => '',
                                              'help' => '',
                                              'importable' => 'true',
                                              'duplicate_merge' => 'disabled',
                                              'duplicate_merge_dom_value' => '0',
                                              'audited' => 1,
                                              'reportable' => 0,
                                              'len' => 26,
                                              'enable_range_search' => true,
                                              'options' => 'numeric_range_search_dom',
                                      ),
                                      'url' =>
                                      array (
                                              'required' => false,
                                              'name' => 'url',
                                              'vname' => 'LBL_URL',
                                              'type' => 'varchar',
                                              'massupdate' => 0,
                                              'comments' => '',
                                              'help' => '',
                                              'importable' => 'true',
                                              'duplicate_merge' => 'disabled',
                                              'duplicate_merge_dom_value' => '0',
                                              'audited' => 1,
                                              'reportable' => 0,
                                              'len' => '25',
                                      ),
                                      'contact_id' =>
                                      array (
                                              'required' => false,
                                              'name' => 'contact_id',
                                              'vname' => '',
                                              'type' => 'id',
                                              'massupdate' => 0,
                                              'comments' => '',
                                              'help' => '',
                                              'importable' => 'true',
                                              'duplicate_merge' => 'disabled',
                                              'duplicate_merge_dom_value' => 0,
                                              'audited' => 0,
                                              'reportable' => 0,
                                              'len' => 36,
                                      ),
                                      'contact' =>
                                      array (
                                              'required' => false,
                                              'source' => 'non-db',
                                              'name' => 'contact',
                                              'vname' => 'LBL_CONTACT',
                                              'type' => 'relate',
                                              'massupdate' => 0,
                                              'comments' => '',
                                              'help' => '',
                                              'importable' => 'true',
                                              'duplicate_merge' => 'disabled',
                                              'duplicate_merge_dom_value' => '0',
                                              'audited' => 1,
                                              'reportable' => 0,
                                              'len' => '255',
                                              'id_name' => 'contact_id',
                                              'ext2' => 'Contacts',
                                              'module' => 'Contacts',
                                              'quicksearch' => 'enabled',
                                              'studio' => 'visible',
                                      ),
                                      'stock' =>
                                      array (
                                              'name' => 'stock',
                                              'vname' => 'LBL_STOCK',
                                              'required'=>true,
                                              'type' => 'float',
                                              'massupdate' => 1,
                                              'default' => '0.000',
                                              'comments' => '',
                                              'help' => '',
                                              'importable' => true,
                                              'duplicate_merge' => 'disabled',
                                              'duplicate_merge_dom_value' => '0',
                                              'audited' => true,
                                              'len' => '18',
                                              'precision' => '3',
                                      ),
                                      'order_point' =>
                                      array (
                                              'name' => 'order_point',
                                              'vname' => 'LBL_ORDER_POINT',
                                              'required'=>true,
                                              'type' => 'float',
                                              'massupdate' => 1,
                                              'default' => '0.000',
                                              'comments' => '',
                                              'help' => '',
                                              'importable' => true,
                                              'duplicate_merge' => 'disabled',
                                              'duplicate_merge_dom_value' => '0',
                                              'audited' => true,
                                              'len' => '18',
                                              'precision' => '3',
                                      ),
                                      'div_graph' =>
                                      array (
                                              'name' => 'div_graph',
                                              'vname' => 'LBL_DIV_GRAPH',
                                              'source' => 'non-db',
                                              'type' => 'readonly',
                                      ),

                                  ),
                                  'relationships'=>array (
                                  ),
                                  'optimistic_lock'=>true,
                              );
require_once('include/SugarObjects/VardefManager.php');
VardefManager::createVardef('AOS_Products','AOS_Products', array('basic','assignable'));
