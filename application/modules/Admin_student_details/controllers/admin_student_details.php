<?php
/* THIS CLASS WAS WRITTEN BY AKPU FRANKLIN CHIMAOBI*/
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH ."libraries/Page_Settings.php";


class admin_student_details extends MX_Controller
{

/**
 * the constructor containing:
 * all modules used in this class
 * all libraries used in this class
 * all models used in this class
 */
   public function __construct()
   {
    parent::__construct();
    $this->load->module(['Admin_classes','templates','Authadmin','Admin_sub_classes','Admin_student_details']);
    $this->load->helper(["url","cookie","security"]);  
    $this->load->library(['session','pagination']);
    $this->load->model("AuthAdmin/AuthAdmin_mdl");
    $this->load->model("admin_classes/admin_classes_mdl");
    $this->load->model("admin_sub_classes/admin_sub_classes_mdl");
    $this->load->model("admin_student_details/admin_student_details_mdl");
    $this->load->library('upload');
   }

/**
 * the index page for this loads the view Home/New-Students where registration is done
 * takes a paramter which is the classes to be fetched for sub classes which will be fetched dynamically using ajax
 */
  public function index()
  {
    $data["classes"] = $this->admin_classes->fetch_classes_for_sub_classes();
    if($this->authadmin->checkSessionOrCookie()==TRUE){
        $data_send = Page_Settings::set_page('adminstudentregistration_view', $data, '' , 'Welcome Once Again', 'Admin_student_details');
        $this->templates->backend($data_send); 
      }else if($this->authadmin->checkSessionOrCookie()==FALSE){
        redirect(base_url()."administrator/login");      
        }
  }
  /**
   * this is an ajax requet that fetches sub class based on the class content it gets and
   * returns it in json format
   */

   public function load_sub_class()
   {
     $class = $this->input->get("content");
    $return_json_data = $this->admin_sub_classes_mdl->fetch_sub_class_json($class);
   print json_encode($return_json_data);  
   }

  /**
   * this function adds a new student to the database 
   */

   public function add_students()
   {
    @$file_name = $_FILES["image"]["name"];
    @$tempoary_name = $_FILES["image"]["tmp_name"];
    @$file_size = $_FILES["image"]["size"];
    @$mime_type  = array("image/jpeg","image/png", "image/jpg");
    $username = $this->input->post("username");
    $password = $this->input->post("password");
    $date_of_birth = $this->input->post("date_of_birth");
    $sex = $this->input->post("sex");
    $class = $this->input->post("class");
    $sub_class = $this->input->post("sub_class");
    $username = $this->authadmin->sanitize_string($username);
    $password = trim($password);
    $sex = $this->authadmin->sanitize_string($sex);
    $class = $this->authadmin->sanitize_string($class);
    $sub_class = $this->authadmin->sanitize_string($sub_class);
    $custom_image = "default-avatar.png";
    if($username==""){
      echo "username cannot be left empty";
    }else if($class==""){
      echo "classes cannot be  left empty";
    }else if($sub_class==""){
      echo "sub class section cannot be left empty";
    }else if($password==""){
      echo "password cannot be left empty";
    }else if($sex==""){
      echo "please choose a sex";
    }else if($sex=="SEX"){
      echo "please choose a sex";
    }else if($class=="Select A Class"){
     echo "please select a class";
    }else if($sub_class=="Sub Class Name"){
      echo "sub class name cannot be left empty";
    }
    else if($date_of_birth==""){
      echo "please select a date of birth";
    }else if(!$this->isDate($date_of_birth)){
      echo "incorrect date of birth entered the format is DD/MM/YYYY";
    } else if($file_name==""){
      echo "file cannot be left empty";
    }else if($file_size > 2097152){
      echo "<b><i class='fa fa-warning'></i>&nbsp;oops! file is too large please ensure is not more than 2mb</b>";
  }    
    else{
      $temp = explode(".", $file_name);
      $newfilename = round(microtime(true)) . '.' . end($temp);  
      $mapped_data = $this->students_mapped_array($username, $class, $sub_class, $password, 
      $sex , $date_of_birth,$newfilename);
      move_uploaded_file($tempoary_name, "assets/student_image/$newfilename");
      $this->admin_student_details_mdl->add_students($mapped_data);
      echo "new student details added successfully  view new student added <a href='".base_url()."Home/View-Students'>here</a>";
    }

   }

