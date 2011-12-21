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
$dictionary['aos_movements'] = array(
                                   'table'=>'aos_movements',
                                   'audited'=>true,
                                   'fields'=>array (
                                       'quantity' =>
                                       array (
                                               'required' => true,
                                               'name' => 'quantity',
                                               'vname' => 'LBL_QUANTITY',
                                               'type' => 'float',
                                               'massupdate' => 1,
                                               'default' => '0.000',
                                               'comments' => '',
                                               'help' => '',
                                               'importable' => true,
                                               'duplicate_merge' => 'disabled',
                                               'duplicate_merge_dom_value' => '0',
                                               'audited' => true,
                                               'len' => '18',
                                               'precision' => '3',
                                       ),
                                       'direction' =>
                                       array (
                                               'required' => true,
                                               'name' => 'direction',
                                               'vname' => 'LBL_DIRECTION',
                                               'type' => 'radioenum',
                                               'massupdate' => 0,
                                               'default' => 'in',
                                               'comments' => '',
                                               'help' => '',
                                               'importable' => 'true',
                                               'duplicate_merge' => 'disabled',
                                               'duplicate_merge_dom_value' => '0',
                                               'audited' => true,
                                               'reportable' => true,
                                               'len' => 100,
                                               'size' => '20',
                                               'options' => 'utn_direction_list',
                                               'studio' => 'visible',
                                               'dbType' => 'enum',
                                               'separator' => '<br>',
                                       ),
                                   ),
                                   'relationships'=>array (
                                   ),
                                   'optimistic_locking'=>true,
                               );
if (!class_exists('VardefManager'))
{
    require_once('include/SugarObjects/VardefManager.php');
}
VardefManager::createVardef('aos_movements','aos_movements', array('basic','assignable'));
