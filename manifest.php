<?php

/**
 * Advanced, robust set of sales and support modules.
 * @package Advanced OpenSales for SugarCRM
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
 
$manifest = array(
    'acceptable_sugar_versions' => array (
      'regex_matches' => array (
		0 => "6.*",
		1 => "5.*",
      ),
    ),
    'acceptable_sugar_flavors' => array (
		0 => 'OS',
		1 => 'CE',
    ),
    'name'			=> 'Advanced OpenSales',
    'description'		=> 'This module is for creating and managing sales and service Quotes, Contracts and Invoices.',
    'author'			=> 'SalesAgility.com',
    'published_date'		=> '2011-07-21',
    'version'			=> '5.0',
    'type'			=> 'module',
    'icon'			=> '',
    'is_uninstallable'	=> true,
    'remove_tables'		=> 'prompt',
);
$installdefs = array (
  'id' => 'AdvancedOpenSales',
  'beans' => 
  array (
	0 => 
	array (
	'module' => 'AOS_Contracts',
	'class' => 'AOS_Contracts',
	'path' => 'modules/AOS_Contracts/AOS_Contracts.php',
	'tab' => true,
    ),
    1 => 
    array (
      'module' => 'AOS_Invoices',
      'class' => 'AOS_Invoices',
      'path' => 'modules/AOS_Invoices/AOS_Invoices.php',
      'tab' => true,
    ),
    2 => 
    array (
      'module' => 'AOS_PDF_Templates',
      'class' => 'AOS_PDF_Templates',
      'path' => 'modules/AOS_PDF_Templates/AOS_PDF_Templates.php',
      'tab' => true,
    ),
    3 => 
    array (
      'module' => 'AOS_Products',
      'class' => 'AOS_Products',
      'path' => 'modules/AOS_Products/AOS_Products.php',
      'tab' => true,
    ),
    4 => 
    array (
      'module' => 'AOS_Products_Quotes',
      'class' => 'AOS_Products_Quotes',
      'path' => 'modules/AOS_Products_Quotes/AOS_Products_Quotes.php',
      'tab' => false,
    ),
    5 => 
    array (
      'module' => 'AOS_Quotes',
      'class' => 'AOS_Quotes',
      'path' => 'modules/AOS_Quotes/AOS_Quotes.php',
      'tab' => true,
    ),
    6 => 
    array (
      'module' => 'aos_movements',
      'class' => 'aos_movements',
      'path' => 'modules/aos_movements/aos_movements.php',
      'tab' => true,
    ),
  ),
  'layoutdefs' => 
  array (
    1 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/layoutdefs/Project.php',
      'to_module' => 'Project',
    ),
    2 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/layoutdefs/Account.php',
      'to_module' => 'Accounts',
    ),
    3 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/layoutdefs/Contact.php',
      'to_module' => 'Contacts',
    ),
    4 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/layoutdefs/Opportunity.php',
      'to_module' => 'Opportunities',
    ),
    6 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/layoutdefs/aos_movements_aos_products_AOS_Products.php',
      'to_module' => 'AOS_Products',
    ),
  ),
  'relationships' => 
  array (
    0 => 
    array (
      'meta_data' => '<basepath>/SugarModules/relationships/relationships/aos_quotes_projectMetaData.php',
    ),
    1 => 
    array (
      'meta_data' => '<basepath>/SugarModules/relationships/relationships/aos_quotes_aos_invoicesMetaData.php',
    ),
    2 => 
    array (
      'meta_data' => '<basepath>/SugarModules/relationships/relationships/aos_quotes_aos_contractsMetaData.php',
    ),
    3 => 
    array (
      'meta_data' => '<basepath>/SugarModules/relationships/relationships/aos_movements_aos_productsMetaData.php',
    ),
  ),
  'image_dir' => '<basepath>/icons',
  'copy' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/SugarModules/modules/AOS_Contracts',
      'to' => 'modules/AOS_Contracts',
    ),
    1 => 
    array (
      'from' => '<basepath>/SugarModules/modules/AOS_Invoices',
      'to' => 'modules/AOS_Invoices',
    ),
    2 => 
    array (
      'from' => '<basepath>/SugarModules/modules/AOS_PDF_Templates',
      'to' => 'modules/AOS_PDF_Templates',
    ),
    3 => 
    array (
      'from' => '<basepath>/SugarModules/modules/AOS_Products',
      'to' => 'modules/AOS_Products',
    ),
    4 => 
    array (
      'from' => '<basepath>/SugarModules/modules/AOS_Products_Quotes',
      'to' => 'modules/AOS_Products_Quotes',
    ),
    5 => 
    array (
      'from' => '<basepath>/SugarModules/modules/AOS_Quotes',
      'to' => 'modules/AOS_Quotes',
    ),
    6 => 
    array (
      'from' => '<basepath>/SugarModules/modules/Emails/Compose.php',
      'to' => 'custom/modules/Emails/Compose.php',
    ),
    7 => 
    array (
      'from' => '<basepath>/SugarModules/modules/Accounts',
      'to' => 'custom/modules/Accounts',
    ),
    8 => 
    array (
      'from' => '<basepath>/SugarModules/modules/Contacts',
      'to' => 'custom/modules/Contacts',
    ),
    9 => 
    array (
      'from' => '<basepath>/SugarModules/modules/Leads',
      'to' => 'custom/modules/Leads',
    ),
    10 => 
    array (
      'from' => '<basepath>/SugarModules/modules/aos_movements',
      'to' => 'modules/aos_movements',
    ),
  ),
  'language' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/SugarModules/language/application/en_us.lang.php',
      'to_module' => 'application',
      'language' => 'en_us',
    ),
    1 => 
    array (
      'from' => '<basepath>/SugarModules/language/application/ge_ge.lang.php',
      'to_module' => 'application',
      'language' => 'ge_ge',
    ),
    2 =>
    array (
      'from' => '<basepath>/SugarModules/language/application/ru_ru.lang.php',
      'to_module' => 'application',
      'language' => 'ru_ru',
    ),
    3 => 
    array (
      'from' => '<basepath>/SugarModules/language/application/es_es.lang.php',
      'to_module' => 'application',
      'language' => 'es_es',
    ),
    4 =>
    array (
      'from' => '<basepath>/SugarModules/language/application/it_it.lang.php',
      'to_module' => 'application',
      'language' => 'it_it',
    ),
    5 =>
    array (
      'from' => '<basepath>/SugarModules/language/application/fi_fi.lang.php',
      'to_module' => 'application',
      'language' => 'fi_fi',
    ),
    6 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/aos_movements.php',
      'to_module' => 'aos_movements',
      'language' => 'en_us',
    ),
    7 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/AOS_Products.php',
      'to_module' => 'AOS_Products',
      'language' => 'en_us',
    ),
    8 => 
    array (
      'from' => '<basepath>/SugarModules/language/application/en_us.lang.php',
      'to_module' => 'application',
      'language' => 'en_us',
    ),
  ),
  'vardefs' => 
  array (
    1 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/vardefs/Project.php',
      'to_module' => 'Project',
    ),
    2 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/vardefs/Account.php',
      'to_module' => 'Accounts',
    ),
    3 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/vardefs/Contact.php',
      'to_module' => 'Contacts',
    ),
    4 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/vardefs/Opportunity.php',
      'to_module' => 'Opportunities',
    ),
    5 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/vardefs/aos_movements_aos_products_aos_movements.php',
      'to_module' => 'aos_movements',
    ),
    6 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/vardefs/aos_movements_aos_products_AOS_Products.php',
      'to_module' => 'AOS_Products',
    ),
  ),
);
