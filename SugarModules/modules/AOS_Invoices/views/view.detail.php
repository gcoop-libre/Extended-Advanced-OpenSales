<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/views/view.detail.php');

class AOS_InvoicesViewDetail extends ViewDetail {
	var $currSymbol;
	function AOS_InvoicesViewDetail(){
 		parent::ViewDetail();
 	}
	
	function display(){
		$this->populateQuoteTemplates();
		$this->displayPopupHtml();
		$this->populateCurrency();
		$this->populateLineItems();
		parent::display();
	}
	
	function populateCurrency(){
		require_once('modules/Currencies/Currency.php');
		$currency  = new Currency();
		if(isset($this->bean->currency_id) && !empty($this->bean->currency_id)){
			$currency->retrieve($focus->currency_id);
			if( $currency->deleted != 1){
				$this->currSymbol =  $currency->symbol;
			}else{
				$this->currSymbol = $currency->getDefaultCurrencySymbol();
			}
		}else{
			$this->currSymbol = $currency->getDefaultCurrencySymbol();
		}
		
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
		global $app_strings, $mod_strings;
		
  		$sql = "SELECT * FROM aos_products_quotes WHERE parent_type = 'AOS_Invoices' AND parent_id = '".$this->bean->id."' AND product_id != '0' AND deleted = 0";
  		
		$result = $this->bean->db->query($sql);
		$countLine = $this->bean->db->getRowCount($result);
		$sep = get_number_seperators();
		
		$html = "";
		$html .= "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
		
		if($countLine != 0)
		{
			$html .= "<tr>";
			$html .= "<td width='5%' class='tabDetailViewDL' style='text-align: left;padding:2px;'>&nbsp;</td>";
			$html .= "<td width='10%' class='tabDetailViewDL' style='text-align: left;padding:2px;' scope='row'>".$mod_strings['LBL_PRODUCT_QUANITY']."</td>";
			$html .= "<td width='12%' class='tabDetailViewDL' style='text-align: left;padding:2px;' scope='row'>".$mod_strings['LBL_PRODUCT_NAME']."</td>";
			$html .= "<td width='12%' class='tabDetailViewDL' style='text-align: left;padding:2px;' scope='row'>".$mod_strings['LBL_LIST_PRICE']."</td>";
			$html .= "<td width='12%' class='tabDetailViewDL' style='text-align: left;padding:2px;' scope='row'>".$mod_strings['LBL_DISCOUNT_AMT']."</td>";
			$html .= "<td width='12%' class='tabDetailViewDL' style='text-align: left;padding:2px;' scope='row'>".$mod_strings['LBL_UNIT_PRICE']."</td>";
			$html .= "<td width='12%' class='tabDetailViewDL' style='text-align: left;padding:2px;' scope='row'>".$mod_strings['LBL_VAT']."</td>";
			$html .= "<td width='12%' class='tabDetailViewDL' style='text-align: left;padding:2px;' scope='row'>".$mod_strings['LBL_VAT_AMT']."</td>";
			$html .= "<td width='12%' class='tabDetailViewDL' style='text-align: left;padding:2px;' scope='row'>".$mod_strings['LBL_TOTAL_PRICE']."</td>";
			$html .= "</tr>";
		}
		$i = 1;
		while ($row = $this->bean->db->fetchByAssoc($result)) {

			$html .= "<tr>";
			$product_note = wordwrap($row['description'],40,"<br />\n");
			$html .= "<td class='tabDetailViewDF' style='text-align: left; padding:2px;'>".$i++."</td>";
			$html .= "<td class='tabDetailViewDF' style='padding:2px;'>".$row['product_qty']."</td>";
		  	$html .= "<td class='tabDetailViewDF' style='padding:2px;'><a href='index.php?module=AOS_Products&action=DetailView&record=".$row['product_id']."' class='tabDetailViewDFLink'>".$row['name']."</a><br />".$product_note."</td>";
		  	$html .= "<td class='tabDetailViewDF' style='padding:2px;'>".currency_format_number($row['product_list_price'])."</td>";
		  	if($row['product_discount'] != '' && $row['product_discount'] != '0.00')
		  	{
		  		if($row['discount'] == 'Amount')
		  		{
		  			$html .= "<td class='tabDetailViewDF' style='padding:2px;'>".currency_format_number($row['product_discount'])."</td>";
		  		}
		  		else
		  		{
		  			$html .= "<td class='tabDetailViewDF' style='padding:2px;'>".trim(trim(currency_format_number($row['product_discount'],$params = array('currency_symbol' => false,)), '0'),$sep[1])."%</td>";	
		  		}
		  	}
		  	else
		  	{
		  		$html .= "<td class='tabDetailViewDF' style='padding:2px;'>-</td>";
		  	}
		  	$html .= "<td class='tabDetailViewDF' style='padding:2px;'>".currency_format_number($row['product_unit_price'])."</td>";
		  	$html .= "<td class='tabDetailViewDF' style='padding:2px;'>".trim(trim(currency_format_number($row['vat'],$params = array('currency_symbol' => false,)), '0'),$sep[1])."%</td>";
		  	$html .= "<td class='tabDetailViewDF' style='padding:2px;'>".currency_format_number($row['vat_amt'])."</td>";
		  	$html .= "<td class='tabDetailViewDF' style='padding:2px;'>".currency_format_number($row['product_total_price'])."</td>";
			$html .= "</tr>";
		}
		
		$sql = "SELECT * FROM aos_products_quotes WHERE parent_type = 'AOS_Invoices' AND parent_id = '".$this->bean->id."' AND product_id = '0' AND deleted = 0";
  		
		$result = $this->bean->db->query($sql);
		$countLine = $this->bean->db->getRowCount($result);
		
		if($i != 1 && $countLine != 0)
		{
			$html .= "<tr>";
			$html .= "<td width='5%' class='tabDetailViewDL' style='text-align: left;padding:2px; padding-top:12px;'>&nbsp;</td>";
			$html .= "<td width='46%' class='dataLabel' style='text-align: left;padding:2px; padding-top:12px;' colspan='4' scope='row'>".$mod_strings['LBL_SERVICE_NAME']."</td>";
			$html .= "<td width='12%' class='dataLabel' style='text-align: left;padding:2px; padding-top:12px;' scope='row'>".$mod_strings['LBL_SERVICE_PRICE']."</td>";
			$html .= "<td width='12%' class='tabDetailViewDL' style='text-align: left;padding:2px; padding-top:12px;' scope='row'>".$mod_strings['LBL_VAT']."</td>";
			$html .= "<td width='12%' class='dataLabel' style='text-align: left;padding:2px; padding-top:12px;' scope='row'>".$mod_strings['LBL_VAT_AMT']."</td>";
			$html .= "<td width='12%' class='dataLabel' style='text-align: left;padding:2px; padding-top:12px;' scope='row'>".$mod_strings['LBL_TOTAL_PRICE']."</td>";;
			$html .= "</tr>";
		}
		else if($countLine != 0)
		{
			$html .= "<tr>";
			$html .= "<td width='5%' class='tabDetailViewDL' style='text-align: left;padding:2px;'>&nbsp;</td>";
			$html .= "<td width='46%' class='dataLabel' style='text-align: left;padding:2px;' colspan='4' scope='row'>".$mod_strings['LBL_SERVICE_NAME']."</td>";
			$html .= "<td width='12%' class='dataLabel' style='text-align: left;padding:2px;' scope='row'>".$mod_strings['LBL_SERVICE_PRICE']."</td>";
			$html .= "<td width='12%' class='tabDetailViewDL' style='text-align: left;padding:2px;' scope='row'>".$mod_strings['LBL_VAT']."</td>";
			$html .= "<td width='12%' class='dataLabel' style='text-align: left;padding:2px;' scope='row'>".$mod_strings['LBL_VAT_AMT']."</td>";
			$html .= "<td width='12%' class='dataLabel' style='text-align: left;padding:2px;' scope='row'>".$mod_strings['LBL_TOTAL_PRICE']."</td>";;
			$html .= "</tr>";
		}
		$i = 1;
		while ($row = $this->bean->db->fetchByAssoc($result)) {
			$html .= "<tr>";
			$html .= "<td class='tabDetailViewDF' style='text-align: left; padding:2px;'>".$i++."</td>";
		  	$html .= "<td class='tabDetailViewDF' style='padding:2px;' colspan='4'>".$row['name']."</td>";
		  	$html .= "<td class='tabDetailViewDF' style='padding:2px;'>".currency_format_number($row['product_unit_price'])."</td>";
		  	$html .= "<td class='tabDetailViewDF' style='padding:2px;'>".trim(trim(currency_format_number($row['vat'],$params = array('currency_symbol' => false,)), '0'),$sep[1])."%</td>";
		  	$html .= "<td class='tabDetailViewDF' style='padding:2px;'>".currency_format_number($row['vat_amt'])."</td>";
		  	$html .= "<td class='tabDetailViewDF' style='padding:2px;'>".currency_format_number($row['product_total_price'])."</td>";
			$html .= "</tr>";
		}
		$html .= "</table>";
		
		$this->ss->assign('LINE_ITEMS',$html);
	}
	
