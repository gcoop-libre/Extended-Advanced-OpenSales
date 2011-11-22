<?php
// created: 2011-06-01 19:54:03
$dictionary["aos_movements"]["fields"]["aos_movements_aos_products"] = array (
  'name' => 'aos_movements_aos_products',
  'type' => 'link',
  'relationship' => 'aos_movements_aos_products',
  'source' => 'non-db',
  'vname' => 'LBL_AOS_MOVEMENTS_AOS_PRODUCTS_FROM_AOS_PRODUCTS_TITLE',
);
$dictionary["aos_movements"]["fields"]["aos_movements_aos_products_name"] = array (
  'name' => 'aos_movements_aos_products_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_AOS_MOVEMENTS_AOS_PRODUCTS_FROM_AOS_PRODUCTS_TITLE',
  'save' => true,
  'id_name' => 'aos_product_id',
  'link' => 'aos_movements_aos_products',
  'table' => 'aos_products',
  'module' => 'AOS_Products',
  'rname' => 'name',
);
$dictionary["aos_movements"]["fields"]["aos_product_id"] = array (
  'name' => 'aos_product_id',
  'type' => 'link',
  'relationship' => 'aos_movements_aos_products',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_AOS_MOVEMENTS_AOS_PRODUCTS_FROM_AOS_MOVEMENTS_TITLE',
);
