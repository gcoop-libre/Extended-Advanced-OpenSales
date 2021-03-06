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
/**
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */
require_once('modules/aos_movements/aos_movements_sugar.php');
class aos_movements extends aos_movements_sugar {
	
	function aos_movements(){	
		parent::aos_movements_sugar();
	}

    public function save($check_notify = FALSE)
    {
        $product = new AOS_Products;
        $product->retrieve($this->aos_product_id);

        $this->name = 'm-'.$this->direction.'-'.$this->quantity;

        switch ($this->direction)
        {
            case 'in':
                $product->stock = $product->stock + $this->quantity;
                $product->save();
            break;
            
            case 'out':
                if ($product->stock - $this->quantity >= 0)
                {
                    $product->stock = $product->stock - $this->quantity;
                    $product->save();
                }
                else
                {
                    echo "No tiene suficiente stock.";
                    exit(1);  
                }           
            break;
        }     
        parent::save($check_notify);        
    }

}
?>

