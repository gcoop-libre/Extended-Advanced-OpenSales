<?php
// created: 2011-06-01 19:54:03
$layout_defs["AOS_Products"]["subpanel_setup"]["aos_movements_aos_products"] = array (
  'order' => 100,
  'module' => 'aos_movements',
  'subpanel_name' => 'default',
  'sort_order' => 'desc',
  'sort_by' => 'date_entered',
  'title_key' => 'LBL_AOS_MOVEMENTS_AOS_PRODUCTS_FROM_AOS_MOVEMENTS_TITLE',
  'get_subpanel_data' => 'aos_movements_aos_products',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
?>
