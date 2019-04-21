<?php
/* THIS CLASS WAS WRITTEN BY AKPU FRANKLIN CHIMAOBI*/
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH ."libraries/Page_Settings.php";


class admin_student_courses extends MX_Controller
{


   public function __construct()
   {
    parent::__construct();
    $this->load->module(['Admin_classes','templates','Authadmin']);
    $this->load->helper(["url","cookie","security"]);  
    $this->load->library(['session','pagination']);
    $this->load->model("AuthAdmin/AuthAdmin_mdl");
    $this->load->model("admin_classes/admin_classes_mdl");
    $this->load->model("Admin_student_courses/admin_student_courses_mdl");
   }

    
  public function index()
  {      

    $data = $this->fetch_courses();
    $data["fetch_classes_for_merge"] = $this->admin_classes->fetch_classes_for_merging();
    if($this->authadmin->checkSessionOrCookie()==TRUE){
      $data_send = Page_Settings::set_page('adminstudentcourses_view', $data, '' , 'Welcome Once Again', 'Admin_student_courses');
      $this->templates->backend($data_send); 
    }else if($this->authadmin->checkSessionOrCookie()==FALSE){
      redirect(base_url()."administrator/login");      
      }  
  }
    
  public function manage_merged_courses()
  {
   // $data["fetch_all_courses"] = $this->admin_student_courses_mdl->fetch_all_courses();
    $data["fetch_all_sessions"] =  $this->admin_student_courses_mdl->fetch_all_sessions();
    $data["fetch_classes_for_merge"] = $this->admin_classes->fetch_classes_for_merging();
    if($this->authadmin->checkSessionOrCookie()==TRUE){
      $data_send = Page_Settings::set_page('adminmergestudent_view', $data, '' , 'Welcome Once Again', 'Admin_student_courses');
      $this->templates->backend($data_send); 
    }else if($this->authadmin->checkSessionOrCookie()==FALSE){
      redirect(base_url()."administrator/login");      
      }
  }

   /**
    * this returns data which contains two array index values:
    *@$data['results']:returns the content or data requested per page
    * $data["links"]:this creates the pagination links
    */

    public function fetch_courses()
    {
      $config = array();
      $config["base_url"] = base_url() . "Home/Student-Courses/";
      $config['total_rows'] = $this->admin_student_courses_mdl->count_courses();
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
      $data['results'] = $this->admin_student_courses_mdl->fetch_courses($config["per_page"], $offset);
      $data["links"] = $this->pagination->create_links();
       return $data;  

    }

    public function search_for_merged_courses()
    {
      $class_name = $this->input->get("class_name");
      $class_name = $this->security->xss_clean(htmlspecialchars($class_name));
      if($class_name==""){
        echo "please select a class";
      }else{
        $search_merged_table = $this->admin_student_courses_mdl->search_for_merged_courses($class_name);
        print json_encode($search_merged_table);
      }
      
    }


    public function delete_specific_merged_courses()
    {
      $get_id = $this->authadmin->sanitize_string($this->input->post("id"));
      if($get_id==""){
        echo "there seems to be a problem please refresh your browser";
      }else if(!is_numeric($get_id)){
         echo "there seems to be a problem please refresh your browser";
      }else{
        $course_name_and_class_name_array = $this->admin_student_courses_mdl->fetch_course_name_from_merged($get_id);
     $this->admin_student_courses_mdl->delete_course_children_topic_from_topic_table($course_name_and_class_name_array);
      $this->admin_student_courses_mdl->delete_specific_merged_courses($get_id);
        echo "merged courses were succesfully";
      }
      
      }
      
      public function delete_merged_courses()
      {
        $get_class_name = $this->input->get("class_name");
        $get_class_name = $this->security->xss_clean($this->authadmin->sanitize_string($get_class_name));
        if($get_class_name==""){
          echo "there seems to be a problem please refresh your browser";
        }else{
          $if_exist = $this->admin_student_courses_mdl->check_class_name_if_exist_in_merge_table($get_class_name);
          if($if_exist==FALSE){
            echo "there seems to be a problem please refresh your browser";
          }else{
            $this->admin_student_courses_mdl->delete_class_children_topic_from_topic_table($get_class_name); 
            $this->admin_student_courses_mdl->delete_merged_courses($get_class_name);
          echo "merged courses were succesfully";
          }
          
        } 
      }

/**
 * this is an ajax function that adds new courses 
 */
  public function add_course()
  {
    $course_name = $this->input->post("course_name");
    if($course_name==""){
      echo "please course/subject section is empty";
    }else{
        $courses = $data = $this->security->xss_clean($course_name);
        $courses = $this->authadmin->sanitize_string($course_name);
        $total = $this->admin_student_courses_mdl->check_course($course_name);
        if($total==0){
          $data = array(
            'course_name' => $course_name,
           );
           $this->admin_student_courses_mdl->add_course($data);
          echo "new course/subject successfully added"; 
        }else{
          echo "this course/subject already exist";
        }
       }
  }
  
