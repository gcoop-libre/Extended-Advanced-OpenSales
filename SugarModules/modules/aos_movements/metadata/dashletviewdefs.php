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
$dashletData['aos_movementsDashlet']['searchFields'] = array (
  'date_entered' => 
  array (
    'default' => '',
  ),
  'date_modified' => 
  array (
    'default' => '',
  ),
  'quantity' => 
  array (
    'default' => '',
  ),
  'direction' => 
  array (
    'default' => '',
  ),
  'aos_movements_aos_products_name' => 
  array (
    'default' => '',
  ),
);
$dashletData['aos_movementsDashlet']['columns'] = array (
  'aos_movements_aos_products_name' => 
  array (
    'type' => 'relate',
    'link' => 'aos_movements_aos_products',
    'label' => 'LBL_AOS_MOVEMENTS_AOS_PRODUCTS_FROM_AOS_PRODUCTS_TITLE',
    'width' => '10%',
    'default' => true,
  ),
  'quantity' => 
  array (
    'type' => 'int',
    'label' => 'LBL_QUANTITY',
    'width' => '10%',
    'default' => true,
  ),
  'direction' => 
  array (
    'type' => 'radioenum',
    'default' => true,
    'studio' => 'visible',
    'label' => 'LBL_DIRECTION',
    'width' => '10%',
  ),
  'created_by_name' => 
  array (
    'type' => 'relate',
    'link' => 'created_by_link',
    'label' => 'LBL_CREATED',
    'width' => '10%',
    'default' => true,
  ),
  'date_entered' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_ENTERED',
    'default' => true,
    'name' => 'date_entered',
  ),
  'date_modified' => 
  array (
    'width' => '15%',
    'label' => 'LBL_DATE_MODIFIED',
    'name' => 'date_modified',
    'default' => false,
  ),
  'name' => 
  array (
    'width' => '40%',
    'label' => 'LBL_LIST_NAME',
    'link' => true,
    'default' => false,
    'name' => 'name',
  ),
  'created_by' => 
  array (
    'width' => '8%',
    'label' => 'LBL_CREATED',
    'name' => 'created_by',
    'default' => false,
  ),
  'assigned_user_name' => 
  array (
    'width' => '8%',
    'label' => 'LBL_LIST_ASSIGNED_USER',
    'name' => 'assigned_user_name',
    'default' => false,
  ),
);
