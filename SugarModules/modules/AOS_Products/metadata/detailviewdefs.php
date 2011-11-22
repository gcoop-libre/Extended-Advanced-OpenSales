<?php
$module_name = 'AOS_Products';
$viewdefs [$module_name] = 
array (
  'DetailView' => 
  array (
    'templateMeta' => 
    array (
      'form' => 
      array (
        'buttons' => 
        array (
          0 => 'EDIT',
          1 => 'DUPLICATE',
          2 => 'DELETE',
        ),
      ),
      'maxColumns' => '1',
      'widths' => 
      array (
        0 => 
        array (
          'label' => '5',
          'field' => '60',
        ),
      ),
    'includes'=>
    array(
        array(
            'file' => 'modules/AOS_Products/js/jquery.js', 
        ),
        array(
            'file' => 'modules/AOS_Products/js/jquery.jqplot.js', 
        ),
        array(
            'file' => 'modules/AOS_Products/js/jqplot.highlighter.js', 
        ),
        array(
            'file' => 'modules/AOS_Products/js/jqplot.cursor.js', 
        ),
        array(
            'file' => 'modules/AOS_Products/js/jqplot.dateAxisRenderer.js', 
        ),
        array(
            'file' => 'modules/AOS_Products/js/jqplot.canvasTextRenderer.js', 
        ),
        array(
            'file' => 'modules/AOS_Products/js/jqplot.canvasAxisTickRenderer.js', 
        ),
        array(
            'file' => 'modules/AOS_Products/js/graph.js', 
        ),
    ),
    ),
    'panels' => 
    array (
      'default' => 
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'maincode',
            'label' => 'LBL_MAINCODE',
          ),
          1 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'name',
            'label' => 'LBL_NAME',
          ),
          1 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'part_number',
            'label' => 'LBL_PART_NUMBER',
          ),
          1 => NULL,
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'category',
            'label' => 'LBL_CATEGORY',
          ),
          1 => NULL,
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'type',
            'label' => 'LBL_TYPE',
          ),
          1 => NULL,
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'cost',
            'label' => 'LBL_COST',
          ),
          1 => NULL,
        ),
        6 => 
        array (
          0 => 
          array (
            'name' => 'price',
            'label' => 'LBL_PRICE',
          ),
          1 => NULL,
        ),
        7 => 
        array (
          0 => 
          array (
            'name' => 'stock',
            'label' => 'LBL_STOCK',
          ),
          1 => NULL,
        ),
        8 => 
        array (
          0 => 
          array (
            'name' => 'order_point',
            'label' => 'LBL_ORDER_POINT',
          ),
          1 => NULL,
        ),
        9 => 
        array (
          0 => 
          array (
            'name' => 'url',
            'label' => 'LBL_URL',
          ),
          1 => NULL,
        ),
        10 => 
        array (
          0 => 
          array (
            'name' => 'contact',
            'label' => 'LBL_CONTACT',
          ),
          1 => NULL,
        ),
        11 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'label' => 'LBL_DESCRIPTION',
          ),
          1 => NULL,
        ),
        12 => 
        array (
          0 => 
          array (
            'name' => 'chart1',
            'label' => 'LBL_DIV_GRAPH',
            'customCode' => '<div id="chart_reset"><button value="reset" type="button" onclick="plot.resetZoom();">Zoom Out</button></div>
                            <div id="chart1" style="height:400px;width:100%;"></div>
                            <script type="text/javascript">chart_values_json = {$CHART_VALUES};</script>
                            <script type="text/javascript">chart_values_op_json = {$CHART_VALUES_OP};</script>
                            <script type="text/javascript">date_format_pref_str = "{$DATE_FORMAT_PREF}";</script>',
          ),
          1 => NULL,
        ),
      ),
    ),
  ),
);
?>