	function displayPopupHtml(){
		global $app_list_strings,$app_strings, $mod_strings;
		if(trim($this->bean->template_ddown_c) != ''){
		$templates = explode('^,^',trim($this->bean->template_ddown_c));
		
		echo '	<div id="popupDiv_ara" style="display:none;position:fixed;top: 39%; left: 41%;opacity:1;z-index:9999;background:#FFFFFF;">
				<form id="popupForm" action="index.php?entryPoint=generatePdf" method="post">
 				<table style="border: #000 solid 2px;padding-left:40px;padding-right:40px;padding-top:10px;padding-bottom:10px;font-size:110%;" >
					<tr height="20">
						<td colspan="2">
						<b>'.$app_strings['LBL_SELECT_TEMPLATE'].':-</b>
						</td>
					</tr>';
			foreach($templates as $template){
				$template = str_replace('^','',$template);
				$js = "document.getElementById('popupDivBack_ara').style.display='none';document.getElementById('popupDiv_ara').style.display='none';var form=document.getElementById('popupForm');if(form!=null){form.templateID.value='".$template."';form.submit();}else{alert('Error!');}";
				echo '<tr height="20">
				<td width="17" valign="center"><a href="#" onclick="'.$js.'"><img src="themes/default/images/txt_image_inline.gif" width="16" height="16" /></a></td>
				<td><b><a href="#" onclick="'.$js.'">'.$app_list_strings['template_ddown_c_list'][$template].'</a></b></td></tr>';
			}
		echo '		<input type="hidden" name="templateID" value="" />
				<input type="hidden" name="task" value="pdf" />
				<input type="hidden" name="module" value="'.$_REQUEST['module'].'" />
				<input type="hidden" name="uid" value="'.$this->bean->id.'" />
				</form>
				<tr style="height:10px;"><tr><tr><td colspan="2"><button style=" display: block;margin-left: auto;margin-right: auto" onclick="document.getElementById(\'popupDivBack_ara\').style.display=\'none\';document.getElementById(\'popupDiv_ara\').style.display=\'none\';return false;">Cancel</button></td></tr>
				</table>
				</div>
				<div id="popupDivBack_ara" onclick="this.style.display=\'none\';document.getElementById(\'popupDiv_ara\').style.display=\'none\';" style="top:0px;left:0px;position:fixed;height:100%;width:100%;background:#000000;opacity:0.5;display:none;vertical-align:middle;text-align:center;z-index:9998;">
				</div>
				<script>
					function showPopup(task){
						var form=document.getElementById(\'popupForm\');
						var ppd=document.getElementById(\'popupDivBack_ara\');
						var ppd2=document.getElementById(\'popupDiv_ara\');
						if('.count($templates).' == 1){
							form.task.value=task;
							form.templateID.value=\''.$template.'\';
							form.submit();
						}else if(form!=null && ppd!=null && ppd2!=null){
							ppd.style.display=\'block\';
							ppd2.style.display=\'block\';
							form.task.value=task;
						}else{
							alert(\'Error!\');
						}
					}
				</script>';
		}
		else{
			echo '<script>
				function showPopup(task){
				alert(\''.$mod_strings['LBL_NO_TEMPLATE'].'\');
				}
			</script>';
		}
	}
}
?>
