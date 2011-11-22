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
require_once('modules/AOS_Contracts/AOS_Contracts_sugar.php');
class AOS_Contracts extends AOS_Contracts_sugar {
	
	function AOS_Contracts(){	
		parent::AOS_Contracts_sugar();
	}
	
	function save($check_notify = FALSE){
			
		if(isset($_POST['renewal_reminder_date']) && !empty($_POST['renewal_reminder_date'])){
			$this->createReminder();
		}
		
		parent::save($check_notify);
		
		if(isset($_POST['renewal_reminder_date']) && !empty($_POST['renewal_reminder_date'])){
			$this->createLink();
		}

	}
	
	function mark_deleted($id)
	{
		parent::mark_deleted($id);
		$this->deleteCall();
	}
	
	function createReminder(){
	require_once('modules/Calls/Call.php');
	$call = new call();
	
			if($this->renewal_reminder_date != 0){
			
				$call->id = $this->call_id;
				$call->parent_id = $this->id;
				$call->parent_type = 'AOS_Contracts';
				$call->date_start = $this->renewal_reminder_date;
				$call->name = $this->name . ' Contract Renewal Reminder';
				$call->assigned_user_id = $this->assigned_user_id;
				$call->status = 'Planned';
				$call->direction = 'Outbound';
				$call->reminder_time = 60;
				$call->duration_hours = 0;
				$call->duration_minutes = 30;
				$call->deleted = 0;
				$call->save();
				$this->call_id = $call->id;
			}
	}
	
	function createLink(){
	require_once('modules/Calls/Call.php');
	$call = new call();
	
		if($this->renewal_reminder_date != 0){
				$call->id = $this->call_id;
				$call->parent_id = $this->contract_account_id;
				$call->parent_type = 'Accounts';
				$call->reminder_time = 60;
				$call->save();
			}
	}
	
	function deleteCall(){
	require_once('modules/Calls/Call.php');
	$call = new call();
	
		if($this->call_id != null){
				$call->id = $this->call_id;
				$call->mark_deleted($call->id);
				}
	}
	
}
?>
