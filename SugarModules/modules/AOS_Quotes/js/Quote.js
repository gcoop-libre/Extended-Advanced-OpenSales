/**
 * Advanced, robust set of sales and support modules.
 * Extensions to OpenSales for SugarCRM
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
 * @author Greg Soper <greg.soper@salesagility.com>
 */

/**
 * Copy address right
 */
 var lineno;
 var prodLine = 0;
 var servLine = 0;
 var module = "AOS_Quotes"
 
 
 function setModule(mod)
 {
 	module = mod;
 }
 


/**
 * Copy list price
 */
function copyListPrice(ln)
{
	var listPrice = document.getElementById('product_list_price' + ln).value;
	var unitPrice = document.getElementById('product_unit_price' + ln).value;
	if (unitPrice!=listPrice) {
		document.getElementById('product_unit_price' + ln).value = listPrice;
	}

}


function calculateDiscount(ln)
{
	if (document.getElementById('product_list_price' + ln).value == '') {
		return;
	}
	
	var listPrice = unformatNumber(document.getElementById('product_list_price' + ln).value);
	var discount = unformatNumber(document.getElementById('product_discount' + ln).value);
	var dis = document.getElementById('discount' + ln).value;
	
	if(dis == 'Amount')
	{
		if(discount > listPrice)
		{
			document.getElementById('product_discount' + ln).value = listPrice;
			discount = listPrice;
		}
		document.getElementById('product_unit_price' + ln).value = formatNumber(listPrice - discount);
	}
	else if(dis == 'Percentage')
	{
		if(discount > 100)
		{
			document.getElementById('product_discount' + ln).value = 100;
			discount = 100;
		}
		discount = (discount/100) * listPrice;
		document.getElementById('product_unit_price' + ln).value = formatNumber(listPrice - discount);
	}
	else
	{
		document.getElementById('product_unit_price' + ln).value = document.getElementById('product_list_price' + ln).value;
		document.getElementById('product_discount' + ln).value = '';
		discount = 0;
	}
	document.getElementById('product_discount_amount' + ln).value = formatNumber(-discount);
	calculateProductLine(ln);
}

function showProductHeader(bool)
{
	if(bool)
	{
		document.getElementById("productHeader").style.display="table-row";
	}
	else
	{
		document.getElementById("productHeader").style.display="none";
	}
}

/**
 * Insert product line
 */
 
