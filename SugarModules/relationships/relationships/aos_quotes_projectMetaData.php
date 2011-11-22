<?php
// created: 2010-12-20 02:56:13
$dictionary["aos_quotes_project"] = array (
  'true_relationship_type' => 'many-to-many',
  'relationships' => 
  array (
    'aos_quotes_project' => 
    array (
      'lhs_module' => 'AOS_Quotes',
      'lhs_table' => 'aos_quotes',
      'lhs_key' => 'id',
      'rhs_module' => 'Project',
      'rhs_table' => 'project',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'aos_quotes_project_c',
      'join_key_lhs' => 'aos_quotes1112_quotes_ida',
      'join_key_rhs' => 'aos_quotes7207project_idb',
    ),
  ),
  'table' => 'aos_quotes_project_c',
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
      'name' => 'aos_quotes1112_quotes_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'aos_quotes7207project_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'aos_quotes_projectspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'aos_quotes_project_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'aos_quotes1112_quotes_ida',
        1 => 'aos_quotes7207project_idb',
      ),
    ),
  ),
);
?>
