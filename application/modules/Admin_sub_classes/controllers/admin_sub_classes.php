<?php
/* THIS CLASS WAS WRITTEN BY AKPU FRANKLIN CHIMAOBI*/
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH ."libraries/Page_Settings.php";


class admin_sub_classes extends MX_Controller
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
      $data = $this->fetch_sub_classes();
       $data["classes"] = $this->admin_classes->fetch_classes_for_sub_classes();
    if($this->authadmin->checkSessionOrCookie()==TRUE){
      $data_send = Page_Settings::set_page('adminsubclasses_view', $data, '' , 'Welcome Once Again', 'Admin_sub_classes');
      $this->templates->backend($data_send); 
    }else if($this->authadmin->checkSessionOrCookie()==FALSE){
      redirect(base_url()."administrator/login");      
      }
    
  }

  public function add_sub_classes()
  {
      $class = $this->input->post("class");
      $sub_class = $this->input->post("sub_class");
    $class = $this->authadmin->sanitize_string($class);
    $sub_class = $this->authadmin->sanitize_string($sub_class);
    if($class==""){
        echo "you have not selected a class";
    }else if($class=="Select A Class"){
        echo "please select a class";
    }else if($sub_class==""){
        echo"sub class cannot be left empty";
    }else{
        $count_if_exist = $this->admin_sub_classes_mdl->check_same_class_and_sub($class,$sub_class);
        if($count_if_exist==0){
            $sub_class_data = $this->map_sub_class($class,$sub_class);
            $this->admin_sub_classes_mdl->add_sub_class($sub_class_data);
            echo "new sub class added successfully";
        }else{
            echo "this sub class with the same class name already exist";
        }
        
    }
  }


  /*
     * PAGINATING Classes CONTENT FOR THE INDEX Class PAGE
     * ========================================================================
     */

    public function fetch_sub_classes()
    {
      $config = array();
      $config["base_url"] = base_url() . "Home/SubClasses/";
      $config['total_rows'] = $this->admin_sub_classes_mdl->count_sub_classes();
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
      $data['results'] = $this->admin_sub_classes_mdl->fetch_sub_classes($config["per_page"], $offset);
      $data["links"] = $this->pagination->create_links();
       return $data;  

    }

 
  /*
     * DELETE A SUB CLASS USING ITS ID 
     * ========================================================================
     */
    public function delete_sub_classes()
    {
     $id =  $this->input->get("id");
     if($id==""){
      echo "there seems to be a problem";    
     }else{
      $id = $this->security->xss_clean($id);
      $id = htmlspecialchars($id);
      $this->admin_sub_classes_mdl->delete_sub_classes($id);
     echo "content was successfully deleted";
    
     }
    
    }

      /*
     * SEARCH FOR A CLASS 
     * ========================================================================
     */

    public function search_sub_class()
    {
      
     $search_content = $this->input->get("search");
     if($search_content==""){
       
     }else{
       $search_content = $this->security->xss_clean($search_content);
       $search_content = htmlspecialchars($search_content);
     $data["results"] = $this->admin_sub_classes_mdl->search_sub_class($search_content);
      print json_encode($data);
     }

    }

  public function map_sub_class($class, $sub_class)
  {

    $data = array(
        "class_name"=>$class,
        "sub_class_name"=>$sub_class
    );
    return $data;
  }

  
 //end of this class 
}