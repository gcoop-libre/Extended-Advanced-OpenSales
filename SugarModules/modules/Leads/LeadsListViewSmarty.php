<?php
require_once('include/ListView/ListViewSmarty.php');
require_once('modules/AOS_PDF_Templates/formLetter.php');

class LeadsListViewSmarty extends ListViewSmarty {

        function LeadsListViewSmarty(){
                parent::ListViewSmarty();
        }

	function process($file, $data, $htmlVar) {
		parent::process($file, $data, $htmlVar);

        	if(!ACLController::checkAccess($this->seed->module_dir,'export',true) || !$this->export) {
			$this->ss->assign('exportLink', $this->buildExportLink());
		}
	}

	function buildExportLink($id = 'export_link'){
		$script = "";
		if(ACLController::checkAccess($this->seed->module_dir,'export',true)) {
			if($this->export) {
                		$script = parent::buildExportLink($id);
            		}
        	}
		return $script.formLetter::LVSmarty();
	}
}

?>
