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
 
	if(!isset($_REQUEST['uid']) || empty($_REQUEST['uid']) || !isset($_REQUEST['templateID']) || empty($_REQUEST['templateID'])){
		die('Error retrieving record. This record may be deleted or you may not be authorized to view it.');
	}
	error_reporting(0);
	require_once('modules/AOS_PDF_Templates/PDF_Lib/mpdf.php');
	require_once('modules/AOS_PDF_Templates/templateParser.php');
	require_once('modules/AOS_PDF_Templates/sendEmail.php');
	require_once('modules/AOS_PDF_Templates/AOS_PDF_Templates.php');
	global $mod_strings;
	
	$module_type = $_REQUEST['module'];
	$module_type_file = strtoupper(ltrim(rtrim($module_type,'s'),'AOS_'));
	$module_type_low = strtolower($module_type);
	
	$module = new $module_type();
	$module->retrieve($_REQUEST['uid']);

	$task = $_REQUEST['task'];
	
	$lineItems = array();
	$sql = "SELECT id, product_id FROM aos_products_quotes WHERE parent_type = '".$module_type."' AND parent_id = '".$module->id."' AND product_id != '0' AND deleted = 0";
	$res = $module->db->query($sql);
	while($row = $module->db->fetchByAssoc($res)){
		$lineItems[$row['id']] = $row['product_id'];
	}
	
	$serviceLineItems = array();
	$sql = "SELECT id, product_id FROM aos_products_quotes WHERE parent_type = '".$module_type."' AND parent_id = '".$module->id."' AND product_id = '0' AND deleted = 0";
	$res = $module->db->query($sql);
	while($row = $module->db->fetchByAssoc($res)){
		$serviceLineItems[$row['id']] = $row['product_id'];
	}
	
	$template = new AOS_PDF_Templates();
	$template->retrieve($_REQUEST['templateID']);
	
	$object_arr = array();
	$object_arr[$module_type] = $module->id;
	
	$object_arr['Accounts'] = $module->billing_account_id;
	$object_arr['Contacts'] = $module->billing_contact_id;
	$object_arr['Users'] = $module->assigned_user_id;
	
	$search = array ('@<script[^>]*?>.*?</script>@si', 		// Strip out javascript
					'@<[\/\!]*?[^<>]*?>@si',		// Strip out HTML tags
					'@([\r\n])[\s]+@',			// Strip out white space
					'@&(quot|#34);@i',			// Replace HTML entities
					'@&(amp|#38);@i',
					'@&(lt|#60);@i',
					'@&(gt|#62);@i',
					'@&(nbsp|#160);@i',
					'@&(iexcl|#161);@i',
					'@&#(\d+);@e',
					'@<address[^>]*?>@si'
	);

	$replace = array ('',
					 '',
					 '\1',
					 '"',
					 '&',
					 '<',
					 '>',
					 ' ',
					 chr(161),
					 'chr(\1)',
					 '<br>'
		);
	
	$header = preg_replace($search, $replace, $template->pdfheader);
	$footer = preg_replace($search, $replace, $template->pdffooter);
	$text = preg_replace($search, $replace, $template->description);
	$text = preg_replace('/\{DATE\s+(.*?)\}/e',"date('\\1')",$text );
	$text = str_replace("\$aos_quotes","\$".$module_type_low,$text);
	$text = str_replace("\$aos_invoices","\$".$module_type_low,$text);
	$text = str_replace("\$total_amt","\$".$module_type_low."_total_amt",$text);
	$text = str_replace("\$discount_amount","\$".$module_type_low."_discount_amount",$text);
	$text = str_replace("\$subtotal_amount","\$".$module_type_low."_subtotal_amount",$text);
	$text = str_replace("\$tax_amount","\$".$module_type_low."_tax_amount",$text);
	$text = str_replace("\$shipping_amount","\$".$module_type_low."_shipping_amount",$text);
	$text = str_replace("\$total_amount","\$".$module_type_low."_total_amount",$text);
	
	$firstValue = '';
	$firstNum = 0;
	
	$lastValue = '';
	$lastNum = 0;
	
	//Find first and last valid line values
	$product_quote = new AOS_Products_Quotes();
		foreach($product_quote->field_defs as $name => $arr){
			if(!((isset($arr['dbType']) && strtolower($arr['dbType']) == 'id') || $arr['type'] == 'id' || $arr['type'] == 'link')){
			
				$curNum = strpos($text,'$aos_products_quotes_'.$name);
				if($curNum)
				{
					if($curNum < $firstNum || $firstNum == 0)
					{
						$firstValue = '$aos_products_quotes_'.$name;
						$firstNum = $curNum;
					}
					else if($curNum > $lastNum)
					{
						$lastValue = '$aos_products_quotes_'.$name;
						$lastNum = $curNum;
					}
				}
			}
		}
	$product = new AOS_Products();
		foreach($product->field_defs as $name => $arr){
			if(!((isset($arr['dbType']) && strtolower($arr['dbType']) == 'id') || $arr['type'] == 'id' || $arr['type'] == 'link')){
			
				$curNum = strpos($text,'$aos_products_'.$name);
				if($curNum)
				{
					if($curNum < $firstNum || $firstNum == 0)
					{
						$firstValue = '$aos_products_'.$name;
						$firstNum = $curNum;
					}
					else if($curNum > $lastNum)
					{
						$lastValue = '$aos_products_'.$name;
						$lastNum = $curNum;
					}
				}
			}
		}
	
	if($firstValue !== '' && $lastvalue !== ''){
		//Converting Text
		$parts = explode($firstValue,$text);
		$text = $parts[0];
		$parts = explode($lastValue,$parts[1]);
		$linePart = $firstValue . $parts[0] . $lastValue;
		
		if(count($lineItems) != 0){
			//Read line start <tr> value
			$tcount = strrpos($text,"<tr");
			$lsValue = substr($text,$tcount);
			$tcount=strpos($lsValue,">")+1;
			$lsValue = substr($lsValue,0,$tcount);
		
			//Read line end values
			$tcount=strpos($parts[1],"</tr>")+5;
			$leValue = substr($parts[1],0,$tcount);
			
			//Converting Line Items
			$obb = array();
			$sep = '';
			$tdTemp = explode($lsValue,$text);
	
			foreach($lineItems as $id => $productId){
				$obb['AOS_Products_Quotes'] = $id;
				$obb['AOS_Products'] = $productId;
				$text .= $sep . templateParser::parse_template($linePart, $obb);
				$sep = $leValue. $lsValue . $tdTemp[count($tdTemp)-1];
			}
		}
		else{
			$tcount = strrpos($text,"<tr");
			$text = substr($text,0,$tcount);
			
			$tcount=strpos($parts[1],"</tr>")+5;
			$parts[1]= substr($parts[1],$tcount);
		}
	
		$text .= $parts[1];
	}
	$firstValue = '';
	$firstNum = 0;
	
	$lastValue = '';
	$lastNum = 0;
	
	$text = str_replace("\$aos_services_quotes_service","\$aos_services_quotes_product",$text);
	
	//Find first and last valid line values
	$product_quote = new AOS_Products_Quotes();
		foreach($product_quote->field_defs as $name => $arr){
			if(!((isset($arr['dbType']) && strtolower($arr['dbType']) == 'id') || $arr['type'] == 'id' || $arr['type'] == 'link')){
			
				$curNum = strpos($text,'$aos_services_quotes_'.$name);
				if($curNum)
				{
					if($curNum < $firstNum || $firstNum == 0)
					{
						$firstValue = '$aos_products_quotes_'.$name;
						$firstNum = $curNum;
					}
					else if($curNum > $lastNum)
					{
						$lastValue = '$aos_products_quotes_'.$name;
						$lastNum = $curNum;
					}
				}
			}
		}
	if($firstValue !== '' && $lastvalue !== '')
	{
		$text = str_replace("\$aos_products","\$aos_null",$text);
		$text = str_replace("\$aos_services","\$aos_products",$text);
	
		$parts = explode($firstValue,$text);
		$text = $parts[0];
		$parts = explode($lastValue,$parts[1]);
		$linePart = $firstValue . $parts[0] . $lastValue;

		if(count($serviceLineItems) != 0){
			//Read line start <tr> value
			$tcount = strrpos($text,"<tr");
			$lsValue = substr($text,$tcount);
			$tcount=strpos($lsValue,">")+1;
			$lsValue = substr($lsValue,0,$tcount);
		
			//Read line end values
			$tcount=strpos($parts[1],"</tr>")+5;
			$leValue = substr($parts[1],0,$tcount);
			
			//Converting ServiceLine Items
			$obb = array();
			$sep = '';
			$tdTemp = explode($lsValue,$text);
	
	
			foreach($serviceLineItems as $id => $productId){
				$obb['AOS_Products_Quotes'] = $id;
				$obb['AOS_Products'] = $productId;
				$text .= $sep . templateParser::parse_template($linePart, $obb);
				$sep = $leValue. $lsValue . $tdTemp[count($tdTemp)-1];
			}
		}
		else{
			//Remove Line if no values
			$tcount = strrpos($text,"<tr");
			$text = substr($text,0,$tcount);
			
			$tcount=strpos($parts[1],"</tr>")+5;
			$parts[1]= substr($parts[1],$tcount);
		}
	
		$text .= $parts[1];
	}
	
	$converted = templateParser::parse_template($text, $object_arr);
	$header = templateParser::parse_template($header, $object_arr);
	$footer = templateParser::parse_template($footer, $object_arr);
	
	$printable = str_replace("\n","<br />",$converted);

	if($task == 'pdf' || $task == 'emailpdf')
	{
		$file_name = $mod_strings['LBL_PDF_NAME']."_".str_replace(" ","_",$module->name).".pdf";
		
		ob_clean();
		try{
			$pdf=new mPDF('en','A4','','DejaVuSans',15,15,16,16,8,8);
			$pdf->setAutoFont();
			$pdf->SetHTMLHeader($header);
			$pdf->SetHTMLFooter($footer);
			$pdf->writeHTML($printable);
			if($task == 'pdf'){
				$pdf->Output($file_name, "D");
			}else{
				$fp = fopen('cache/upload/attachfile.pdf','wb');
				fclose($fp);
				$pdf->Output('cache/upload/attachfile.pdf','F');
				sendEmail::send_email($module,$module_type, '',$file_name, true);
			}
		}catch(mPDF_exception $e){
			echo $e;
		}
	}
	else if($task == 'email')
	{
		sendEmail::send_email($module,$module_type, $printable,'', false);
	}
?>
