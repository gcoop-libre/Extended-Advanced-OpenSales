<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/views/view.edit.php');

class AOS_PDF_TemplatesViewEdit extends ViewEdit {
	function AOS_PDF_TemplatesViewEdit(){
 		parent::ViewEdit();
 	}
	
	function display(){
		$this->displayJSInclude();
		$this->setFields();
		parent::display();
		$this->displayJS();
	}
	
	function displayJSInclude(){
		echo '
			<script type="text/javascript" language="Javascript" src="include/JSON.js"></script>
			<script type="text/javascript" language="Javascript" src="include/javascript/tiny_mce/tiny_mce.js"></script>
			<link type="text/css" href="include/javascript/tiny_mce/advanced/css/editor_ui.css" />
			<script type="text/javascript" language="Javascript">
			
			var selected = 0;

			function showVariable(fld){
				document.getElementById(\'variable_text\').value=fld;
			}
			
			function setType(type){
				document.getElementById("type").value = type;
				populateModuleVariables(type);
			}

			function populateVariables(type){
				options = quoteOptions;
				if(type == \'Quotes\'){
					options = quoteOptions;
				}else if(type == \'Invoices\'){
					options = invoiceOptions;
				}else if(type == \'Accounts\'){
					options = accountOptions;
				}else if(type == \'Contacts\'){
					options = contactOptions;
				}else if(type == \'Leads\'){
					options = leadOptions;
				}else if(type == \'Users\'){
					options = userOptions;
				}else if(type == \'Products\'){
					options = productOptions;
				}else if(type == \'Services\'){
					options = serviceOptions;
				}else{
					options = quoteOptions;
				}
				for(i=0;i<document.getElementById(\'variable_name\').options.length;i++){
					document.getElementById(\'variable_name\').remove(0);
				} 
				document.getElementById(\'variable_name\').innerHTML = options;
				document.getElementById(\'variable_name\').options.selectedIndex =0;
				document.getElementById(\'variable_text\').value = \'\';
			}
			
			function populateModuleVariables(type){
				options = quoteModOptions;
				if(type == \'Quotes\'){
					options = quoteModOptions;
				}else if(type == \'Invoices\'){
					options = invoiceModOptions;
				}else if(type == \'Accounts\'){
					options = accountModOptions;
				}else if(type == \'Contacts\'){
					options = contactModOptions;
				}else if(type == \'Leads\'){
					options = leadModOptions;
				}else{
					options = quoteModOptions;
				}
				for(i=0;i<document.getElementById(\'module_name\').options.length;i++){
					document.getElementById(\'module_name\').remove(0);
				} 
				document.getElementById(\'module_name\').innerHTML = options;
				populateVariables(type);
			}

			function insert_variable(text) {
				if (text != \'\'){
    				var inst = tinyMCE.getInstanceById("description");
				if (inst) inst.getWin().focus();
					inst.execCommand(\'mceInsertContent\', false, text);
					inst.execCommand(\'mceToggleEditor\');
					inst.execCommand(\'mceToggleEditor\');
				}
			}

			function insertSample(smpl){
				if(smpl != 0){
				var body = tinyMCE.getInstanceById("description");
				var header = tinyMCE.getInstanceById("pdfheader");
				var footer = tinyMCE.getInstanceById("pdffooter");
				var cnf = true;
				if(body.getContent() != \'\' || header.getContent() != \'\' || footer.getContent() != \'\'){
					cnf=confirm(\'Warning this will overwrite you current Work\');
				}
				if(cnf){
				smpl = eval(smpl);
				setType(smpl[0]);
				body.setContent(smpl[1]);
				header.setContent(smpl[2]);
				footer.setContent(smpl[3]);
				selected = document.getElementById(\'sample\').options.selectedIndex;
				}
				else{
				document.getElementById(\'sample\').options.selectedIndex =selected;
				}
			}
		}
			</script>';
	}
	
	function setFields(){
		global $app_list_strings, $mod_strings;
		//Setting type Field
		$this->ss->assign('CUSTOM_TYPE','<select id="type" name="type" onchange="populateModuleVariables(this.options[this.selectedIndex].value)">'.
							get_select_options($app_list_strings[$this->bean->field_defs['type']['options']],$this->bean->type).
							'</select>');
		
		//Loading Sample Files
		$json = getJSONobj();
		$samples;
		if ($handle = opendir('modules/AOS_PDF_Templates/samples')) {
		$sample_options_array[] = ' ';
			while (false !== ($file = readdir($handle))) {
				if($value = ltrim(rtrim($file,'.php'),'smpl_')){
					require_once('modules/AOS_PDF_Templates/samples/'.$file);
					$file = rtrim($file,'.php');
					$file = new $file();
					$fileArray =
					array(
					$file->getType(),
					$file->getBody(),
					$file->getHeader(),
					$file->getFooter()
					);
					
					$fileArray = $json->encode($fileArray);
					$value = $mod_strings['LBL_'.strtoupper($value)];
					$sample_options_array[$fileArray] = $value;
				}
    			}	
    		$samples = get_select_options($sample_options_array,'');
		closedir($handle);
		}
		
		$this->ss->assign('CUSTOM_SAMPLE','<select id="sample" name="sample" onchange="insertSample(this.options[this.selectedIndex].value)">'.
							$samples.
							'</select>');
							
		//Setting Insertable fields
		require_once('modules/AOS_Invoices/AOS_Invoices.php');
		require_once('modules/AOS_Quotes/AOS_Quotes.php');
		$account_options_array = array(''=>'');
		$contact_options_array = array(''=>'');
		$lead_options_array = array(''=>'');
		$user_options_array = array(''=>'');
		$quote_options_array = array(''=>'');
		$invoice_options_array = array(''=>'');
		$product_options_array = array(''=>'');
		$service_options_array = array(''=>'');
		
		//Getting Fields
		$account = new Account();
		foreach($account->field_defs as $name => $arr){
			if(!((isset($arr['dbType']) && strtolower($arr['dbType']) == 'id') || $arr['type'] == 'id' || $arr['type'] == 'link')){
				if($arr['vname'] != 'LBL_DELETED'){
				$account_options_array['$accounts_'.$name] = translate($arr['vname'],'Accounts');
				}
			}
		}
		
		$contact = new Contact();
		foreach($contact->field_defs as $name => $arr){
			if(!((isset($arr['dbType']) && strtolower($arr['dbType']) == 'id') || $arr['type'] == 'id' || $arr['type'] == 'link')){
				if($arr['vname'] != 'LBL_DELETED'){
				$contact_options_array['$contacts_'.$name] = translate($arr['vname'],'Contacts');
				}
			}
		}
		
		$lead = new Lead();
		foreach($lead->field_defs as $name => $arr){
			if(!((isset($arr['dbType']) && strtolower($arr['dbType']) == 'id') || $arr['type'] == 'id' || $arr['type'] == 'link')){
				if($arr['vname'] != 'LBL_DELETED'){
				$lead_options_array['$leads_'.$name] = translate($arr['vname'],'Leads');
				}
			}
		}
		
		$user = new User();
		foreach($user->field_defs as $name => $arr){
			if(!((isset($arr['dbType']) && strtolower($arr['dbType']) == 'id') || $arr['type'] == 'id' || $arr['type'] == 'link' || $arr['type'] == 'bool' || $arr['type'] == 'datetime' || $arr['link_type'] == 'relationship_info')){
				if($arr['vname'] != 'LBL_DELETED' && $arr['vname'] != 'LBL_USER_HASH' && $arr['vname'] != 'LBL_LIST_ACCEPT_STATUS' && $arr['vname'] != 'LBL_AUTHENTICATE_ID' && $arr['vname'] != 'LBL_MODIFIED_BY' && $arr['name'] != 'created_by_name'){
				$user_options_array['$users_'.$name] = translate($arr['vname'],'Users');
				}
			}
		}
		
		$quote = new AOS_Quotes();
		foreach($quote->field_defs as $name => $arr){
			if(!((isset($arr['dbType']) && strtolower($arr['dbType']) == 'id') || $arr['type'] == 'id' || $arr['type'] == 'link')){
				if($arr['vname'] != 'LBL_DELETED'){
				$quote_options_array['$aos_quotes_'.$name] = translate($arr['vname'],'AOS_Quotes');
				}
			}
		}
		
		$invoice = new AOS_Invoices();
		foreach($invoice->field_defs as $name => $arr){
			if(!((isset($arr['dbType']) && strtolower($arr['dbType']) == 'id') || $arr['type'] == 'id' || $arr['type'] == 'link')){
				if($arr['vname'] != 'LBL_DELETED'){
				$invoice_options_array['$aos_invoices_'.$name] = translate($arr['vname'],'AOS_Invoices');
				}
			}
		}
		
		$product_quote = new AOS_Products_Quotes();
		foreach($product_quote->field_defs as $name => $arr){
			if(!((isset($arr['dbType']) && strtolower($arr['dbType']) == 'id') || $arr['type'] == 'id' || $arr['type'] == 'link')){
				if($arr['vname'] != 'LBL_DELETED' && $arr['vname'] != 'LBL_PRODUCT' 
				&& $arr['vname'] != 'LBL_DATE_ENTERED' && $arr['vname'] != 'LBL_DATE_MODIFIED'
				&& $arr['vname'] != 'LBL_MODIFIED_NAME' && $arr['vname'] != 'LBL_CREATED'
				&& $arr['vname'] != 'LBL_ASSIGNED_TO_NAME'){
				$product_options_array['$aos_products_quotes_'.$name] = translate($arr['vname'],'AOS_Products_Quotes');
				}
			}
		}
		
		$product_quote = new AOS_Products();
		foreach($product_quote->field_defs as $name => $arr){
			if(!((isset($arr['dbType']) && strtolower($arr['dbType']) == 'id') || $arr['type'] == 'id' || $arr['type'] == 'link')){
				if($arr['vname'] != 'LBL_DELETED' && $arr['vname']  != 'LBL_NAME'){
				$product_options_array['$aos_products_'.$name] = translate($arr['vname'],'AOS_Products');
				}
			}
		}
		
		$service_options_array['$aos_services_quotes_name'] = translate('LBL_SERVICE_NAME','AOS_Quotes');
		$service_options_array['$aos_services_quotes_service_unit_price'] = translate('LBL_SERVICE_PRICE','AOS_Quotes');
		$service_options_array['$aos_services_quotes_vat_amt'] = translate('LBL_VAT_AMT','AOS_Quotes');
		$service_options_array['$aos_services_quotes_vat'] = translate('LBL_VAT','AOS_Quotes');
		$service_options_array['$aos_services_quotes_service_total_price'] = translate('LBL_TOTAL_PRICE','AOS_Quotes');
		
		
		$account_mod_options_array['Accounts'] = translate('LBL_MODULE_NAME','Accounts');
		
		$contact_mod_options_array['Contacts'] = translate('LBL_MODULE_NAME','Contacts');
		$contact_mod_options_array['Accounts'] = translate('LBL_MODULE_NAME','Accounts');
		
		$lead_mod_options_array['Leads'] = translate('LBL_MODULE_NAME','Leads');
		
		$quote_mod_options_array['Quotes'] = translate('LBL_MODULE_NAME','AOS_Quotes');
		$quote_mod_options_array['Products'] = translate('LBL_MODULE_NAME','AOS_Products');
		$quote_mod_options_array['Services'] = translate('LBL_SERVICE_MODULE_NAME','AOS_Products_Quotes');
		$quote_mod_options_array['Accounts'] = translate('LBL_MODULE_NAME','Accounts');
		$quote_mod_options_array['Contacts'] = translate('LBL_MODULE_NAME','Contacts');
		$quote_mod_options_array['Users'] = translate('LBL_MODULE_NAME','Users');
		
		$invoice_mod_options_array['Invoices'] = translate('LBL_MODULE_NAME','AOS_Invoices');
		$invoice_mod_options_array['Products'] = translate('LBL_MODULE_NAME','AOS_Products');
		$invoice_mod_options_array['Services'] = translate('LBL_SERVICE_MODULE_NAME','AOS_Products_Quotes');
		$invoice_mod_options_array['Accounts'] = translate('LBL_MODULE_NAME','Accounts');
		$invoice_mod_options_array['Contacts'] = translate('LBL_MODULE_NAME','Contacts');
		$invoice_mod_options_array['Users'] = translate('LBL_MODULE_NAME','Users');
		
		$account_options = get_select_options($account_options_array,'');
		$contact_options = get_select_options($contact_options_array,'');
		$lead_options = get_select_options($lead_options_array,'');
		$user_options = get_select_options($user_options_array,'');
		$quote_options = get_select_options($quote_options_array,'');
		$invoice_options = get_select_options($invoice_options_array,'');
		$product_options = get_select_options($product_options_array,'');
		$service_options = get_select_options($service_options_array,'');
		
		$account_module_options = get_select_options($account_mod_options_array,'');
		$contact_module_options = get_select_options($contact_mod_options_array,'');
		$lead_module_options = get_select_options($lead_mod_options_array,'');
		$quote_module_options = get_select_options($quote_mod_options_array,'');
		$invoice_module_options = get_select_options($invoice_mod_options_array,'');

		if($this->bean->type == 'Quotes'){
			$mod_options = $quote_module_options;
			$var_options = $quote_options;
		}else if($this->bean->type == 'Invoices'){
			$mod_options = $invoice_module_options;
			$var_options = $invoice_options;
		}else if($this->bean->type == 'Accounts'){
			$mod_options = $account_module_options;
			$var_options = $account_options;
		}else if($this->bean->type == 'Contacts'){
			$mod_options = $contact_module_options;
			$var_options = $contact_options;
		}else if($this->bean->type == 'Leads'){
			$mod_options = $lead_module_options;
			$var_options = $lead_options;
		}else{
			$mod_options = $quote_module_options;
			$var_options = $quote_options;
		}
		
		$account_options = ereg_replace( "\n", '', $account_options);
		$contact_options = ereg_replace( "\n", '', $contact_options);
		$lead_options = ereg_replace( "\n", '', $lead_options);
		$user_options = ereg_replace( "\n", '', $user_options);
		$quote_options = ereg_replace( "\n", '', $quote_options);
		$invoice_options = ereg_replace( "\n", '', $invoice_options);
		$product_options = ereg_replace( "\n", '', $product_options);
		$service_options = ereg_replace( "\n", '', $service_options);
		
		$account_module_options = ereg_replace( "\n", '', $account_module_options);
		$contact_module_options = ereg_replace( "\n", '', $contact_module_options);
		$lead_module_options = ereg_replace( "\n", '', $lead_module_options);
		$quote_module_options = ereg_replace( "\n", '', $quote_module_options);
		$invoice_module_options = ereg_replace( "\n", '', $invoice_module_options);
		
		$insert_fields = <<<HTML
		<select name='module_name' id='module_name' tabindex="50" onchange="populateVariables(this.options[this.selectedIndex].value);">
			$mod_options
		</select>
		<select name='variable_name' id='variable_name' tabindex="50" onchange="showVariable(this.options[this.selectedIndex].value);">
			$var_options
		</select>
		<input type="text" size="30" tabindex="60" name="variable_text" id="variable_text" />
		<input type='button' tabindex="70" onclick='insert_variable(document.EditView.variable_text.value);' class='button' value='Insert'>
		<script type="text/javascript">
			var quoteOptions = "$quote_options";
			var invoiceOptions = "$invoice_options";
			var accountOptions = "$account_options";
			var contactOptions = "$contact_options";
			var leadOptions = "$lead_options";
			var userOptions = "$user_options";
			var productOptions = "$product_options";
			var serviceOptions = "$service_options";
			
			var accountModOptions = "$account_module_options";
			var contactModOptions = "$contact_module_options";
			var leadModOptions = "$lead_module_options";
			var quoteModOptions = "$quote_module_options";
			var invoiceModOptions = "$invoice_module_options";
		</script>
HTML;
		$this->ss->assign('INSERT_FIELDS',$insert_fields);
	}
	
	function displayJS(){
		require_once("include/JSON.php");
		require_once("include/SugarTinyMCE.php");
		global $locale;
		
		$tiny = new SugarTinyMCE();
        	$tinyMCE = $tiny->getConfig();
		
		$locationHref = 'http://'.$_SERVER['HTTP_HOST'].substr($_SERVER['PHP_SELF'],0,strrpos($_SERVER['PHP_SELF'],'/'));
		$js =<<<JS
		<script language="javascript" type="text/javascript">
		$tinyMCE
		var location_href = '{$locationHref}';
		var df = '{$locale->getPrecedentPreference('default_date_format')}';
 		
 		tinyMCE.baseURL = location_href+'/include/javascript/tiny_mce';
		tinyMCE.srcMode = '';
 		tinyMCE.init({
    			theme : "advanced",
    			theme_advanced_toolbar_align : "left",
    			mode: "exact",
			elements : "description",
			theme_advanced_toolbar_location : "top",
			theme_advanced_buttons1: "code,help,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,forecolor,backcolor,separator,styleprops,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,selectall,separator,search,replace,separator,bullist,numlist,separator,outdent,indent,separator,ltr,rtl,separator,undo,redo,separator, link,unlink,anchor,image,separator,sub,sup,separator,charmap,visualaid",
			theme_advanced_buttons3: "tablecontrols,separator,advhr,hr,removeformat,separator,insertdate,pagebreak",
			plugins : "advhr,insertdatetime,table,paste,searchreplace,directionality,style,pagebreak",
			height:"500",
			width: "100%",
			inline_styles : true,
			directionality : "ltr",
			remove_redundant_brs : true,
			entity_encoding: 'raw',
			cleanup_on_startup : true,
			strict_loading_mode : true,
			convert_urls : false,
			plugin_insertdate_dateFormat : '{DATE '+df+'}',
			pagebreak_separator : "<pagebreak />",
		});
		
		tinyMCE.init({
    			theme : "advanced",
    			theme_advanced_toolbar_align : "left",
    			mode: "exact",
			elements : "pdfheader,pdffooter",
			theme_advanced_toolbar_location : "top",
			theme_advanced_buttons1: "code,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,undo,redo,separator,forecolor,backcolor,separator,styleprops,styleselect,formatselect,fontselect,fontsizeselect,separator,insertdate",
			theme_advanced_buttons2 : "",
    			theme_advanced_buttons3 : "",
			plugins : "advhr,insertdatetime,table,paste,searchreplace,directionality,style",
			width: "100%",
			inline_styles : true,
			directionality : "ltr",
			entity_encoding: 'raw',
			cleanup_on_startup : true,
			strict_loading_mode : true,
			convert_urls : false,
			remove_redundant_brs : true,
			plugin_insertdate_dateFormat : '{DATE '+df+'}',
		});

		</script>

JS;
		echo $js;
	}

}
?>
