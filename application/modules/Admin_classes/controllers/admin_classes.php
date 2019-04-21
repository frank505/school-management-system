<?php
/* THIS CLASS WAS WRITTEN BY AKPU FRANKLIN CHIMAOBI*/
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH ."libraries/Page_Settings.php";


class admin_classes extends MX_Controller
{


   public function __construct()
   {
    parent::__construct();
    $this->load->module(['Admin_classes','templates','Authadmin','Admin_sub_classes']);
    $this->load->helper(["url","cookie","security"]);  
    $this->load->library(['session','pagination']);
    $this->load->model("AuthAdmin/AuthAdmin_mdl");
    $this->load->model("admin_classes/admin_classes_mdl");
    $this->load->model("admin_sub_classes/admin_sub_classes_mdl");
   }

    
  public function index()
  {      
       $data = $this->fetch_classes();
    if($this->authadmin->checkSessionOrCookie()==TRUE){
      $data_send = Page_Settings::set_page('adminclasses_view', $data, '' , 'Welcome Once Again', 'Admin_classes');
      $this->templates->backend($data_send); 
    }else if($this->authadmin->checkSessionOrCookie()==FALSE){
      redirect(base_url()."administrator/login");      
      }
    
  }
  

  /*
     * PAGINATING Classes CONTENT FOR THE INDEX Class PAGE
     * ========================================================================
     */

    public function fetch_classes()
    {
      $config = array();
      $config["base_url"] = base_url() . "Home/Classes/";
      $config['total_rows'] = $this->admin_classes_mdl->count_classes();
      $config['per_page'] = 5;
      $config['use_page_numbers'] = TRUE;     
      $config['uri_segment'] = 3; 
     $this->pagination->initialize($config);   
      if($this->uri->segment(3) > 0){
        $offset = ($this->uri->segment(3) + 0)*$config['per_page'] - $config['per_page'];
      }
      else{
        $offset = $this->uri->segment(3);
      }
      $data['results'] = $this->admin_classes_mdl->fetch_classes($config["per_page"], $offset);
      $data["links"] = $this->pagination->create_links();
       return $data;  

    }


  /*
     * THIS FUNCTION IS SPECIFICALLY FOR THE SUB Classes SECTION TO MALE CLASSES
     *  AVAILABLE TO MAKE IT EASY TO CREATE A SUB CLASS
     * =========================================================================================================================
     */


     public function fetch_classes_for_sub_classes()
   {
   $classes = $this->admin_classes_mdl->fetch_classes_for_sub_classes();
   return $classes;
   }
/*
     * THIS FUNCTION IS SPECIFICALLY FOR THE MERGING SECTION TO MAKE CLASSES
     *  AVAILABLE TO MAKE IT EASY TO CREATE A NEW MERGE OF COURSE AND CLASS
     * =========================================================================================================================
     */
   public function fetch_classes_for_merging()
   {
    $classes = $this->admin_classes_mdl->fetch_classes_for_sub_classes();
    return $classes;
   }
    /*
     * AJAX FUNCTIONS
     * ========================================================================
     */

      /*
     * ADD A NEW CLASS 
     * ========================================================================
     */

  public function add()
  {
    $classes = $this->input->post("class");
    if($classes==""){
      echo "please class section is empty";
    }else{
        $classes = $data = $this->security->xss_clean($classes);
        $classes = $this->authadmin->sanitize_string($classes);
        $total = $this->admin_classes_mdl->check_classes($classes);
        if($total==0){
          $data = array(
            'class_name' => $classes,
           );
           $this->admin_classes_mdl->add_classes($data);
          echo "new class successfully added"; 
        }else{
          echo "this class already exist";
        }
       }
    
  }

 /*
     * DELETE A CLASS USING ITS ID 
     * ========================================================================
     */
  public function delete_classes()
  {
   $id =  $this->input->get("id");
   if($id==""){
    echo "there seems to be a problem";    
   }else{
    $id = $this->security->xss_clean($id);
    $id = htmlspecialchars($id);
    $class_from_id = $this->admin_classes_mdl->class_from_id($id);
    $deleted_class = $this->admin_classes_mdl->delete_classes($id);
    if($deleted_class){
      $this->admin_sub_classes_mdl->delete_deleted_class($class_from_id);
      echo "content was successfully deleted";
    }else{
      echo"there seeems to be a problem";
    }
      
  
   }
  
  }


     /*
     * SEARCH FOR A CLASS 
     * ========================================================================
     */

    public function search_class()
    {
      
     $search_content = $this->input->get("search");
     if($search_content==""){
       
     }else{
       $search_content = $this->security->xss_clean($search_content);
       $search_content = htmlspecialchars($search_content);
     $data["results"] = $this->admin_classes_mdl->search_class($search_content);
      print json_encode($data);
     }

    }
 




}