function insertProductLine(ln)
{

if(prodLine == 0)
{
	showProductHeader(true);
}

	var vat_hidden=document.getElementById("vathidden").value;
	var discount_hidden=document.getElementById("discounthidden").value;
   	
   	sqs_objects["product_name["+ln+"]"]=
	{
   		"form":"EditView",
   		"method":"query",
   		"modules":["AOS_Products"],
   		"group":"or",
   		"field_list":["name","id","cost","price"],
   		"populate_list":["product_name["+ln+"]","product_id["+ln+"]","product_cost_price["+ln+"]","product_list_price["+ln+"]"],
   		"required_list":"product_id["+ln+"]",
   		"conditions":[{"name":"name","op":"like_custom","end":"%","value":""}],
   		"order":"name",
   		"limit":"30",
   		"post_onblur_function":"formatListPrice("+ln+");",
   		"no_match_text":"No Match"
   	};
		
	var x=document.getElementById('productLine').insertRow(-1);
	
	var a=x.insertCell(0);
	var b=x.insertCell(1);
	var ba=x.insertCell(2);
	var c=x.insertCell(3);
	var d=x.insertCell(4);
	var e=x.insertCell(5);
	var f=x.insertCell(6);
	var g=x.insertCell(7);
	var h=x.insertCell(8);		
		
	a.className="dataField";
	b.className="dataField";
	c.className="dataField";
	d.className="dataField";
	e.className="dataField";
	f.className="dataField";
	g.className="dataField";
	h.className="dataField";
	
	a.innerHTML="<input type='text' name='qty_product_qty[]' id='qty_product_qty" + ln + "' size='6' maxlength='6' value='' title='' tabindex='3' onblur='Quantity_formatNumber(" + ln + ");calculateProductLine(" + ln + ");'><input type='hidden' name='product_qty[]' id='product_qty" + ln + "' size='10' value='' title='' tabindex='3'>";
	b.innerHTML="<input class='sqsEnabled' autocomplete='off' type='text' name='product_name[" + ln + "]' id='product_name" + ln +"' size='16' maxlength='50' value='' title='' tabindex='3' value=''><input type='hidden' name='product_id[" + ln + "]' id='product_id" + ln + "' size='20' maxlength='50' value=''>";
	ba.innerHTML="<button title='" + selectButtonTitle + "' accessKey='" + selectButtonKey + "' type='button' tabindex='3' class='button' value='" + selectButtonValue + "' name='btn1' onclick='openProductPopup(" + ln + ");'><img src='themes/default/images/id-ff-select.png' alt='" + selectButtonValue + "'></button>";
	c.innerHTML="<input type='text' name='product_list_price[" + ln + "]' id='product_list_price" + ln + "' size='16' maxlength='50' value='' title='' tabindex='3' readonly='readonly'><input type='hidden' name='product_cost_price[" + ln + "]' id='product_cost_price" + ln + "' value=''  />";
	d.innerHTML="<input type='text' name='product_discount[]' id='product_discount" + ln + "' size='16' maxlength='50' value='' title='' tabindex='3' onblur='calculateProductLine(" + ln + ");'><input type='hidden' name='product_discount_amount[]' id='product_discount_amount" + ln + "' value=''  />";
	e.innerHTML="<input type='text' name='product_unit_price[]' id='product_unit_price" + ln + "' size='16' maxlength='50' value='' title='' tabindex='3' readonly='readonly' onfocus='calculateDiscount(" + ln + ");' onblur='calculateProductLine(" + ln + ");'>";
	f.innerHTML="<input type='text' name='vat_amt[]' id='vat_amt" + ln + "' size='16' maxlength='250' value='' title='' tabindex='3' readonly='readonly'>";	
	g.innerHTML="<input type='text' name='product_total_price[]' id='product_total_price" + ln + "' size='16' maxlength='50' value='' title='' tabindex='3' readonly='readonly'>";
	h.innerHTML="<input type='hidden' name='product_deleted[]' id='product_deleted" + ln + "' value='0'><input type='hidden' name='product_quote_id[]' value=''><button type='button' class='button' value='" + deleteButtonValue + "' tabindex='3' onclick='deleteProductLine(this)'><img src='themes/default/images/id-ff-clear.png' alt='" + deleteButtonValue + "'></button><br>";
	
   	enableQS(true);
	
	var y=document.getElementById('productLine').insertRow(-1);

	var i=y.insertCell(0);
	var j=y.insertCell(1);
	var k=y.insertCell(2);
	var l=y.insertCell(3);
	var m=y.insertCell(4);
	var n=y.insertCell(5);
	var o=y.insertCell(6);
	
	i.align="right";
	j.colSpan="3";

	i.className="dataField";
	j.className="dataField";
	k.className="dataField";
	l.className="dataField";
	m.className="dataField";
	n.className="dataField";
	o.className="dataField";
	
	i.innerHTML="&nbsp;&nbsp;&nbsp;" +SUGAR.language.get(module, 'LBL_PRODUCT_NOTE')+" :&nbsp";
	j.innerHTML="<textarea tabindex='3' name='product_note[]' id='product_note" + ln + "' rows='1' cols='23'></textarea>&nbsp;&nbsp;";
	k.innerHTML=SUGAR.language.get(module, 'LBL_DISCOUNT_TYPE')+"&nbsp;:&nbsp;<select name='discount[]' id='discount" + ln + "' onchange='calculateDiscount(" + ln + ");'>"+ discount_hidden +"</select>";
	m.innerHTML=SUGAR.language.get(module, 'LBL_VAT')+" %&nbsp; :&nbsp;&nbsp;<select name='vat[]' id='vat" + ln + "' onchange='calculateProductLine(" + ln + ");'>"+ vat_hidden +"</select>";

	ln++;
	prodLine++;

	document.getElementById('addProductLine').onclick = function() {
		insertProductLine(ln);
		
	}
}

