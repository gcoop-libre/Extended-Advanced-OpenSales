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

/**
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */
require_once('modules/AOS_Invoices/AOS_Invoices_sugar.php');
class AOS_Invoices extends AOS_Invoices_sugar {
	
	function AOS_Invoices(){	
		parent::AOS_Invoices_sugar();
	}
	
	function save($check_notify = FALSE){
		// If new or duplicate entry, get a quote number otherwise already set.
		$this->number = (empty($this->id)) ? $this->db->getOne("SELECT count(id)+1 FROM aos_invoices"): $this->number;
		
		parent::save($check_notify);
		if(isset($_POST['product_id']) && !empty($_POST['product_id'])){
			$this->saveListItems();
		}
	}
	
	function saveListItems(){
		require_once('modules/AOS_Products_Quotes/AOS_Products_Quotes.php');
		$productQuote = new AOS_Products_Quotes();

		$product = array('id' => $_POST['product_quote_id'],
						 'product_id' => $_POST['product_id'],
						 'product_name' => $_POST['product_name'],
						 'product_qty' => $_POST['product_qty'],
						 'vat'=>$_POST['vat'],
						 'vat_amt' => $_POST['vat_amt'],
						 'product_cost_price' => $_POST['product_cost_price'],				 
						 'product_list_price' => $_POST['product_list_price'],
						 'product_discount' => $_POST['product_discount'],
						 'product_discount_amount' => $_POST['product_discount_amount'],
						 'discount' => $_POST['discount'],
						 'product_unit_price' => $_POST['product_unit_price'],
						 'product_total_price' => $_POST['product_total_price'],
						 'product_note' => $_POST['product_note'],
						 'product_deleted' => $_POST['product_deleted']);
							 
		$productLineCount = count($product['product_id']);
		
		for ($i = 0; $i < 1; $i++) {
			$productQuote->id = $product['id'][$i];
			$productQuote->parent_id = $this->id;
			$productQuote->parent_type = 'AOS_Invoices';
			$productQuote->product_id = $product['product_id'][$i];
			$productQuote->name = stripslashes($product['product_name'][$i]);
			$productQuote->product_qty = $product['product_qty'][$i];
			$productQuote->product_cost_price = $product['product_cost_price'][$i];
			$productQuote->product_list_price = $product['product_list_price'][$i];
			$productQuote->product_discount = $product['product_discount'][$i];
			$productQuote->product_discount_amount = $product['product_discount_amount'][$i];
			$productQuote->discount = $product['discount'][$i];
			$productQuote->product_unit_price = $product['product_unit_price'][$i];
			$productQuote->vat = $product['vat'][$i];
			$productQuote->vat_amt = $product['vat_amt'][$i];	
			$productQuote->product_total_price = $product['product_total_price'][$i];
			$productQuote->description = stripslashes($product['product_note'][$i]);
			$productQuote->deleted = $product['product_deleted'][$i];
			
			if ($productQuote->deleted == 1) {
				$productQuote->mark_deleted($productQuote->id);
			} else {
				if(trim($productQuote->product_id) != '' && trim($productQuote->name) != '' && trim($productQuote->product_unit_price) != ''){
					$productQuote->save();
				}
			}
		}
		for ($i = 1; $i < $productLineCount; $i++) {
			$productQuote->id = $product['id'][$i];
			$productQuote->parent_id = $this->id;
			$productQuote->parent_type = 'AOS_Invoices';
			$productQuote->product_id = $product['product_id'][$i];
			$productQuote->name = stripslashes($product['product_name'][$i]);
			$productQuote->product_qty = $product['product_qty'][$i];
			$productQuote->product_cost_price = $product['product_cost_price'][$i];
			$productQuote->product_list_price = unformat_number($product['product_list_price'][$i]);
			$productQuote->product_discount = unformat_number($product['product_discount'][$i]);
			$productQuote->product_discount_amount = unformat_number($product['product_discount_amount'][$i]);
			$productQuote->discount = $product['discount'][$i];
			$productQuote->product_unit_price = unformat_number($product['product_unit_price'][$i]);
			$productQuote->vat = $product['vat'][$i];
			$productQuote->vat_amt = unformat_number($product['vat_amt'][$i]);	
			$productQuote->product_total_price = unformat_number($product['product_total_price'][$i]);
			$productQuote->description = stripslashes($product['product_note'][$i]);
			$productQuote->deleted = $product['product_deleted'][$i];
			
			if ($productQuote->deleted == 1) {
				$productQuote->mark_deleted($productQuote->id);
			} else {
				if(trim($productQuote->product_id) != '' && trim($productQuote->name) != '' && trim($productQuote->product_unit_price) != ''){
					$productQuote->save();
				}
			}
		}
	}
}
?>