   /**
    * this function maps data needed by the add_students ajax function to add a new student
    */
   public function students_mapped_array($username, $class, $sub_class, $password, 
   $sex , $date_of_birth, $custom_image)
   {  
     $graduate = "No";
     $time_added = time();
     $password = $this->authadmin->hash_password($password);
    $data = array(
       "username"=>$username,
       "class_name"=>$class,
       "sub_class_name"=>$sub_class,
       "password"=>$password,
       "sex"=>$sex,
       "date_of_birth"=>$date_of_birth,
       "file_name"=>$custom_image,
       "time_added"=>$time_added,
       "graduate"=>$graduate,
    );
    return $data;
   }
   

   /**
    * this renders the Home/Class-Upgrade view
    *this view takes two data array of objects:
    *first it fetches all available classes 
    * and the second which is optional depending on search results is the students details
    */

   public function upgrade_class()
   {

    $data["classes"] = $this->admin_classes->fetch_classes_for_sub_classes();
    $data["results"] = array();
    $data["links"]="";
    if($this->authadmin->checkSessionOrCookie()==TRUE){
      $select_class = ''; // default when no term in session or POST
if ($this->input->post('select_class'))
{ 
    // use the term from POST and set it to session
    $select_class = $this->input->post('select_class');
    $select_class = $this->authadmin->sanitize_string($select_class);
    $this->session->set_userdata('search_term', $select_class);
}
elseif ($this->session->userdata('search_term'))
{
    // if term is not in POST use existing term from sessio
    $select_class= $this->session->userdata('search_term');
}
      $select_class = $this->authadmin->sanitize_string($select_class);
      if($select_class==""){
        $data_send = Page_Settings::set_page('upgradeclass_view', $data, '' , 'Welcome Once Again', 'Admin_student_details');
        $this->templates->backend($data_send);    
      }else{
        $config = array();
        $config["base_url"] = base_url() . "Home/Class-Upgrade/";
        $config['total_rows'] = $this->admin_student_details_mdl->count_number_of_students_requested($select_class);
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
        @$data['results'] = $this->admin_student_details_mdl->fetch_number_of_students_requested($config["per_page"], $offset,$select_class);
        @$data["links"] = $this->pagination->create_links();
        $data_send = Page_Settings::set_page('upgradeclass_view', $data, '' , 'Welcome Once Again', 'Admin_student_details');
        $this->templates->backend($data_send);    
      }

    }else if($this->authadmin->checkSessionOrCookie()==FALSE){
      redirect(base_url()."administrator/login");      
      }
   }
  


   public function search_specific_student_name()
   {
     $search_name = $this->input->get("search_name");
     $search_name = $this->security->xss_clean($this->authadmin->sanitize_string($search_name));
     if($search_name==""){

     }else{
       $search_name_response = $this->admin_student_details_mdl->search_for_student_to_upgrade_by_name($search_name);
       print json_encode($search_name_response);
     }
   }

    /**
     * this function upgrades student class or set of student class
     */
  public function upgrade_student_class()
  {
    //$session_value = $_SESSION["search_term"];
   $id = $this->input->post("id");
    $select_search = $this->input->post("select_search");
    $id = $this->authadmin->sanitize_string($id);
    $select_search = $this->authadmin->sanitize_string($select_search);
    if($id==""){
      echo "there seems to be problem";
    }else if($select_search==""){
      echo "class to upgrade to seems to be empty";
    }else{
      $this->admin_student_details_mdl->ugrade_student_class($id,$select_search);
      echo "student update succesfully";
    }
  }