/**
 * Delete product line
 */
function deleteProductLine(ln)
{
	var obj = ln.parentNode.parentNode.rowIndex;
	document.getElementById('productLine').deleteRow(obj);
	// delete product note line
	document.getElementById('productLine').deleteRow(obj);
	// calculate product line total
	calculateProductLineTotal();
	prodLine--;
	
	if(prodLine == 0)
	{
		showProductHeader(false);
	}
}

/**
 * Mark product line deleted
 */
function markProductLineDeleted(ln)
{
	// collapse product line; update deleted value
	document.getElementById('product_line' + ln).style.display = 'none';
	// collapse product note line
	document.getElementById('product_note_line' + ln).style.display = 'none';
	document.getElementById('product_deleted' + ln).value = '1';
	// calculate product line total
	calculateProductLineTotal();
	prodLine--;
	
	if(prodLine == 0)
	{
		showProductHeader(false);
	}
}

function showServiceHeader(bool)
{
	if(bool)
	{
		document.getElementById("serviceHeader").style.display="table-row";
	}
	else
	{
		document.getElementById("serviceHeader").style.display="none";
	}
}

function deleteServiceLine(ln)
{
	var t1 = document.getElementById('serviceLine').cellSpacing;
	var obj = ln.parentNode.parentNode.rowIndex;
	document.getElementById('serviceLine').deleteRow(obj);
	// calculate product line total
	calculateProductLineTotal();
	servLine--;
	
	if(servLine == 0)
	{
		showServiceHeader(false);
	}
}

function markServiceLineDeleted(ln)
{
	// collapse product line; update deleted value
	document.getElementById('service_line' + ln).style.display = 'none';
	// collapse product note line
	document.getElementById('ser_deleted' + ln).value = '1';
	// calculate product line total
	calculateProductLineTotal();
	servLine--;
	
	if(servLine == 0)
	{
		showServiceHeader(false);
	}
}

function insertServiceLine(ln)
{

	if(servLine == 0)
	{
		showServiceHeader(true);
	}

	var vat_hidden=document.getElementById("vathidden").value;
	
	var x=document.getElementById('serviceLine').insertRow(-1);
	
	var a=x.insertCell(0);
	var b=x.insertCell(1);
	var c=x.insertCell(2);
	var d=x.insertCell(3);
	var e=x.insertCell(4);
		
	a.className="dataField";
	b.className="dataField";
	c.className="dataField";
	d.className="dataField";
	e.className="dataField";
	
	a.colSpan="4";
   									
	a.innerHTML="<textarea name='product_name[]' id='service_name" + ln +"' size='16' cols='60' title='' tabindex='3' maxlength='255' onkeypress='return imposeMaxLength(this);'></textarea><input type='hidden' name='product_id[]' id='service_id" + ln + "' size='20' maxlength='50' value='0'>";
	b.innerHTML="<input type='text' name='product_unit_price[]' id='service_unit_price" + ln + "' size='16' maxlength='50' value='' title='' tabindex='3'   onblur='calculateServiceLine(" + ln + ");'>";
	c.innerHTML="<input type='text' name='vat_amt[]' id='ser_vat_amt" + ln + "' size='16' maxlength='250' value='' title='' tabindex='3' readonly='readonly'><br>"+SUGAR.language.get(module, 'LBL_VAT')+" %&nbsp; :&nbsp;&nbsp;<select name='vat[]' id='ser_vat" + ln + "' onchange='calculateServiceLine(" + ln + ");'>"+ vat_hidden +"</select>";	
	d.innerHTML="<input type='text' name='product_total_price[]' id='service_total_price" + ln + "' size='16' maxlength='50' value='' title='' tabindex='3' readonly='readonly'>";
	e.innerHTML="<input type='hidden' name='product_deleted[]' id='ser_deleted" + ln + "' value='0'><input type='hidden' name='product_quote_id[]' value=''><button type='button' class='button' value='" + deleteButtonValue + "' tabindex='3' onclick='deleteServiceLine(this)'><img src='themes/default/images/id-ff-clear.png' alt='" + deleteButtonValue + "'></button><br>";

	ln++;
	servLine++

	document.getElementById('addServiceLine').onclick = function() {
		insertServiceLine(ln);
		
	}
}


