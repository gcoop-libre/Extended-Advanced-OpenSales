<?php
/**
 * Extensions to SugarCRM
 * @package Advanced OpenSales for SugarCRM
 * @subpackage Movements
 * @copyright José C. Massón
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
 * @author José C. Massón <jose@gcoop.coop>
 */
$module_name = 'aos_movements';
 $metafiles[$module_name] = array(
	'detailviewdefs'  => 	'modules/' . $module_name . '/metadata/detailviewdefs.php', 	
	'editviewdefs'    => 	'modules/' . $module_name . '/metadata/editviewdefs.php',
 	'listviewdefs'    => 	'modules/' . $module_name . '/metadata/listviewdefs.php',
 	'searchdefs'      =>    'modules/' . $module_name . '/metadata/searchdefs.php',
 	'popupdefs'	      =>    'modules/' . $module_name . '/metadata/popupdefs.php',
 	'searchfields'	  =>    'modules/' . $module_name . '/metadata/SearchFields.php',
 );
?>
