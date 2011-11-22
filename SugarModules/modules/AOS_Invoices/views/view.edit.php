<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/views/view.edit.php');

class AOS_InvoicesViewEdit extends ViewEdit {
	function AOS_InvoicesViewEdit(){
 		parent::ViewEdit();
 	}
	
	function display(){
		$this->populateCurrency();
		$this->populateQuoteTemplates();
		$this->populateLineItems();
		parent::display();
		$this->displayJS();
	}
	
	function populateCurrency(){
		global $mod_strings;
		require_once('modules/Currencies/Currency.php');
		$currency  = new Currency();
		$currText = '';
		if(isset($this->bean->currency_id) && !empty($this->bean->currency_id)){
			$currency->retrieve($focus->currency_id);
			if( $currency->deleted != 1){
				$currText =  $currency->iso4217 .' '.$currency->symbol;
			}else{
				$currText = $currency->getDefaultISO4217() .' '.$currency->getDefaultCurrencySymbol();
			}
		}else{
			$currText = $currency->getDefaultISO4217() .' '.$currency->getDefaultCurrencySymbol();
		}
		
		$this->ss->assign('CURRENCY', $currText);
		$mod_strings['LBL_LIST_PRICE'] .= " (".$currText.")";
		$mod_strings['LBL_UNIT_PRICE'] .= " (".$currText.")";
		$mod_strings['LBL_VAT_AMT'] .= " (".$currText.")";
		$mod_strings['LBL_TOTAL_PRICE'] .= " (".$currText.")";
		$mod_strings['LBL_SERVICE_PRICE'] .= " (".$currText.")";
	}
	
	function populateQuoteTemplates(){
		global $app_list_strings, $current_user;
		
		$sql = "SELECT id, name FROM aos_pdf_templates WHERE deleted='0' AND type='Invoices'";
		
		$res = $this->bean->db->query($sql);
		while($row = $this->bean->db->fetchByAssoc($res)){
			$app_list_strings['template_ddown_c_list'][$row['id']] = $row['name'];
		}
	}
	
