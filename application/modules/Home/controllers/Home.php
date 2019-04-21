<?php
/* THIS CLASS WAS WRITTEN BY AKPU FRANKLIN CHIMAOBI*/
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH ."libraries/Page_Settings.php";

class home extends MX_controller
{
 

public function __construct()
{
    parent::__construct();
    $this->load->module(['Home','templates','Authadmin']);
    $this->load->helper(["url","cookie","security"]);  
    $this->load->library('session');
}

/*
     * THIS LOADS THE HOME PARENT VIEW
     * ========================================================================
     */

public function index()
{
    if($this->authadmin->CheckSessionOrCookie()==TRUE){
        $data_send = Page_Settings::set_page('dashboard_view', NULL, '', 'Welcome Once Again', 'Home');
        $this->templates->backend($data_send); 
    }else if($this->authadmin->CheckSessionOrCookie()==FALSE){
        redirect(base_url()."administrator/login");      
        }else{
            redirect(base_url()."administrator/login");      
        }

}

public function error_view()
{
    $this->load->view("error_view");
}



/**
     * help:: sample use of template file
     *
     * @return void
     */
  
  
}