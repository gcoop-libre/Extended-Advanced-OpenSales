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

$dictionary['AOS_Invoices'] = array(
	'table'=>'aos_invoices',
	'audited'=>true,
	'fields'=>array (
  'billing_account_id' => 
  array (
    'required' => false,
    'name' => 'billing_account_id',
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
  'billing_account' => 
  array (
    'required' => false,
    'source' => 'non-db',
    'name' => 'billing_account',
    'vname' => 'LBL_BILLING_ACCOUNT',
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
    'id_name' => 'billing_account_id',
    'ext2' => 'Accounts',
    'module' => 'Accounts',
    'quicksearch' => 'enabled',
    'studio' => 'visible',
  ),
  'billing_contact_id' => 
  array (
    'required' => false,
    'name' => 'billing_contact_id',
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
  'billing_contact' => 
  array (
    'required' => false,
    'source' => 'non-db',
    'name' => 'billing_contact',
    'vname' => 'LBL_BILLING_CONTACT',
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
    'id_name' => 'billing_contact_id',
    'ext2' => 'Contacts',
    'module' => 'Contacts',
    'quicksearch' => 'enabled',
    'studio' => 'visible',
  ),
  
       'billing_address_street' => 
  array (
    'name' => 'billing_address_street',
    'vname' => 'LBL_BILLING_ADDRESS_STREET',
    'type' => 'varchar',
    'len' => '150',
    'comment' => 'The street address used for billing address',
    'group'=>'billing_address',
    'merge_filter' => 'enabled',
  ),
  'billing_address_city' => 
  array (
    'name' => 'billing_address_city',
    'vname' => 'LBL_BILLING_ADDRESS_CITY',
    'type' => 'varchar',
    'len' => '100',
    'comment' => 'The city used for billing address',
    'group'=>'billing_address',
    'merge_filter' => 'enabled',
  ),
  'billing_address_state' => 
  array (
    'name' => 'billing_address_state',
    'vname' => 'LBL_BILLING_ADDRESS_STATE',
    'type' => 'varchar',
    'len' => '100',
    'group'=>'billing_address',
    'comment' => 'The state used for billing address',
    'merge_filter' => 'enabled',
  ),
  'billing_address_postalcode' => 
  array (
    'name' => 'billing_address_postalcode',
    'vname' => 'LBL_BILLING_ADDRESS_POSTALCODE',
    'type' => 'varchar',
    'len' => '20',
    'group'=>'billing_address',
    'comment' => 'The postal code used for billing address',
    'merge_filter' => 'enabled',
    
  ),
  'billing_address_country' => 
  array (
    'name' => 'billing_address_country',
    'vname' => 'LBL_BILLING_ADDRESS_COUNTRY',
    'type' => 'varchar',
    'group'=>'billing_address',
    'comment' => 'The country used for the billing address',
    'merge_filter' => 'enabled',
  ),
  
    'shipping_address_street' => 
  array (
    'name' => 'shipping_address_street',
    'vname' => 'LBL_SHIPPING_ADDRESS_STREET',
    'type' => 'varchar',
    'len' => 150,
    'group'=>'shipping_address',
    'comment' => 'The street address used for for shipping purposes',
    'merge_filter' => 'enabled',
  ),
  'shipping_address_city' => 
  array (
    'name' => 'shipping_address_city',
    'vname' => 'LBL_SHIPPING_ADDRESS_CITY',
    'type' => 'varchar',
    'len' => 100,
    'group'=>'shipping_address',
    'comment' => 'The city used for the shipping address',
    'merge_filter' => 'enabled',
  ),
  'shipping_address_state' => 
  array (
    'name' => 'shipping_address_state',
    'vname' => 'LBL_SHIPPING_ADDRESS_STATE',
    'type' => 'varchar',
    'len' => 100,
    'group'=>'shipping_address',
    'comment' => 'The state used for the shipping address',
    'merge_filter' => 'enabled',
  ),
  'shipping_address_postalcode' => 
  array (
    'name' => 'shipping_address_postalcode',
    'vname' => 'LBL_SHIPPING_ADDRESS_POSTALCODE',
    'type' => 'varchar',
    'len' => 20,
    'group'=>'shipping_address',
    'comment' => 'The zip code used for the shipping address',
    'merge_filter' => 'enabled',
  ),
  'shipping_address_country' => 
  array (
    'name' => 'shipping_address_country',
    'vname' => 'LBL_SHIPPING_ADDRESS_COUNTRY',
    'type' => 'varchar',
    'group'=>'shipping_address',
    'comment' => 'The country used for the shipping address',
    'merge_filter' => 'enabled',
  ),
  
  'number' => 
  array (
    'required' => false,
    'name' => 'number',
    'vname' => 'LBL_INVOICE_NUMBER',
    'type' => 'varchar',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => 0,
    'reportable' => 0,
    'len' => '50',
  ),
  'total_amt' => 
  array (
    'required' => false,
    'name' => 'total_amt',
    'vname' => 'LBL_TOTAL_AMT',
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
  ),
  'subtotal_amount' => 
  array (
    'required' => false,
    'name' => 'subtotal_amount',
    'vname' => 'LBL_SUBTOTAL_AMOUNT',
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
  ),
  'discount_amount' => 
  array (
    'required' => false,
    'name' => 'discount_amount',
    'vname' => 'LBL_DISCOUNT_AMOUNT',
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
  ),
  'tax_amount' => 
  array (
    'required' => false,
    'name' => 'tax_amount',
    'vname' => 'LBL_TAX_AMOUNT',
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
  ),
  'shipping_amount' => 
  array (
    'required' => false,
    'name' => 'shipping_amount',
    'vname' => 'LBL_SHIPPING_AMOUNT',
    'type' => 'currency',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => 0,
    'reportable' => 0,
    'len' => 26,
  ),
  'total_amount' => 
  array (
    'required' => false,
    'name' => 'total_amount',
    'vname' => 'LBL_GRAND_TOTAL',
    'type' => 'currency',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => false,
    'reportable' => true,
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
    'audited' => false,
    'reportable' => true,
    'len' => 36,
    'size' => '20',
    'studio' => 'visible',
    'function' => 
    array (
      'name' => 'getCurrencyDropDown',
      'returns' => 'html',
    ),
  ),
  'quote_number' => 
  array (
    'required' => false,
    'name' => 'quote_number',
    'vname' => 'LBL_QUOTE_NUMBER',
    'type' => 'int',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => 1,
    'reportable' => 0,
    'len' => '11',
    'disable_num_format' => '',
  ),
  'quote_date' => 
  array (
    'required' => false,
    'name' => 'quote_date',
    'vname' => 'LBL_QUOTE_DATE',
    'type' => 'date',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => 0,
    'reportable' => 0,
    'display_default' => 'now',
    'enable_range_search' => true,
    'options' => 'date_range_search_dom',
  ),
  'invoice_date' => 
  array (
    'required' => false,
    'name' => 'invoice_date',
    'vname' => 'LBL_INVOICE_DATE',
    'type' => 'date',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => 0,
    'reportable' => 0,
    'display_default' => 'now',
    'enable_range_search' => true,
    'options' => 'date_range_search_dom',
  ),
  'due_date' => 
  array (
    'required' => false,
    'name' => 'due_date',
    'vname' => 'LBL_DUE_DATE',
    'type' => 'date',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => '0',
    'audited' => 0,
    'reportable' => 0,
    'enable_range_search' => true,
    'options' => 'date_range_search_dom',
  ),
  'status' => 
  array (
    'required' => false,
    'name' => 'status',
    'vname' => 'LBL_STATUS',
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
    'options' => 'invoice_status_dom',
    'studio' => 'visible',
  ),
  'template_ddown_c' => 
  array (
    'required' => '1',
    'name' => 'template_ddown_c',
    'vname' => 'LBL_TEMPLATE_DDOWN_C',
    'type' => 'multienum',
    'massupdate' => 0,
    'comments' => '',
    'help' => '',
    'importable' => 'true',
    'duplicate_merge' => 'disabled',
    'duplicate_merge_dom_value' => 0,
    'audited' => 0,
    'reportable' => 0,
    'len' => 255,
    'options' => 'template_ddown_c_list',
    'studio' => 'visible',
    'isMultiSelect' => true,
  ),
  'subtotal_tax_amount' => 
  array (
    'required' => false,
    'name' => 'subtotal_tax_amount',
    'vname' => 'LBL_SUBTOTAL_TAX_AMOUNT',
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
  ),
  
  'aos_quotes_aos_invoices' =>
   array (
  	'name' => 'aos_quotes_aos_invoices',
  	'type' => 'link',
  	'relationship' => 'aos_quotes_aos_invoices',
  	'source' => 'non-db',
  	'module'=>'AOS_Quotes',
  ),
  'aos_products_quotes' =>
  array (
	'name' => 'aos_products_quotes',
	'type' => 'link',
	'relationship' => 'aos_invoices_aos_product_quotes',
	'module'=>'AOS_Products_Quotes',
	'bean_name'=>'AOS_Products_Quotes',
	'source'=>'non-db',
 ),
 
),
'relationships'=>array (
	'aos_invoices_aos_product_quotes' =>
	 array (
		'lhs_module'=> 'AOS_Invoices', 
		'lhs_table'=> 'aos_invoices', 
		'lhs_key' => 'id',
		'rhs_module'=> 'AOS_Products_Quotes', 
		'rhs_table'=> 'aos_products_quotes', 
		'rhs_key' => 'parent_id',
		'relationship_type'=>'one-to-many',
	),
),
	'optimistic_lock'=>true,
);
require_once('include/SugarObjects/VardefManager.php');
VardefManager::createVardef('AOS_Invoices','AOS_Invoices', array('basic','assignable'));
