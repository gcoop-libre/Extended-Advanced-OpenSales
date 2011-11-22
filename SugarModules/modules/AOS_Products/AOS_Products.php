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

/**
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */
require_once('modules/AOS_Products/AOS_Products_sugar.php');
class AOS_Products extends AOS_Products_sugar {
	
	function AOS_Products(){	
		parent::AOS_Products_sugar();
	}

    function GetStockValues()
    {

        $db = DBManagerFactory::getInstance();
        $query = "(
                    SELECT DATE(aosp.date_entered) AS date, aos.before_value_string AS stock
                    FROM aos_products aosp 
                    INNER JOIN aos_products_audit aos on (aosp.id = aos.parent_id)
                    WHERE 
                    aos.parent_id = '".$this->id."' AND
                    aos.field_name = 'stock'
                    ORDER BY date_entered DESC
                    LIMIT 1
                    )
                    UNION ALL
                    (
                    SELECT DATE(date_created) AS date, after_value_string AS stock
                    FROM aos_products_audit aos
                    INNER JOIN aos_products aosp ON (aos.parent_id = aosp.id)
                    WHERE 
                    aos.parent_id = '".$this->id."' AND
                    aos.field_name = 'stock'
                    ORDER BY date_created ASC
                    )
                    UNION ALL
                    (
                    SELECT CURDATE() AS date, stock AS stock
                    FROM aos_products
                    WHERE id ='".$this->id."'
                    );";

        $result = $db->query($query, $dieOnError=true);

        while ($row = $db->fetchByAssoc($result))
        {
            $values[] = array($row['date'], (int) $row['stock']);
        }
        return ($values);
    }

    function GetOrderPointValues()
    {

        $db = DBManagerFactory::getInstance();
        $query = "(
                    SELECT DATE(aosp.date_entered) AS date, aos.before_value_string AS order_point
                    FROM aos_products aosp 
                    INNER JOIN aos_products_audit aos on (aosp.id = aos.parent_id)
                    WHERE 
                    aos.parent_id = '".$this->id."' AND
                    aos.field_name = 'order_point'
                    ORDER BY date_entered DESC
                    LIMIT 1
                    )
                    UNION ALL
                    (
                    SELECT DATE(date_created) AS date, after_value_string AS order_point
                    FROM aos_products_audit aos
                    INNER JOIN aos_products aosp ON (aos.parent_id = aosp.id)
                    WHERE 
                    aos.parent_id = '".$this->id."' AND
                    aos.field_name = 'order_point'
                    ORDER BY date_created ASC
                    ) 
                    UNION ALL
                    (
                    SELECT CURDATE() AS date, order_point AS order_point
                    FROM aos_products
                    WHERE id ='".$this->id."'
                    );";

        $result = $db->query($query, $dieOnError=true);
        while ($row = $db->fetchByAssoc($result))
        {
            $values[] = array($row['date'], (int) $row['order_point']);
        }
        return ($values);
    }
	
}
?>