  /**
   * this function upgrades all students from one class to another class
   * takes two get values from ajax function admin.js:
   * @the class to upgrade to
   * @the class to upgrade from
   */
   public function upgrade_all_students_class()
   {
    $upgrade_from = $this->input->get("upgrade_from");
    $upgrade_to = $this->input->get("upgrade_to");
    $upgrade_from = $this->security->xss_clean($this->authadmin->sanitize_string($upgrade_from));
    $upgrade_to = $this->security->xss_clean($this->authadmin->sanitize_string($upgrade_to));
    if($upgrade_from==""){
      echo "could not upgrade successfully there seems to be a problem";
    }else if($upgrade_to==""){
      echo "please select a class to upgrade to";
    }else{
     $upgrade_from_and_to_exist_in_db = $this->admin_student_details_mdl->check_if_student_class_exist($upgrade_from,$upgrade_to);
     if($upgrade_from_and_to_exist_in_db==TRUE)
     {
          $this->admin_student_details_mdl->upgrade_all_students_class_in_upgrade_from($upgrade_to,$upgrade_from);
          echo "all students in $upgrade_from have been successfully upgraded to $upgrade_to";
    }
         else{
        echo "either the class you want to upgrade to or the class you want to upgrade from no longer exist in the database";
      }
    }
   }
   /**
    * this renders the Home/View-Students with a paginated data of the students
    */
  public function  view_students()
  {
    $data = $this->fetch_paginated_students();
    if($this->authadmin->checkSessionOrCookie()==TRUE){
      $data_send = Page_Settings::set_page('adminstudentdetails_view', $data, '' , 'Welcome Once Again', 'Admin_student_details');
      $this->templates->backend($data_send); 
    }else if($this->authadmin->checkSessionOrCookie()==FALSE){
      redirect(base_url()."administrator/login");      
      }
  }
  
  /**
   * this returns the data of the students in a paginated format
   */
  public function fetch_paginated_students()
  {
    $config = array();
      $config["base_url"] = base_url() . "Home/View-Students/";
      $config['total_rows'] = $this->admin_student_details_mdl->count_students();
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
      $data['results'] = $this->admin_student_details_mdl->fetch_students($config["per_page"], $offset);
      $data["links"] = $this->pagination->create_links();
       return $data;  
  }

  /**
   * an ajax function that returns students based on search entered in the input text 
   * it returns the data in json format 
   */
  public function search_students()
  {
    $limit = 5;
    $search_content = $this->input->get("search");
     if($search_content==""){
       
     }else{
       $search_content = $this->security->xss_clean($search_content);
       $search_content = htmlspecialchars($search_content);
     $data["results"] = $this->admin_student_details_mdl->search_student_detail_content($search_content,$limit);
      print json_encode($data);
     }
  }
/**
 * ajax pagination for students searched for with a limit of 5 students perpage
 */
  public function load_more_student_search()
  {
   
    $limit = 5;
    $search_content = $this->input->get("search");
    $id = $this->input->get("id");
     if($search_content==""){
       
     }else if($id==""){

     }
     else{
       $search_content = $this->security->xss_clean($search_content);
       $search_content = htmlspecialchars($search_content);
       $id = $this->security->xss_clean($id);
       $id = htmlspecialchars($id);
     $data["results"] = $this->admin_student_details_mdl->load_more_search_student_detail($search_content,$id,$limit);
      print json_encode($data);
     }
  }

  /**
   * fetch student based on the id as a paramter 
   */
  public function fetch_student_by_id($id){
   $data =  $this->admin_student_details_mdl->fetch_student_by_id($id);
   return $data;
  }

