<?php
$module_name = 'AOS_PDF_Templates';
$viewdefs [$module_name] = 
array (
  'EditView' => 
  array (
    'templateMeta' => 
    array (
      'maxColumns' => '2',
      'widths' => 
      array (
        0 => 
        array (
          'label' => '10',
          'field' => '60',
        ),
        1 => 
        array (
          'label' => '10',
          'field' => '30',
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
            'name' => 'name',
            'label' => 'LBL_NAME',
          ),
        ),
        1 => 
        array (
           0 => 
          array (
            'name' => 'type',
            'label' => 'LBL_TYPE',
			'customCode' => '{$CUSTOM_TYPE}',
          ),
          1 =>
         array (
            'name' => 'sample',
            'label' => 'LBL_SAMPLE',
			'customCode' => '{$CUSTOM_SAMPLE}',	
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'insert_fields',
            'label' => 'LBL_INSERT_FIELDS',
			'customCode' => '{$INSERT_FIELDS}',
          ),
	),
	 3 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'label' => 'LBL_DESCRIPTION',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'pdfheader',
            'label' => 'LBL_HEADER',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'pdffooter',
            'label' => 'LBL_FOOTER',
          ),
        ),
      ),
    ),
  ),
);
?>
