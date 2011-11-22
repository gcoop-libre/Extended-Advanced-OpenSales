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
	require_once('modules/AOS_Contracts/AOS_Contracts.php');
	
	//Setting values in Quotes
	$quote = new AOS_Quotes();
	$quote->retrieve($_REQUEST['record']);
	
	//Setting Contract Values
	$contract = new AOS_Contracts();
	$contract->name = $quote->name;
	$contract->assigned_user_id = $quote->assigned_user_id;
	$contract->total_contract_value = format_number($quote->total_amount);
	$contract->contract_account_id = $quote->billing_account_id;
	$contract->opportunity_id = $quote->opportunity_id;
	$contract->save();
	
	//Setting contract quote relationship
	require_once('modules/Relationships/Relationship.php');
	$key = Relationship::retrieve_by_modules('AOS_Quotes', 'AOS_Contracts', $GLOBALS['db']);
	if (!empty($key)) {
		$quote->load_relationship($key);
		$quote->$key->add($contract->id);
	} 
	ob_clean();
	header('Location: index.php?module=AOS_Contracts&action=EditView&record='.$contract->id);
?>