  /**
   * renders the Home/Full-Profile/$1 view containing a result of the student information
   */
  public function students_profile($param)
  {
     $data["results"] = $this->fetch_student_by_id($param);
    if($this->authadmin->checkSessionOrCookie()==TRUE){
      $data_send = Page_Settings::set_page('adminstudentprofile_view', $data, '' , 'Welcome Once Again', 'Admin_student_details');
      $this->templates->backend($data_send); 
    }else if($this->authadmin->checkSessionOrCookie()==FALSE){
      redirect(base_url()."administrator/login");      
      }
  }


/**
 *this is an ajax function that delete a sub class category based on the get variable which is the id
 */
    public function delete_student()
    {
     $id =  $this->input->get("id");
     if($id==""){
      echo "there seems to be a problem";    
     }else{
      $id = $this->security->xss_clean($id);
      $id = htmlspecialchars($id);
      $this->admin_student_details_mdl->delete_student($id);
     echo "content was successfully deleted";
    
     }
    }

   /**
    * this render the Home/Update-Student/$1 here the student details are being updated 
    */
    public function update_students($param)
    {
      $data["student"] = $this->fetch_student_by_id($param);
      $data["classes"] = $this->admin_classes->fetch_classes_for_sub_classes();
      if($this->authadmin->checkSessionOrCookie()==TRUE){
        $data_send = Page_Settings::set_page('adminstudentupdate_view', $data, '' , 'Welcome Once Again', 'Admin_student_details');
        $this->templates->backend($data_send); 
      }else if($this->authadmin->checkSessionOrCookie()==FALSE){
        redirect(base_url()."administrator/login");    
    }
  }

/**
 * this is an ajax function that updates the students details 
 */
   public function update_students_details()
   {
    $username = $this->input->post("username");
    $graduate = $this->input->post("graduate");
    $class = $this->input->post("class");
    $sub_class = $this->input->post("sub_class");
    $id = $this->input->post("id");
    $username = $this->authadmin->sanitize_string($username);
    $graduate = $this->authadmin->sanitize_string($graduate);
    $class = $this->authadmin->sanitize_string($class);
    $sub_class = $this->authadmin->sanitize_string($sub_class);
    $id =  htmlspecialchars($id);
    if($username==""){
      echo "username cannot be left empty";
    }else if($class==""){
      echo "classes cannot be  left empty";
    }else if($sub_class==""){
      echo "sub class section cannot be left empty";
    }else if($graduate==""){
      echo "graduate section cannot be left empty";
    }else if($graduate=="Graduate"){
      echo "graduate section cannot be left empty";
    }else if($class=="Select A Class"){
     echo "please select a class";
    }else if($sub_class=="Sub Class Name"){
      echo "sub class name cannot be left empty";
    }else{
      $mapped_data = $this->students_mapped_update_array($username, $class, $sub_class, 
      $graduate);
      $this->admin_student_details_mdl->update_students($id,$mapped_data);
      echo "student detail updated successfully  view student profile <a href='".base_url()."Home/Full-Profile/$id'>here</a>";
    }
 
   }

  
/**
 * here the students details needed to be updated will be mapped the paramters are
 * @username:which is the students username
 * @class:which is the student class
 * @subclass:which is the sub class which is under the class category
 * @graduate:an update whether the student has graduated or not
 */
public function  students_mapped_update_array($username, $class, $sub_class, 
$graduate)
{
    $data = array(
       "username"=>$username,
       "class_name"=>$class,
       "sub_class_name"=>$sub_class,
       "graduate"=>$graduate,
    );
    return $data;
      

}

 /**
  * this function checks if the date entered in a text input is correct
  *@string:this is the data entered inside the text input
  */
   public function isDate($string) {
    $matches = array();
    $pattern = '/^([0-9]{1,2})\\/([0-9]{1,2})\\/([0-9]{4})$/';
    if (!preg_match($pattern, $string, $matches)) return false;
    if (!checkdate($matches[2], $matches[1], $matches[3])) return false;
    return true;
      }





      public function do_upload($file_name)
{
  $config['upload_path']          = './assets/student_image/';
  $config['allowed_types']        = 'gif|jpg|png';
  $config['max_size']             = 100;
  $config['max_width']            = 1024;
  $config['max_height']           = 768;
  $this->load->library('upload', $config);
  $this->upload->do_upload($file_name);
}
//end of this class
}