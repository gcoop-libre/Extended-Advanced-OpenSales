<?php
// created: 2011-05-13 09:49:00
$dictionary["aos_quotes_aos_contracts"] = array (
  'true_relationship_type' => 'many-to-many',
  'relationships' => 
  array (
    'aos_quotes_aos_contracts' => 
    array (
      'lhs_module' => 'AOS_Quotes',
      'lhs_table' => 'aos_quotes',
      'lhs_key' => 'id',
      'rhs_module' => 'AOS_Contracts',
      'rhs_table' => 'aos_contracts',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'aos_quotes_os_contracts_c',
      'join_key_lhs' => 'aos_quotese81e_quotes_ida',
      'join_key_rhs' => 'aos_quotes4dc0ntracts_idb',
    ),
  ),
  'table' => 'aos_quotes_os_contracts_c',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'id',
      'type' => 'varchar',
      'len' => 36,
    ),
    1 => 
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    2 => 
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'len' => '1',
      'default' => '0',
      'required' => true,
    ),
    3 => 
    array (
      'name' => 'aos_quotese81e_quotes_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'aos_quotes4dc0ntracts_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'aos_quotes_aos_contractsspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'aos_quotes_aos_contracts_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'aos_quotese81e_quotes_ida',
        1 => 'aos_quotes4dc0ntracts_idb',
      ),
    ),
  ),
);
?>
