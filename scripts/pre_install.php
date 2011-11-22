<?php
if (! defined('sugarEntry') || ! sugarEntry)
    die('Not A Valid Entry Point');


function pre_install() {
	require_once('include/utils/array_utils.php');
	require_once('include/utils/file_utils.php');
	require_once('include/utils/sugar_file_utils.php');
	
	
	$modules_array = array('Accounts','Contacts','Leads');
	
	foreach($modules_array as $module){

	$file = "custom/modules/$module/metadata/detailviewdefs.php";
	if(file_exists($file)){
		$old_contents = file_get_contents($file);
	}else{
		$old_contents = file_get_contents("modules/$module/metadata/detailviewdefs.php");
		create_custom_directory("modules/$module/metadata/detailviewdefs.php");
	}
	 	
	 	include($file);
	 
	 	if(!isset($viewdefs[$module]['DetailView']['templateMeta']['form']['buttons']['AOS_GENLET'])) {
     
		$new_contents = "\$viewdefs['$module']['DetailView']['templateMeta']['form']['buttons']['AOS_GENLET'] = array('customCode'=>'<input type=\"button\" class=\"button\" onClick=\"showPopup();\" value=\"{\$APP.LBL_GENERATE_LETTER}\">');\n?>";
        	
		$new_contents = str_replace("?>",$new_contents,$old_contents);
		$fp = sugar_fopen($file, 'wb');
		fwrite($fp,$new_contents);
		fclose($fp);
		
		}

	}



	/** add following:
	$entry_point_registry['formLetter'] = array('file' => 'modules/AOS_PDF_Templates/formLetterPdf.php', 'auth' => true);
	$entry_point_registry['generatePdf'] = array('file' => 'modules/AOS_PDF_Templates/generatePdf.php', 'auth' => true);
	*/

    $add_entry_point = false;
    $new_contents = "";
    $entry_point_registry = null;
    if(file_exists("custom/include/MVC/Controller/entry_point_registry.php")){

        // This will load an array of the hooks to process
        include("custom/include/MVC/Controller/entry_point_registry.php");

        
        if(!isset($entry_point_registry['formLetter'])) {
            $add_entry_point = true;
            $entry_point_registry['formLetter'] = array('file' => 'modules/AOS_PDF_Templates/formLetterPdf.php', 'auth' => true);
        }
        if(!isset($entry_point_registry['generatePdf'])) {
            $add_entry_point = true;
            $entry_point_registry['generatePdf'] = array('file' => 'modules/AOS_PDF_Templates/generatePdf.php', 'auth' => true);
        }
    } else {
        $add_entry_point = true;    
        $entry_point_registry['formLetter'] = array('file' => 'modules/AOS_PDF_Templates/formLetterPdf.php', 'auth' => true);
        $entry_point_registry['generatePdf'] = array('file' => 'modules/AOS_PDF_Templates/generatePdf.php', 'auth' => true);
    }
    if($add_entry_point == true){

        foreach($entry_point_registry as $entryPoint => $epArray){
            $new_contents .= "\$entry_point_registry['".$entryPoint."'] = array('file' => '".$epArray['file']."' , 'auth' => '".$epArray['auth']."'); \n";
        }
        
        $new_contents = "<?php\n$new_contents\n?>";
        $file = 'custom/include/MVC/Controller/entry_point_registry.php';
        $paths = explode('/',$file);
        $dir = '';
        for($i = 0; $i < sizeof($paths) - 1; $i++)
        {
            if($i > 0) $dir .= '/';
            $dir .= $paths[$i];
            if(!file_exists($dir))
            {
                sugar_mkdir($dir, 0755);
            }
        }
        $fp = sugar_fopen($file, 'wb');
        fwrite($fp,$new_contents);
        fclose($fp);
    }
}
?>