function calculateServiceLine(ln)
{
	var servicePrice = document.getElementById('service_unit_price' + ln).value;
	var vat =document.getElementById('ser_vat' + ln).value;
	
	if (document.getElementById('service_name' + ln).value == ''|| servicePrice =='' ) {
		return;
	}
	
	servicePrice = unformatNumber(servicePrice);
	vat = unformatNumber(vat);

	var totalVat=(servicePrice * vat) /100;
	var serviceTotalPrice = servicePrice;
	
	//uncomment to have vat added to the totoal at the productline
	//serviceTotalPrice=servicePrice + totalVat;
	
	document.getElementById('ser_vat_amt' + ln).value = formatNumber(totalVat);
	
	document.getElementById('service_unit_price' + ln).value = formatNumber(servicePrice);
	document.getElementById('service_total_price' + ln).value = formatNumber(serviceTotalPrice);

	calculateProductLineTotal();
}



/**
 * Open product popup
 */
function openProductPopup(ln)
{ lineno=ln;
	var popupRequestData = {
		"call_back_function" : "setProductReturn",
		"form_name" : "EditView",
		"field_to_name_array" : {
			"id" : "product_id" + ln,
			"name" : "product_name" + ln,
			"cost" : "product_cost_price" + ln,
			"price" : "product_list_price" + ln
		}
	};

	open_popup('AOS_Products', 800, 850, '', true, true, popupRequestData);

}

/**
 * The reply data must be a JSON array structured with the following information:
 *  1) form name to populate
 *  2) associative array of input names to values for populating the form
 */
