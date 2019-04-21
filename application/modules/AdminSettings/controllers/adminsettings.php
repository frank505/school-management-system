<?php
/* THIS CLASS WAS WRITTEN BY AKPU FRANKLIN CHIMAOBI*/
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH ."libraries/Page_Settings.php";

class adminsettings extends MX_controller
{
 

public function __construct()
{
    parent::__construct();
    $this->load->module(['Adminsettings','templates','Authadmin']);
    $this->load->helper(["url","cookie","security"]);  
    $this->load->library('session');
    $this->load->model("AuthAdmin/AuthAdmin_mdl");
}

/*
     * THIS LOADS THE ADMIN SETTINGS VIEW
     * ========================================================================
     */

public function index()
{
    $user_detail = array();
    $user_detail["details"] = $this->return_user_detail();
    if($this->authadmin->CheckSessionOrCookie()==TRUE){
        $data_send = Page_Settings::set_page('adminsettings_view', $user_detail, '' , 'Welcome Once Again', 'Adminsettings');
        $this->templates->backend($data_send); 
    }else if($this->authadmin->CheckSessionOrCookie()==FALSE){
        redirect(base_url()."administrator/login");      
        }else{
            redirect(base_url()."administrator/login");      
        }
}





/*
     * THIS RETURNS THE HASHED EMAIL
     * ==============================================================================
     */

    public function get_email()
    {
     $email = $_SESSION["email"];
     return $email;
    }
     /*
     * THIS RETURNS THE USER DETAILS TO BE UPDATED IN THE SETTINGS PAGE
     * ==============================================================================
     */
    public function return_user_detail()
    {
      $email = $this->get_email();
     $user_check_hash =  $this->AuthAdmin_mdl->select_result_session($email);
     $fetch_content = $this->AuthAdmin_mdl->fetch_content_session($user_check_hash);
     return $fetch_content;
    }

   /*
     * AJAX FUNCTIONS
     * ==============================================================================
     */


 /*
     * SENDS AN AJAX REQUEST TO ADD A NEW ADMIN
     * ==============================================================================
     */
    public function add_new_admin()
    {
     $username = $this->input->post("username");
     $email = $this->input->post("email");
     $password = $this->input->post("password");
     $confirm = $this->input->post("confirm");
     $username = $this->authadmin->sanitize_string($username);
     $email = $this->authadmin->validate_email($email);
     $password = trim($password);
     $confirm = trim($confirm);
     if($username==""){
      echo"<b><i class='fa fa-warning' aria-hidden='true'></i>&nbsp;username cannot be left empty</b>";
     }else if($email ==""){
        echo"<b><i class='fa fa-warning' aria-hidden='true'></i>&nbsp;email cannot be left empty</b>";
     }else if($password==""){
      echo"<b><i class='fa fa-warning' aria-hidden='true'></i>&nbsp;password cannot be left empty</b>";
     }else if($confirm ==""){
       echo"<b><i class='fa fa-warning' aria-hidden='true'></i>&nbsp;confirm cannot be left empty</b>";
     }else if($password !=$confirm){
      echo"<b><i class='fa fa-warning' aria-hidden='true'></i>&nbsp;password and confirm password dont match</b>";
     }
     else if(!$email){
      echo"<b><i class='fa fa-warning' aria-hidden='true'></i>&nbsp;email seems to be incorrect</b>";} 
     else{
      $email_checker = $this->AuthAdmin_mdl->check_email($email);
      if($email_checker > 0 ){
       echo"<b><i class='fa fa-warning' aria-hidden='true'></i>&nbsp;this user already exist</b>";    
      }else{
        $data = $this->authadmin->admin_add_array($username,$email,$password,$confirm);
       $items = $this->AuthAdmin_mdl->add_new_admin($data);
      echo "<b><i class='fa fa-warning' aria-hidden='true'></i>&nbsp;registration complete</b>";
      }
     }
   
    }

     /*
     * SENDS AN AJAX REQUEST TO ADD A UPDATE ADMIN
     * ==============================================================================
     */

  
    public function update_admin_profile()
    {
      $username = $this->input->post("username");
     $password = $this->input->post("password");
     $confirm = $this->input->post("confirm");
     $username = $this->authadmin->sanitize_string($username);
     $password = trim($password);
     $confirm = trim($confirm);
      if($username==""){
        echo"<b><i class='fa fa-warning' aria-hidden='true'></i>&nbsp;username cannot be left empty</b>";
       }else if($password==""){
        echo"<b><i class='fa fa-warning' aria-hidden='true'></i>&nbsp;password cannot be left empty</b>";
       }else if($confirm ==""){
         echo"<b><i class='fa fa-warning' aria-hidden='true'></i>&nbsp;confirm cannot be left empty</b>";
       }else if($password !=$confirm){
        echo"<b><i class='fa fa-warning' aria-hidden='true'></i>&nbsp;password and confirm password dont match</b>";
       }else{
       $hashed_email = $this->get_email();
       $user_check_hash =  $this->AuthAdmin_mdl->select_result_session($hashed_email);
       if($user_check_hash==""){
        echo"<b><i class='fa fa-warning' aria-hidden='true'></i>&nbsp;user seems not to exist</b>";
       }else{
        $data = $this->authadmin->admin_update_array($username,$password,$confirm);
        $update = $this->AuthAdmin_mdl->update_admin_profile($user_check_hash,$data);
      echo"<b>&nbsp;profile sucessfully updated</b>";
       }
       
       }
    
    }
  


/**
     * help:: sample use of template file
     *
     * @return void
     */
  
  
}