<?php
// created: 2010-12-20 02:55:45
$layout_defs["Project"]["subpanel_setup"]["aos_quotes_project"] = array (
  'order' => 100,
  'module' => 'AOS_Quotes',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'AOS_QUOTES',
  'get_subpanel_data' => 'aos_quotes_project',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopCreateButton',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'popup_module' => 'AOS_Quotes',
      'mode' => 'MultiSelect',
    ),
  ),
);
?>