   /**
    * Delete A course including the data existing in the merge_course table that contains course data
    */
  public function delete_course()
  {
   $id =  $this->input->get("id");
   if($id==""){
    echo "there seems to be a problem";    
   }else{
    $id = $this->security->xss_clean($id);
    $id = htmlspecialchars($id);
    $course_from_id = $this->admin_student_courses_mdl->course_from_id($id);
    $deleted_class = $this->admin_student_courses_mdl->delete_course($id);
    if($deleted_class){
      $this->admin_student_courses_mdl->delete_course_everywhere($course_from_id);
      echo "content was successfully deleted";
    }else{
      echo"there seeems to be a problem";
    } 
  
   }
  }

     /**
      * this is an ajax function that searches for a course based on the get request paramater 
      *called @$search_content
      */
    public function search_course()
    {
      
     $search_content = $this->input->get("search");
     if($search_content==""){
       
     }else{
      $search_content = $this->security->xss_clean($search_content);
      $search_content = htmlspecialchars($search_content);
     $data = $this->admin_student_courses_mdl->search_course($search_content);
     print json_encode($data);
     }

    }
 
    /**
     * this ajax function fetches a specific course name based on the id as a get paramter
     */
   public function fetch_course_name_for_merging()
   {
       $id = $this->input->get("id");
       $id = $this->security->xss_clean(htmlspecialchars($id));
       if($id==""){
           echo "course name was not gotten there seems to be a problem";
       }else{
        $get_course = $this->admin_student_courses_mdl->course_from_id($id);
        echo $get_course;
       }
   }


   /**
    * this ajax function adds a new merged course it:
    *@checks if course name exist in the courses table, if it doesnt exist throws error message or nothing happens
    *@next it checks if class exist in the class table if it doesnt exist throws error message or nothing happens
    *@finally it checks if a pair of the course about to be merged in the merged_course table already exist
    *if it does exist it throws an error message or nothing happens
    */
   public function add_new_merge()
   {
     $course_name = $this->input->post("course_name");
     $class_name = $this->input->post("class_name");
     $course_name = $this->security->xss_clean($this->authadmin->sanitize_string($course_name));
     $class_name = $this->security->xss_clean($this->authadmin->sanitize_string($class_name));
     if($course_name==""){
       echo "please be sure to select a course";
     }else if($class_name==""){
       echo "class name cannot be left empty";
     }else{
       $check_course_name = $this->admin_student_courses_mdl->check_course($course_name);
       if($check_course_name==0){
         echo "proccess was uncessful because this course doesnt exist in the database";
       }else{
         $check_class_name = $this->admin_classes_mdl->check_classes($class_name);
         if($check_class_name==0){
           echo "proccess was uncessful because this class doesnt exist in the database";
         }else{
           $check_if_pair_exist = $this->admin_student_courses_mdl->check_if_pair_exist($course_name, $class_name);
           if($check_if_pair_exist==TRUE){
             echo "this course and class have already been merged";
           }else{
            $this->admin_student_courses_mdl->merge_new_course($course_name, $class_name);
            echo "merge process was successfull";
           }
           
         }
       }
     }
   }
     

  public function add_topic()
  {
   $topic_name = $this->authadmin->sanitize_string($this->input->post("topic_name"));
   $course_name = $this->authadmin->sanitize_string($this->input->post("course_name"));
   $sessions_name = $this->authadmin->sanitize_string($this->input->post("sessions_name"));
   $class_name = $this->authadmin->sanitize_string($this->input->post("class_name"));
    $check_if_sess_exist = $this->admin_student_courses_mdl->check_sessions($sessions_name);
    $check_if_topic_exist = $this->admin_student_courses_mdl->check_if_new_topic_pair_exist_in_db($topic_name,$sessions_name,$course_name,$class_name);
   $check_class_course_name_merge = $this->admin_student_courses_mdl->check_class_course_merge($course_name, $class_name);
   if($check_if_sess_exist==0){
     echo "process was uncessful please select a session to add topic to no topic can be without falling under a certain session";
   }else if($topic_name==""){
     echo"process was uncessful please enter a new topic";
   }else if($check_class_course_name_merge < 1){
     echo "proccess was uncessful please refresh your browser and begin process all over again";
   } else if($check_if_topic_exist > 0){
   echo "this topic has already been added to this course under this class in the same session too, please add a new topic";
   }
   else{
     $map_new_topic = $this->map_new_topic($topic_name,$sessions_name,$course_name,$class_name);
     $insert = $this->admin_student_courses_mdl->add_topic($map_new_topic);
     echo "new topic successfully added";
   }

   }

    public function map_new_topic($topic_name,$sessions_name,$course_name,$class_name)
    {
      $data_array = array(
       "topic"=>$topic_name,
       "sessions_name"=>$sessions_name,
       "course_name"=>$course_name,
       "class_name"=>$class_name,
      );
      return $data_array;
    }

