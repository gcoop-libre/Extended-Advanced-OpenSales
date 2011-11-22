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
 
require_once('include/MVC/Controller/SugarController.php');

class AOS_QuotesController extends SugarController {
	function action_editview() {
		global $mod_string;

		$this->view = 'edit';
		$GLOBALS['view'] = $this->view;
		
		if (isset($_REQUEST['aos_invoices_id'])) {
            		$query = "SELECT * FROM aos_invoices WHERE id = '{$_REQUEST['aos_invoices_id']}'";
            		$result = $this->bean->db->query($query, true);
            		$row = $this->bean->db->fetchByAssoc($result);
            		$this->bean->name = $row['name'];
            
			if (isset($row['billing_account_id'])) {
			$_REQUEST['account_id'] = $row['billing_account_id'];
        		}
        		
        		if (isset($row['billing_contact_id'])) {
        		$_REQUEST['contact_id'] = $row['billing_contact_id'];
        		}
        	}
		
        	if (isset($_REQUEST['aos_contracts_id'])) {
            		$query = "SELECT * FROM aos_contracts WHERE id = '{$_REQUEST['aos_contracts_id']}'";
            		$result = $this->bean->db->query($query, true);
            		$row = $this->bean->db->fetchByAssoc($result);
            		$this->bean->name = $row['name'];
            
			if (isset($row['contract_account_id'])) {
			$_REQUEST['account_id'] = $row['contract_account_id'];
        		}
        		
        		if (isset($row['opportunity_id'])) {
        		$_REQUEST['opportunity_id'] = $row['opportunity_id'];
        		}
        	}


		if (isset($_REQUEST['account_id'])) {
            		$query = "SELECT * FROM accounts WHERE id = '{$_REQUEST['account_id']}'";
			$result = $this->bean->db->query($query, true);
			$row = $this->bean->db->fetchByAssoc($result);
			$this->bean->billing_account_id = $row['id'];
			$this->bean->billing_account = $row['name'];
			$this->bean->billing_address_street = $row['billing_address_street'];
			$this->bean->billing_address_city = $row['billing_address_city'];
			$this->bean->billing_address_state = $row['billing_address_state'];
			$this->bean->billing_address_postalcode = $row['billing_address_postalcode'];
			$this->bean->billing_address_country = $row['billing_address_country'];
			$this->bean->shipping_address_street = $row['shipping_address_street'];
			$this->bean->shipping_address_city = $row['shipping_address_city'];
			$this->bean->shipping_address_state = $row['shipping_address_state'];
			$this->bean->shipping_address_postalcode = $row['shipping_address_postalcode'];
			$this->bean->shipping_address_country = $row['shipping_address_country'];
		}	
		
		if (isset($_REQUEST['contact_id'])) {
            		$query = "SELECT id,first_name,last_name FROM contacts WHERE id = '{$_REQUEST['contact_id']}'";
			$result = $this->bean->db->query($query, true);
			$row = $this->bean->db->fetchByAssoc($result);
			$this->bean->billing_contact_id = $row['id'];
			$this->bean->billing_contact = $row['first_name'].' '.$row['last_name'];
		}
		
		if (isset($_REQUEST['opportunity_id'])) {
            		$query = "SELECT id,name FROM opportunities WHERE id = '{$_REQUEST['opportunity_id']}'";
            		$result = $this->bean->db->query($query, true);
            		$row = $this->bean->db->fetchByAssoc($result);
            		$this->bean->opportunity_id = $row['id'];
            		$this->bean->opportunity = $row['name'];
        	}
        	
    	}

}

?> 
