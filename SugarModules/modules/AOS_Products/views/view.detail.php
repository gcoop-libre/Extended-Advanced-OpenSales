<?php 
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 
 
require_once('include/MVC/View/views/view.detail.php');

class AOS_ProductsViewDetail extends ViewDetail { 
 
  function AOS_ProductsViewDetail(){ 
    parent::ViewDetail(); 
  } 

    function preDisplay()
    {
        $metadataFile = "modules/$this->module/metadata/detailviewdefs.php";
        $this->dv = new DetailView2();
        $this->showTitle = true;
        $this->dv->ss =&  $this->ss;
        $this->dv->setup($this->module, $this->bean, $metadataFile, 'modules/AOS_Products/views/DetailView.tpl');
    }

  function display() {

    global $current_user;
    $stock_values = $this->dv->focus->GetStockValues();
    $this->dv->showVCRControl = false;
    $this->ss->assign('CHART_VALUES', json_encode($stock_values));

    $order_point_values = $this->dv->focus->GetOrderPointValues();
    $this->ss->assign('CHART_VALUES_OP', json_encode($order_point_values));
    
    $date_format_pref = $current_user->getUserDateTimePreferences();
    $pattern = '/(\w+)/';
    $replacement = '%${1}$3';
    $date_format_pref = preg_replace($pattern, $replacement, $date_format_pref['date']);
    $this->ss->assign('DATE_FORMAT_PREF', $date_format_pref);

    parent::display();
  }
 
} 
?> 

        