var fromPopupReturn  = false;
function setProductReturn(popupReplyData)
{
	fromPopupReturn = true;
	var formName = popupReplyData.form_name;
	var nameToValueArray = popupReplyData.name_to_value_array;
	
	for (var theKey in nameToValueArray)
	{
		if(theKey == 'toJSON')
		{
			/* just ignore */
		}
		else
		{
			var displayValue = nameToValueArray[theKey].replace(/&amp;/gi,'&').replace(/&lt;/gi,'<').replace(/&gt;/gi,'>').replace(/&#039;/gi,'\'').replace(/&quot;/gi,'"');;
			/** depreciated
			 window.document.forms[form_name].elements[the_key].value = displayValue;
			 */
			//alert(theKey + " => " + displayValue);
			document.getElementById(theKey).value = displayValue;
			/** uncomment to copy value on select
			 if (theKey.search('product_list_price') != -1) {
			 	var ln = theKey.slice(18);
				document.getElementById('product_unit_price' + ln).value = displayValue;
			 }
			 */
		}
	}
	formatListPrice(lineno);
	/** uncomment to copy value on select
	 calculateProductLine(ln);
	 */
//	 subcode1(document.getElementById('product_id' + lineno).value);
}

/**
 * Calculate product line
 */
function calculateProductLine(ln)
{
	var productQty = Number(document.getElementById('product_qty' + ln).value);
	var productUnitPrice = document.getElementById('product_unit_price' + ln).value;
	var vat =document.getElementById('vat' + ln).value;
	
	

	
	if (document.getElementById('product_list_price' + ln).value == '') {
		return;
	}
	else if(productQty == ''){
	document.getElementById('product_qty' + ln).value =1;
	document.getElementById('qty_product_qty' +ln).value =1;
	productQty = 1;
	}
	
	productUnitPrice = unformatNumber(productUnitPrice);
	vat = unformatNumber(vat);

	var productTotalPrice = productQty * productUnitPrice;

	
	var totalvat=(productTotalPrice * vat) /100;
	
	//uncomment to have vat added to the totoal at the productline
	//productTotalPrice=productTotalPrice + totalvat;
	
	document.getElementById('vat_amt' + ln).value = formatNumber(totalvat);
	
	document.getElementById('product_unit_price' + ln).value = formatNumber(productUnitPrice);
	document.getElementById('product_total_price' + ln).value = formatNumber(productTotalPrice);
	
	calculateProductLineTotal();
}

/**
 * Calculate product line total
 */
function calculateProductLineTotal()
{
	var length = document.getElementById('productLine').getElementsByTagName('tr').length;
	var row = document.getElementById('productLine').getElementsByTagName('tr');
	var subtotal = 0;
	var dis_tot = 0;
	var tax_vat = 0;
	
	for (i=1; i < length; i++) {
		var qty = 0;
		var price = 0;
		var deleted = 0;
		var dis_amt = 0;
		var vat_amt = 0;

		var input = row[i].getElementsByTagName('input');
		for (j=0; j < input.length; j++) {
			if (input[j].id.indexOf('product_qty') != -1) {
				qty = input[j].value;
			}
			if (input[j].id.indexOf('product_unit_price') != -1) 
			{
				price = unformatNumber(input[j].value);
			}
			if (input[j].id.indexOf('product_discount_amount') != -1) 
			{
				dis_amt = unformatNumber(input[j].value);
			}
			if (input[j].id.indexOf('vat_amt') != -1) 
			{
				vat_amt = unformatNumber(input[j].value);
			}
			
						
			// insufficient; depreciated
			if (input[j].id.indexOf('product_deleted') != -1) {
				deleted = input[j].value;
			}
			
		}
		if (qty != 0 && price != 0 && deleted != 1) {
			
			subtotal += price * qty;
		}
		if (dis_amt != 0 && deleted != 1) {
			dis_tot += dis_amt * qty;
			
		}
		if (vat_amt != 0 && deleted != 1) {
			tax_vat += vat_amt;
			
		}
		
	}
	
	var servLength = document.getElementById('serviceLine').getElementsByTagName('tr').length;
	var servRow = document.getElementById('serviceLine').getElementsByTagName('tr');
	
	for (i=1; i < servLength; i++) {
		var qty = 0;
		var price = 0;
		var deleted = 0;
		var dis_amt = 0;
		var vat_amt = 0;

		var input = servRow[i].getElementsByTagName('input');
		for (j=0; j < input.length; j++) {
			if (input[j].id.indexOf('service_unit_price') != -1) 
			{
				price = unformatNumber(input[j].value);
			}
			if (input[j].id.indexOf('ser_vat_amt') != -1) 
			{
				vat_amt = unformatNumber(input[j].value);
			}
			
						
			// insufficient; depreciated
			if (input[j].id.indexOf('ser_deleted') != -1) {
				deleted = input[j].value;
			}
			
		}
		if (price != 0 && deleted != 1) {
			
			subtotal += price;
		}
		if (vat_amt != 0 && deleted != 1) {
			tax_vat += vat_amt;
			
		}
		
	}
	
	
	var total_price =subtotal;
	 
	document.getElementById('subtotal_amount').value = formatNumber(subtotal);
	var taxcal=document.getElementById('subtotal_amount').value;
	
	document.getElementById('discount_amount').value = formatNumber(dis_tot);
	
	var tot_amt = subtotal - dis_tot;
	
	document.getElementById('total_amt').value = formatNumber(tot_amt);
	
	if(document.getElementById('tax_amount') != null)
	{
		document.getElementById('tax_amount').value = formatNumber(tax_vat);
	}
	
	var taxcal1= parseInt(unformatNumber(taxcal));
	calculateGrandTotal(total_price,subtotal);


}

/**
 * Calculate grand total
 */
function calculateGrandTotal(totprice,subtot)
{
	var tax = document.getElementById('tax_amount');
	var shipping = document.getElementById('shipping_amount');
	var subtotal_tax = document.getElementById('subtotal_tax_amount');
	var subtotal = unformatNumber(document.getElementById('subtotal_amount').value);
	if(shipping != null && tax != null)
	{
		tax = unformatNumber(tax.value);
		shipping = unformatNumber(shipping.value);
		var total = subtotal + tax + shipping;
	}
	else if(shipping == null && tax != null)
	{
		tax = unformatNumber(tax.value);
		var total = subtotal + tax;
	}
	else if(shipping != null && tax == null)
	{
		shipping = unformatNumber(shipping.value);
		var total = subtotal + shipping;
	}
	else
	{
		var total = subtotal;
	}
	
	if(subtotal_tax != null && tax != null)
	{
		document.getElementById('subtotal_tax_amount').value = formatNumber(subtotal + tax);
	}
	document.getElementById('total_amount').value = formatNumber(total);
}

function formatListPrice(ln)
{
	document.getElementById('product_list_price' + ln).value = formatNumber(document.getElementById('product_list_price' + ln).value);
	calculateDiscount(ln);
}

function unformatNumber(str)
{
	var grp_sep = String(document.getElementById('grp_seperator').value);
	var dec_sep = String(document.getElementById('dec_seperator').value);
	
	str = String(str);
	
	str = str.replace(grp_sep, '');
	str = str.replace(grp_sep, '');
	str = str.replace(grp_sep, '');
	str = str.replace(grp_sep, '');
	
	str = str.replace(dec_sep, '.');
	
	num = Number(str);
	
	return num;
}

function formatNumber(str)
{
	var sig_dig = Number(document.getElementById('significant_digits').value);
	var grp_sep = String(document.getElementById('grp_seperator').value);
	var dec_sep = String(document.getElementById('dec_seperator').value);
	
	num = Number(str);
	if(sig_dig == 2){
		str = formatCurrency(num);
	}
	else{
		str =	num.toFixed(sig_dig);
	}
	str = str.replace(/,/, '{,}').replace(/\./, '{.}');
	str = str.replace(/{,}/, grp_sep).replace(/{.}/, dec_sep);
	
	return str;
}


function Quantity_formatNumber(ln)
{
	var qty=document.getElementById('qty_product_qty' + ln).value;
	qty=qty.replace(/,/, '');
	document.getElementById('product_qty' + ln).value = Number(qty);

	
	var str=document.getElementById('qty_product_qty' + ln).value;

	num = Number(qty);
	str = formatCurrency(num);
	str=str.split('.00')
	document.getElementById('qty_product_qty' + ln).value=str[0];
	//return str;
}


function formatCurrency(strValue)
{
	strValue = strValue.toString().replace(/\$|\,/g,'');
	dblValue = parseFloat(strValue);

	blnSign = (dblValue == (dblValue = Math.abs(dblValue)));
	dblValue = Math.floor(dblValue*100+0.50000000001);
	intCents = dblValue%100;
	strCents = intCents.toString();
	dblValue = Math.floor(dblValue/100).toString();
	if(intCents<10)
		strCents = "0" + strCents;
	for (var i = 0; i < Math.floor((dblValue.length-(1+i))/3); i++)
		dblValue = dblValue.substring(0,dblValue.length-(4*i+3))+','+
		dblValue.substring(dblValue.length-(4*i+3));
	return (((blnSign)?'':'-') + dblValue + '.' + strCents);
}

function imposeMaxLength(obj)
{
var mlength=obj.getAttribute? parseInt(obj.getAttribute("maxlength")) : ""
if (obj.getAttribute && obj.value.length>mlength)
obj.value=obj.value.substring(0,mlength)
}