  public function manage_sessions()
  {
    $data = $this->fetch_sessions();
    if($this->authadmin->checkSessionOrCookie()==TRUE){
      $data_send = Page_Settings::set_page('adminsessions_view', $data, '' , 'Welcome Once Again', 'Admin_student_courses');
      $this->templates->backend($data_send); 
    }else if($this->authadmin->checkSessionOrCookie()==FALSE){
      redirect(base_url()."administrator/login");   
  }
  }

  public function fetch_sessions()
  {
    $config = array();
    $config["base_url"] = base_url() . "Home/Manage-Sessions/";
    $config['total_rows'] = $this->admin_student_courses_mdl->count_sessions();
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
    $data['results'] = $this->admin_student_courses_mdl->fetch_sessions($config["per_page"], $offset);
    $data["links"] = $this->pagination->create_links();
     return $data;  
  }
   
       /*
     * ADD A NEW sessions 
     * ========================================================================
     */

    public function add_sessions()
    {
      $sessions = $this->input->post("sessions");
      if($sessions==""){
        echo "please sessions section is empty";
      }else{
          $sessions = $data = $this->security->xss_clean($sessions);
          $sessions = $this->authadmin->sanitize_string($sessions);
          $total = $this->admin_student_courses_mdl->check_sessions($sessions);
          if($total==0){
            $data = array(
              'sessions_name' => $sessions,
             );
             $this->admin_student_courses_mdl->add_sessions($data);
            echo "new sessions successfully added"; 
          }else{
            echo "this sessions already exist";
          }
         }
      
    }
  
   /*
       * DELETE A sessions USING ITS ID 
       * ========================================================================
       */
    public function delete_sessions()
    {
     $id =  $this->input->get("id");
     if($id==""){
      echo "there seems to be a problem";    
     }else{
      $id = $this->security->xss_clean($id);
      $id = htmlspecialchars($id);
      $sessions_from_id = $this->admin_student_courses_mdl->sessions_from_id($id);
      $deleted_sessions = $this->admin_student_courses_mdl->delete_sessions($id);
      if($deleted_sessions){
        $this->admin_student_courses_mdl->delete_deleted_sessions($sessions_from_id);
        echo "content was successfully deleted";
      }else{
        echo"there seeems to be a problem";
      }
        
    
     }
    
    }

    
       /*
       * SEARCH FOR A sessions 
       * ========================================================================
       */
  
      public function search_sessions()
      {
        
       $search_content = $this->input->get("search");
       if($search_content==""){
         
       }else{
         $search_content = $this->security->xss_clean($search_content);
         $search_content = htmlspecialchars($search_content);
       $data["results"] = $this->admin_student_courses_mdl->search_sessions($search_content);
        print json_encode($data);
       }
  
      }

      public  function load_term_for_course()
      {
      $get_course_name = $this->security->xss_clean($this->authadmin->sanitize_string(htmlspecialchars($this->input->get("course_name"))));
      $get_class_name = $this->security->xss_clean($this->authadmin->sanitize_string(htmlspecialchars($this->input->get("class_name"))));
      if($get_course_name==""){
        $error = array("content_error"=>"there seems to be a problem with loading this scheme of work please refresh your browser");
        print json_encode($error);
      } else if($get_class_name==""){
        $error = array("content_error"=>"there seems to be a problem with loading this scheme of work please refresh your browser");
        print json_encode($error);
      }else{
       $fetch_sessions = $this->admin_student_courses_mdl->fetch_unique_session_for_class_and_course($get_class_name,$get_course_name);
       print json_encode($fetch_sessions);
      }
    
      }
   

      public function load_topics_per_term()
      {
      $get_course_name = $this->security->xss_clean($this->authadmin->sanitize_string(htmlspecialchars($this->input->get("course_name"))));
      $get_class_name = $this->security->xss_clean($this->authadmin->sanitize_string(htmlspecialchars($this->input->get("class_name"))));
      $get_session_name = $this->security->xss_clean($this->authadmin->sanitize_string(htmlspecialchars($this->input->get("session"))));
      if($get_course_name=="" || $get_class_name=="" ||  $get_session_name==""){
        $error = array("content"=>"there seems to be a problem please refresh your browser");
      }else{
        $fetch_data = $this->admin_student_courses_mdl->load_topics_per_term($get_course_name, $get_class_name,$get_session_name);
        print json_encode($fetch_data);
      }
     
      }

      public function delete_topic()
      {
        $delete_topic_id =  $this->security->xss_clean($this->authadmin->sanitize_string(htmlspecialchars($this->input->get("id"))));
        if($delete_topic_id==""){
          echo "there seems to be a problem please refresh your browser";
        } else{
          $this->admin_student_courses_mdl->delete_topic($delete_topic_id);
          echo "topic was successfully deleted";
        }
      }
/**
 * this class ends here
 */
}