<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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

require_once('include/Dashlets/DashletGeneric.php');
require_once('modules/aos_movements/aos_movements.php');

class aos_movementsDashlet extends DashletGeneric { 
    function aos_movementsDashlet($id, $def = null) {
		global $current_user, $app_strings;
		require('modules/aos_movements/metadata/dashletviewdefs.php');

        parent::DashletGeneric($id, $def);

        if(empty($def['title'])) $this->title = translate('LBL_HOMEPAGE_TITLE', 'aos_movements');

        $this->searchFields = $dashletData['aos_movementsDashlet']['searchFields'];
        $this->columns = $dashletData['aos_movementsDashlet']['columns'];

        $this->seedBean = new aos_movements();        
    }
}
