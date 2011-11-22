<?php
// created: 2010-12-20 02:55:45
$dictionary["Account"]["fields"]["aos_quotes"] = array (
  'name' => 'aos_quotes',
    'type' => 'link',
    'relationship' => 'account_aos_quotes',
    'module'=>'AOS_Quotes',
    'bean_name'=>'AOS_Quotes',
    'source'=>'non-db',
);
?>
<?php
// created: 2010-12-20 02:56:01
$dictionary["Account"]["relationships"]["account_aos_quotes"] = array (
	'lhs_module'=> 'Accounts', 
	'lhs_table'=> 'accounts', 
	'lhs_key' => 'id',
	'rhs_module'=> 'AOS_Quotes', 
	'rhs_table'=> 'aos_quotes', 
	'rhs_key' => 'billing_account_id',
	'relationship_type'=>'one-to-many',
);
?>
<?php
// created: 2010-12-20 02:56:01
$dictionary["Account"]["fields"]["aos_invoices"] = array (
  'name' => 'aos_invoices',
    'type' => 'link',
    'relationship' => 'account_aos_invoices',
    'module'=>'AOS_Invoices',
    'bean_name'=>'AOS_Invoices',
    'source'=>'non-db',
);
?>
<?php
// created: 2010-12-20 02:56:01
$dictionary["Account"]["relationships"]["account_aos_invoices"] = array (
	'lhs_module'=> 'Accounts', 
	'lhs_table'=> 'accounts', 
	'lhs_key' => 'id',
	'rhs_module'=> 'AOS_Invoices', 
	'rhs_table'=> 'aos_invoices', 
	'rhs_key' => 'billing_account_id',
	'relationship_type'=>'one-to-many',
);
?>
<?php
// created: 2010-12-20 02:56:01
$dictionary["Account"]["fields"]["aos_contracts"] = array (
  'name' => 'aos_contracts',
    'type' => 'link',
    'relationship' => 'account_aos_contracts',
    'module'=>'AOS_Contracts',
    'bean_name'=>'AOS_Contracts',
    'source'=>'non-db',
);
?>
<?php
// created: 2010-12-20 02:56:01
$dictionary["Account"]["relationships"]["account_aos_contracts"] = array (
	'lhs_module'=> 'Accounts', 
	'lhs_table'=> 'accounts', 
	'lhs_key' => 'id',
	'rhs_module'=> 'AOS_Contracts', 
	'rhs_table'=> 'aos_contracts', 
	'rhs_key' => 'contract_account_id',
	'relationship_type'=>'one-to-many',
);
?>
