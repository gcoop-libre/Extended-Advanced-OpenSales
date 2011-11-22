<?php

function post_install() {

	if (strtolower($_POST['mode']) == 'install') {
	
		$modules = array('AOS_Contracts','AOS_Invoices','AOS_PDF_Templates','AOS_Products','AOS_Products_Quotes','AOS_Quotes');
		
		$actions = array('clearAll','rebuildAuditTables','rebuildExtensions','repairDatabase');

		require_once('modules/Administration/QuickRepairAndRebuild.php');
		$randc = new RepairAndClear();
		$randc->repairAndClearAll($actions, $modules, true,false);
		
		require_once('modules/ACL/install_actions.php');

	}
		
}
?>