	function populateLineItems(){
	
		global $locale, $app_list_strings, $app_strings, $mod_strings, $popup_request_data, $sugar_config;
		
		$json = getJSONobj();
		$encoded_contact_popup_request_data = $json->encode($popup_request_data);
  		
  		$sql = "SELECT * FROM aos_products_quotes WHERE parent_type = 'AOS_Invoices' AND parent_id = '".$this->bean->id."' AND product_id != '0' AND deleted = 0";
  		$result = $this->bean->db->query($sql);
		
		$html = "";
		$html .= '<script language="javascript">setModule("AOS_Invoices");</script>';
		
		$html .= "<table border='0' width='37.5%' id='productLine'>";
					
		$html .= "<tr id='productHeader' style='display: none'>";
		$html .= "<td width='15%' class='dataLabel' style='text-align: left;'>".$mod_strings['LBL_PRODUCT_QUANITY']."</td>";
		$html .= "<td width='15%' class='dataLabel' style='text-align: left;' colspan='2'>".$mod_strings['LBL_PRODUCT_NAME']."</td>";
		$html .= "<td width='15%' class='dataLabel' style='text-align: left;'>".$mod_strings['LBL_LIST_PRICE']."</td>";
		$html .= "<td width='15%' class='dataLabel' style='text-align: left;'>".$mod_strings['LBL_DISCOUNT_AMT']."</td>";
		$html .= "<td width='15%' class='dataLabel' style='text-align: left;'>".$mod_strings['LBL_UNIT_PRICE']."</td>";
		$html .= "<td width='15%' class='dataLabel' style='text-align: left;'>".$mod_strings['LBL_VAT_AMT']."</td>";
		$html .= "<td width='15%' class='dataLabel' style='text-align: left;'>".$mod_strings['LBL_TOTAL_PRICE']."</td>";
		$html .= "<td width='10%' class='dataLabel' style='text-align: left;'>&nbsp;</td>";
		$html .= "</tr>";
		
		$i = 0;
		while ($row = $this->bean->db->fetchByAssoc($result)) {
		
		if($i == 0)
		{
			$html .= '<script language="javascript">showProductHeader(true);</script>';
		}

			$sqs_objects = array('product_name['.$i.']' =>
			 	array(
			 	'form' => 'EditView',
                    		'method' => 'query',
                    		'modules' => array('AOS_Products'),
                    		'group' => 'or',
                    		'field_list' => array('name', 'id','cost','price'),
                    		'populate_list' => array('product_name['.$i.']', 'product_id['.$i.']','product_cost_price['.$i.']','product_list_price['.$i.']'),
                   	 	'required_list' => array('product_id['.$i.']'),
                    		'conditions' => array(array('name'=>'name','op'=>'like_custom','end'=>'%','value'=>'')),
                    		'order' => 'name',
                    		'limit' => '30',
                    		'post_onblur_function' => 'formatListPrice('.$i.');',
                    		'no_match_text' => $app_strings['ERR_SQS_NO_MATCH']
                   		)
                	);
                                   
                	$quicksearch_js = '<script language="javascript">';
           		$quicksearch_js.= 'if(typeof sqs_objects == \'undefined\'){var sqs_objects = new Array;}';
           	
           		foreach($sqs_objects as $sqsfield=>$sqsfieldArray){
               			$quicksearch_js .= "sqs_objects['$sqsfield']={$json->encode($sqsfieldArray)};";
           		}
           		
           		$html .= $quicksearch_js . '</script>';
           		
			$row['id'] = (isset($_REQUEST['Duplicate']) && trim($_REQUEST['Duplicate']) == 'Duplicate')?"":$row['id'];
			
			$html .= "<tr id='product_line$i'>";
			$html .= "<td class='dataField'><input tabindex='3' type='text' name='qty_product_qty[$i]' id='qty_product_qty$i' size='6' maxlength='6' value='".$row['product_qty']."' title='' onblur='Quantity_formatNumber($i);calculateProductLine($i);'><input tabindex='3' type='hidden' name='product_qty[$i]' id='product_qty$i' size='20' maxlength='6' value='".$row['product_qty']."'></td>";
		  	$html .= "<td class='dataField'><input class='sqsEnabled' autocomplete='off' tabindex='3' type='text' name='product_name[$i]' id='product_name$i' size='16' maxlength='50' value='".$row['name']."' title=''><input type='hidden' name='product_id[$i]' id='product_id$i' value='".$row['product_id']."'></td>";
		  	$html .= "<td class='dataField'><button title='".$app_strings['LBL_SELECT_BUTTON_TITLE']."' accessKey='".$app_strings['LBL_SELECT_BUTTON_KEY']."' type='button' tabindex='3' class='button' value='".$app_strings['LBL_SELECT_BUTTON_LABEL']."' name='btn1' onclick='openProductPopup($i)'><img src='themes/default/images/id-ff-select.png' alt='".$app_strings['LBL_SELECT_BUTTON_LABEL']."'></button></td>";
		  	$html .= "<td class='dataField'><input tabindex='3' type='text' name='product_list_price[$i]' id='product_list_price$i' size='16' maxlength='50' value='".format_number($row['product_list_price'])."' title='' readonly='readonly'><input type='hidden' name='product_cost_price[$i]' id='product_cost_price$i' value='".format_number($row['product_cost_price'])."' /></td>";
		  	$html .= "<td class='dataField'><input tabindex='3' type='text' name='product_discount[]' id='product_discount$i' size='16' maxlength='50' value='".format_number($row['product_discount'])."' title='' tabindex='3' onfocus='calculateDiscount($i);' onblur='calculateDiscount($i);'><input type='hidden' name='product_discount_amount[]' id='product_discount_amount$i' value='".format_number($row['product_discount_amount'])."' /></td>";
		  	$html .= "<td class='dataField'><input tabindex='3' type='text' name='product_unit_price[]' id='product_unit_price$i' size='16' maxlength='50' value='".format_number($row['product_unit_price'])."' title='' onfocus='calculateDiscount($i);' onblur='calculateProductLine($i);' readonly='readonly'></td>";
			$html .= "<td class='dataField'><input tabindex='3' type='text' name='vat_amt[]' id='vat_amt$i' size='16' maxlength='50' value='".format_number($row['vat_amt'])."' readonly title=''></td>";
		  	$html .= "<td class='dataField'><input tabindex='3' type='text' name='product_total_price[]' id='product_total_price$i' size='16' maxlength='50' value='".format_number($row['product_total_price'])."' title='' readonly='readonly'></td>";
		  	$html .= "<td class='dataField'><input type='hidden' name='product_deleted[]' id='product_deleted$i' value='0'><input type='hidden' name='product_quote_id[]' value='".$row['id']."'><button type='button' class='button' value='".$mod_strings['LBL_REMOVE_PRODUCT_LINE']."' tabindex='3' onclick='markProductLineDeleted($i)'><img src='themes/default/images/id-ff-clear.png' alt='".$mod_strings['LBL_REMOVE_PRODUCT_LINE']."'></button></td>";
		  	$html .= "</tr>";
                        
           		$html .= "<tr><td height='1px'></td></tr><tr id='product_note_line$i'>";
			$html .= "<td class='dataField' align='right'>".$mod_strings['LBL_PRODUCT_NOTE']." :&nbsp</td>";
			$html .= "<td class='dataField' colspan='3'><textarea tabindex='3' name='product_note[]' id='product_note$i' rows='1' cols='23'>".$row['description']."</textarea></td>";
			$html .= "<td class='dataField' colspan='2'>".$mod_strings['LBL_DISCOUNT_TYPE']."&nbsp;:&nbsp;<select name='discount[]' id='discount$i' onchange='calculateDiscount($i);'>".get_select_options_with_id($app_list_strings['discount_list'], $row['discount'])."</select></td>";
			$html .= "<td class='dataField'>".$mod_strings['LBL_VAT']." %&nbsp; :&nbsp;&nbsp;<select name='vat[]' id='vat$i' onchange='calculateProductLine($i);'>".get_select_options_with_id($app_list_strings['vat_list'], $row['vat'])."</select></td>";
			$html .= "<td class='dataField' colspan='1'></td>";
			$html .= "</tr>";
			
		  	$i++;
		}
		
		$html .= '<script language="javascript">prodLine = '.$i.';</script>';
		$html .= "</table>";


		$sql = "SELECT * FROM aos_products_quotes WHERE parent_type = 'AOS_Invoices' AND parent_id = '".$this->bean->id."' AND product_id = '0' AND deleted = 0";
  		$result = $this->bean->db->query($sql);
  		
		if(preg_match('/^6\.?[2-9]/', $sugar_config['sugar_version'])){
			$html .= "<table border='0' cellspacing='4' width='100%' id='serviceLine'>";
		}else{
			$html .= "<table border='0' cellspacing='4' width='37.5%' id='serviceLine'>";
		}
		
		$html .= "<tr id='serviceHeader' style='display: none'>";
		$html .= "<td width='60%' class='dataLabel' style='text-align: left;' colspan='4'>".$mod_strings['LBL_SERVICE_NAME']."</td>";
		$html .= "<td width='15%' class='dataLabel' style='text-align: left;'>".$mod_strings['LBL_SERVICE_PRICE']."</td>";
		$html .= "<td width='15%' class='dataLabel' style='text-align: left;'>".$mod_strings['LBL_VAT_AMT']."</td>";
		$html .= "<td width='15%' class='dataLabel' style='text-align: left;'>".$mod_strings['LBL_TOTAL_PRICE']."</td>";
		$html .= "<td width='10%' class='dataLabel' style='text-align: left;'>&nbsp;</td>";
		$html .= "</tr>";
		
		$k = 0;
		while ($row = $this->bean->db->fetchByAssoc($result)) {
		
		if($k == 0)
		{
			$html .= '<script language="javascript">showServiceHeader(true);</script>';
		}
           		
			$row['id'] = (isset($_REQUEST['Duplicate']) && trim($_REQUEST['Duplicate']) == 'Duplicate')?"":$row['id'];
			
			$html .= "<tr id='service_line$k'>";
			$html .= "<td class='dataField' colspan='4'><textarea tabindex='3' type='text' name='product_name[]' id='service_name$k' size='16' cols='60' title='' maxlength='255' onkeypress='return imposeMaxLength(this);'>".$row['name']."</textarea><input type='hidden' name='product_id[]' id='service_id$k' value='".$row['product_id']."'></td>";
		  	$html .= "<td class='dataField'><input tabindex='3' type='text' name='product_unit_price[]' id='service_unit_price$k' size='16' maxlength='50' value='".format_number($row['product_unit_price'])."' title=''  onblur='calculateServiceLine($k);'></td>";
			$html .= "<td class='dataField'><input tabindex='3' type='text' name='vat_amt[]' id='ser_vat_amt$k' size='16' maxlength='50' value='".format_number($row['vat_amt'])."' readonly title=''><br />".$mod_strings['LBL_VAT']." %&nbsp; :&nbsp;&nbsp;<select name='vat[]' id='ser_vat$k' onchange='calculateServiceLine($k);'>".get_select_options_with_id($app_list_strings['vat_list'], $row['vat'])."</select></td>";
		  	$html .= "<td class='dataField'><input tabindex='3' type='text' name='product_total_price[]' id='service_total_price$k' size='16' maxlength='50' value='".format_number($row['product_total_price'])."' title='' readonly='readonly'></td>";
		  	$html .= "<td class='dataField'><input type='hidden' name='product_deleted[]' id='ser_deleted$k' value='0'><input type='hidden' name='product_quote_id[]' value='".$row['id']."'><button type='button' class='button' value='".$mod_strings['LBL_REMOVE_PRODUCT_LINE']."' tabindex='3' onclick='markServiceLineDeleted($k)'><img src='themes/default/images/id-ff-clear.png' alt='".$mod_strings['LBL_REMOVE_PRODUCT_LINE']."'></button></td>";
			$html .= "</tr>";
		  	
		  	$k++;
		}
		$html .= "</table>";
		$html .= '<script language="javascript">servLine = '.$k.';</script>';
		
		$html .= "<div style='padding-top: 10px; padding-bottom:10px;'>";
		$html .= "<input type=\"button\" class=\"button\" value=\"".$mod_strings['LBL_ADD_PRODUCT_LINE']."\" id=\"addProductLine\" onclick=\"insertProductLine(".$i.")\" />";
		$html .= " <input type=\"button\" class=\"button\" value=\"".$mod_strings['LBL_ADD_SERVICE_LINE']."\" id=\"addServiceLine\" onclick=\"insertServiceLine(".$k.")\" />";
		$html .= "</div>";

		$decimals = $locale->getPrecision();
		$sep = get_number_seperators();
		$html .= '<input type="hidden" name="vathidden" id="vathidden" value="'.get_select_options_with_id($app_list_strings['vat_list'], '').'">
			  <input type="hidden" name="discounthidden" id="discounthidden" value="'.get_select_options_with_id($app_list_strings['discount_list'], '').'">
				  <input type="hidden" id="significant_digits" name="significant_digits" value="'.$decimals.'" />
				  <input type="hidden" id="grp_seperator" name="grp_seperator" value="'.$sep[0].'" />
				  <input type="hidden" id="dec_seperator" name="dec_seperator" value="'.$sep[1].'" />
				  <input type="hidden" id="currency_symbol" name="currency_symbol" value="{CURRENCY_SYMBOL}" />';
		
		
		$this->ss->assign('LINE_ITEMS',$html);
		
		$value;
		if($this->bean->shipping_amount != '')
		{
			$value = format_number($this->bean->shipping_amount);
		}
		
		$this->ss->assign('SHIPPING','<input type="text" tabindex="6" title="" value="'.$value.'" onBlur="calculateGrandTotal();" maxlength="16" size="30" id="shipping_amount" name="shipping_amount">');
	}
	
