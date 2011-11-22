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
	require_once('modules/AOS_Quotes/AOS_Quotes.php');
	require_once('modules/AOS_Invoices/AOS_Invoices.php');
	require_once('modules/AOS_Products_Quotes/AOS_Products_Quotes.php');
	
	global $timedate;
	//Setting values in Quotes
	$quote = new AOS_Quotes();
	$quote->retrieve($_REQUEST['record']);
	$quote->invoice_status = 'Invoiced';
	$quote->total_amt = format_number($quote->total_amt);
	$quote->discount_amount = format_number($quote->discount_amount);
	$quote->subtotal_amount = format_number($quote->subtotal_amount);
	$quote->tax_amount = format_number($quote->tax_amount);
	if($quote->shipping_amount != null)
	{
		$quote->shipping_amount = format_number($quote->shipping_amount);
	}
	$quote->total_amount = format_number($quote->total_amount);
	$quote->save();
	
	//Setting Invoice Values
	$invoice = new AOS_Invoices();
	$rawRow = $quote->fetched_row;
	$rawRow['id'] = '';
	$rawRow['template_ddown_c'] = ' ';
	$rawRow['quote_number'] = $rawRow['number'];
	$rawRow['number'] = '';
	$rawRow['quote_date'] = $timedate->to_display_date_time($rawRow['date_entered'],true,false);
	$rawRow['invoice_date'] = $timedate->to_display_date_time(date('Y-m-d h:i:s'),true,false);
	$rawRow['total_amt'] = format_number($rawRow['total_amt']);
	$rawRow['discount_amount'] = format_number($rawRow['discount_amount']);
	$rawRow['subtotal_amount'] = format_number($rawRow['subtotal_amount']);
	$rawRow['tax_amount'] = format_number($rawRow['tax_amount']);
	$rawRow['date_entered'] = $rawRow['invoice_date'];
	$rawRow['date_modified'] = $rawRow['invoice_date'];
	if($rawRow['shipping_amount'] != null)
	{
		$rawRow['shipping_amount'] = format_number($rawRow['shipping_amount']);
	}
	$rawRow['total_amount'] = format_number($rawRow['total_amount']);
	$invoice->populateFromRow($rawRow);
	$invoice->save();
	
	//Setting invoice quote relationship
	require_once('modules/Relationships/Relationship.php');
	$key = Relationship::retrieve_by_modules('AOS_Quotes', 'AOS_Invoices', $GLOBALS['db']);
	if (!empty($key)) {
		$quote->load_relationship($key);
		$quote->$key->add($invoice->id);
	} 
	
	//Setting Line Items
	$sql = "SELECT * FROM aos_products_quotes WHERE parent_type = 'AOS_Quotes' AND parent_id = '".$quote->id."' AND deleted = 0";
  	$result = $this->bean->db->query($sql);
	while ($row = $this->bean->db->fetchByAssoc($result)) {
		$row['id'] = '';
		$row['parent_id'] = $invoice->id;
		$row['parent_type'] = 'AOS_Invoices';
		if($row['product_cost_price'] != null)
		{
			$row['product_cost_price'] = format_number($row['product_cost_price']);
		}
		$row['product_list_price'] = format_number($row['product_list_price']);
		if($row['product_discount'] != null)
		{
			$row['product_discount'] = format_number($row['product_discount']);
			$row['product_discount_amount'] = format_number($row['product_discount_amount']);
		}
		$row['product_unit_price'] = format_number($row['product_unit_price']);
		$row['vat_amt'] = format_number($row['vat_amt']);
		$row['product_total_price'] = format_number($row['product_total_price']);
		$row['product_qty'] = format_number($row['product_qty']);
		$prod_invoice = new AOS_Products_Quotes();
		$prod_invoice->populateFromRow($row);
		$prod_invoice->save();
	}
	ob_clean();
	header('Location: index.php?module=AOS_Invoices&action=DetailView&record='.$invoice->id);
?>
