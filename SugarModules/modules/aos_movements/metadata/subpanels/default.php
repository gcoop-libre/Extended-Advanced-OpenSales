<?php
$module_name='aos_movements';
$subpanel_layout = array (
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopCreateButton',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'popup_module' => 'aos_movements',
    ),
  ),
  'where' => '',
  'list_fields' => 
  array (
    'name' => 
    array (
      'vname' => 'LBL_NAME',
      'widget_class' => 'SubPanelDetailViewLink',
      'width' => '15%',
      'default' => true,
    ),
    'quantity' => 
    array (
      'type' => 'int',
      'vname' => 'LBL_QUANTITY',
      'width' => '10%',
      'default' => true,
    ),
    'direction' => 
    array (
      'type' => 'radioenum',
      'default' => true,
      'studio' => 'visible',
      'vname' => 'LBL_DIRECTION',
      'width' => '10%',
    ),
    'date_entered' => 
    array (
      'type' => 'datetime',
      'vname' => 'LBL_DATE_ENTERED',
      'width' => '10%',
      'default' => true,
    ),
    'created_by_name' => 
    array (
      'type' => 'relate',
      'link' => 'created_by_link',
      'vname' => 'LBL_CREATED',
      'width' => '10%',
      'default' => true,
    ),
    'description' => 
    array (
      'type' => 'text',
      'vname' => 'LBL_DESCRIPTION',
      'sortable' => false,
      'width' => '10%',
      'default' => true,
    ),
    'edit_button' => 
    array (
      'widget_class' => 'SubPanelEditButton',
      'module' => 'aos_movements',
      'width' => '4%',
      'default' => true,
    ),

  ),
);
