<?php
if (! defined('sugarEntry') || ! sugarEntry)
    die('Not A Valid Entry Point');


function pre_uninstall() {
    	require_once('include/utils/array_utils.php');
	require_once('include/utils/file_utils.php');
	require_once('include/utils/sugar_file_utils.php');
    	
    	$modules_array = array('Accounts','Contacts','Leads');
	
	foreach($modules_array as $module){

	$file = "custom/modules/$module/metadata/detailviewdefs.php";
	if(file_exists($file)){
	 	
	 	include($file);
	 
	 	if(isset($viewdefs[$module]['DetailView']['templateMeta']['form']['buttons']['AOS_GENLET'])) {
	 		unset($viewdefs[$module]['DetailView']['templateMeta']['form']['buttons']['AOS_GENLET']);
	 		$new_contents = file_get_contents($file);
	 		$old_contents_v1 = "\$viewdefs['$module']['DetailView']['templateMeta']['form']['buttons']['AOS_GENLET'] = array('customCode'=>'<input type=\"button\" class=\"button\" onClick=\"showPopup();\" value=\"{\$APP.LBL_GENERATE_LETTER}\">');";
			$old_contents_v2 = "customCode' => '<input type=\"button\" class=\"button\" onClick=\"showPopup();\" value=\"{\$APP.LBL_GENERATE_LETTER}\">";
			$new_contents = str_replace($old_contents_v1,"",$new_contents);
			$new_contents = str_replace($old_contents_v2,"",$new_contents);
			$new_contents = str_replace("AOS_GENLET","",$new_contents);
			$fp = sugar_fopen($file, 'wb');
			fwrite($fp,$new_contents);
			fclose($fp);
		}
	}

	}
    	
    	
    	/** remove following:
	$entry_point_registry['formLetter'] = array('file' => 'modules/AOS_PDF_Templates/formLetterPdf.php', 'auth' => true);
	$entry_point_registry['generatePdf'] = array('file' => 'modules/AOS_PDF_Templates/generatePdf.php', 'auth' => true);
    	*/
    $remove_entry_point = false;
    $new_contents = "";
    $entry_point_registry = null;
    if(file_exists("custom/include/MVC/Controller/entry_point_registry.php")){
    
        include("custom/include/MVC/Controller/entry_point_registry.php");

        if(isset($entry_point_registry['formLetter'])) {
            $remove_entry_point = true;
            unset($entry_point_registry['formLetter']);
        }
        if(isset($entry_point_registry['generatePdf'])) {
            $remove_entry_point = true;
            unset($entry_point_registry['generatePdf']);
        }
        if($remove_entry_point == true){        
        
            foreach($entry_point_registry as $entryPoint => $epArray){
                $new_contents .= "\$entry_point_registry['".$entryPoint."'] = array('file' => '".$epArray['file']."' , 'auth' => '".$epArray['auth']."'); \n";
            }
            $new_contents = "<?php\n$new_contents\n?>";
            $file = 'custom/include/MVC/Controller/entry_point_registry.php';
            $fp = sugar_fopen($file, 'wb');
            fwrite($fp,$new_contents);
            fclose($fp);
        }
        
    }    
}
?>