	function displayJS(){
		global $app_strings, $mod_strings;
		echo "
			<script type=\"text/javascript\">
				var selectButtonTitle = '". $app_strings['LBL_SELECT_BUTTON_TITLE'] . "';
				var selectButtonKey	  = '". $app_strings['LBL_SELECT_BUTTON_KEY'] . "';
				var selectButtonValue = '". $app_strings['LBL_SELECT_BUTTON_LABEL'] . "';
				var deleteButtonValue = '". $mod_strings['LBL_REMOVE_PRODUCT_LINE'] . "';";

		$js=<<<JS
			if(typeof sqs_objects == 'undefined'){var sqs_objects = new Array;}
	sqs_objects['EditView_billing_account']={"form":"EditView","method":"query","modules":["Accounts"],"group":"or","field_list":["name","id","billing_address_street","billing_address_city","billing_address_state","billing_address_postalcode","billing_address_country","shipping_address_street","shipping_address_city","shipping_address_state","shipping_address_postalcode","shipping_address_country"],"populate_list":["EditView_billing_account","billing_account_id","billing_address_street","billing_address_city","billing_address_state","billing_address_postalcode","billing_address_country","shipping_address_street","shipping_address_city","shipping_address_state","shipping_address_postalcode","shipping_address_country"],"conditions":[{"name":"name","op":"like_custom","end":"%","value":""}],"required_list":["billing_account_id"],"order":"name","limit":"30","no_match_text":"No Match"};			
	document.getElementById('btn_billing_account').onclick = function() {
	open_popup('Accounts', 800, 851, '', true, false, {'call_back_function':'set_return','form_name':'EditView','field_to_name_array':{'id':'billing_account_id','name':'billing_account','billing_address_street':'billing_address_street','billing_address_city':'billing_address_city','billing_address_state':'billing_address_state','billing_address_postalcode':'billing_address_postalcode','billing_address_country':'billing_address_country','shipping_address_street':'shipping_address_street','shipping_address_city':'shipping_address_city','shipping_address_state':'shipping_address_state','shipping_address_postalcode':'shipping_address_postalcode','shipping_address_country':'shipping_address_country'}}, 'single', true);
	}
	document.getElementById('btn_billing_contact').onclick = function() {
	open_popup('Contacts', 800, 851, '&account_name='+ document.getElementById('billing_account').value , true, false, {'call_back_function':'set_return','form_name':'EditView','field_to_name_array':{'id':'billing_contact_id','name':'billing_contact'}},'single', true);
	}

JS;
		echo $js;				
		echo "</script>
			";
	}
}
?>
