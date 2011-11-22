<?php
// created: 2011-06-01 19:54:03
$dictionary["aos_movements_aos_products"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'aos_movements_aos_products' => 
    array (
      'lhs_module' => 'AOS_Products',
      'lhs_table' => 'aos_products',
      'lhs_key' => 'id',
      'rhs_module' => 'aos_movements',
      'rhs_table' => 'aos_movements',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'aos_movements_aos_products',
      'join_key_lhs' => 'aos_product_id',
      'join_key_rhs' => 'aos_movement_id',
    ),
  ),
  'table' => 'aos_movements_aos_products',
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
      'name' => 'aos_product_id',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'aos_movement_id',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' => 
  array (
    0 => 
    array (
      'name' => 'aos_movemens_aos_productsspk',
      'type' => 'primary',
      'fields' => 
      array (
        0 => 'id',
      ),
    ),
    1 => 
    array (
      'name' => 'aos_movemens_aos_products_ida1',
      'type' => 'index',
      'fields' => 
      array (
        0 => 'aos_product_id',
      ),
    ),
    2 => 
    array (
      'name' => 'aos_movemens_aos_products_alt',
      'type' => 'alternate_key',
      'fields' => 
      array (
        0 => 'aos_movement_id',
      ),
    ),
  ),
);
?>
