<?php
/* THIS CLASS WAS WRITTEN BY AKPU FRANKLIN CHIMAOBI*/
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH ."libraries/Page_Settings.php";


class admin_student_results extends MX_Controller
{

   public function __construct()
   {
    parent::__construct();
    $this->load->module(['Admin_classes','templates','Admin_student_details','Authadmin','Admin_student_results','Admin_student_courses']);
    $this->load->helper(["url","cookie","security"]);  
    $this->load->library(['session','pagination']);
    $this->load->model(["AuthAdmin/AuthAdmin_mdl","admin_classes/admin_classes_mdl",
    "Admin_student_details/admin_student_details_mdl","Admin_student_results/admin_student_results_mdl",
    "Admin_student_courses/admin_student_courses_mdl"]);
   }

    
  public function index()
  {      
      $data = $this->fetch_paginated_students();
    if($this->authadmin->checkSessionOrCookie()==TRUE){
      $data_send = Page_Settings::set_page('adminmanageresults_view', $data, '' , 'Welcome Once Again', 'Admin_student_results');
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
      $config["base_url"] = base_url() . "Home/Manage-Results";
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
   * this loads the add students view
   */
   
   public function add_results()
   {
    $data["fetch_all_sessions"] =  $this->admin_student_courses_mdl->fetch_all_sessions();
    $id = htmlspecialchars($this->uri->segment(3));
    $data["students_name"]= $this->get_students_name_from_id($id);
    $data["classes"] = $this->fetch_classes_for_results();
    if($this->authadmin->checkSessionOrCookie()==TRUE){
      $data_send = Page_Settings::set_page('adminaddstudentsresults_view', $data, '' , 'Welcome Once Again', 'Admin_student_results');
      $this->templates->backend($data_send); 
    }else if($this->authadmin->checkSessionOrCookie()==FALSE){
      redirect(base_url()."administrator/login");      
      }
   }

   /**
    * makes students name available through the id which is gotten from the uri
    */

   public function get_students_name_from_id($id)
   {     
    $data =  $this->admin_student_details_mdl->fetch_student_by_id($id);
    return $data;
   }
  
   /**
    * fetches all the classes needed for results
    *note:the function fetch_classes_for_sub_classes is gotten from the classes model used for getting the classes to enable access
    *to the subclasses this is also needed here and no need of changing the name either.
    */
   public function fetch_classes_for_results()
   {
   $classes = $this->admin_classes_mdl->fetch_classes_for_sub_classes();
   return $classes;
   }
   

   public function load_result_sheet()
   {
    $class_name = htmlspecialchars( $this->security->xss_clean($this->input->get("class_name"))); 
    $session =  htmlspecialchars($this->security->xss_clean($this->input->get("session")));
    
    if($class_name==""){
     $msg = array("error"=>"please to generate the appropiate result sheet please be sure to select a class");
     print json_encode($msg);
    }else if($session==""){
     $msg = array("error"=>"please to generate the appropiate result sheet please be sure to select a session");
      print json_encode($msg);
    }else{
     $return_courses = $this->admin_student_results_mdl->fetch_course($class_name, $session);
     print json_encode($return_courses);
    }
   }
 /**
  * this loads the grade view which is the home/Manage-grade
  */
   public function grade_system()
  {
    $data = $this->paginate_grades();
    if($this->authadmin->checkSessionOrCookie()==TRUE){
      $data_send = Page_Settings::set_page('adminaddgrade_view', $data, '' , 'Welcome Once Again', 'Admin_student_results');
      $this->templates->backend($data_send); 
    }else if($this->authadmin->checkSessionOrCookie()==FALSE){
      redirect(base_url()."administrator/login");      
      }
  }
/**
 * this function adds grades after performing a couple of checks
 * check if the first and second grade range exist at the same time
 * check if grade letter exist like n example is if grade A has been assigned numbers 10-20 it can no more be used
 * check if the three first grade range ,second grade range and the grade letter exists all at the same time
 */

  public function add_grades()
  {
   $first_grade = $this->authadmin->sanitize_string($this->input->post("first_grade"));
   $second_grade = $this->authadmin->sanitize_string($this->input->post("second_grade"));
   $grade_letter = $this->authadmin->sanitize_string($this->input->post("grade_letter"));
   if($first_grade=="" || $second_grade==""){
     echo "first or second grade range cannot be left empty";
   }else if($grade_letter==""){
     echo "please enter a grade letter";
   }else{
     if( (!is_numeric($first_grade)) || (!is_numeric($second_grade))  ){
        echo "grade numbers can only be numbers";
     } else if($first_grade >= $second_grade){
       echo "first grade  range cannot be greater than or equal to second grade  range please second grade is always greater";
     }else if ($first_grade < 0 || $second_grade < 0 ){
      echo "sorry students cannot score less than zero";
        }
     else if($first_grade > 100 || $second_grade > 100){
       echo "no grade range can be greater than hundred as hundred is the highest score";
     }else{
       $check_if_grade_range_exist = $this->admin_student_results_mdl->check_if_grade_range_exist($first_grade, $second_grade);
       $check_if_grade_letter_exist = $this->admin_student_results_mdl->check_if_grade_letter_exist($grade_letter);
       $check_combined_grade_and_letter = $this->admin_student_results_mdl->check_combined_grade_and_letter($first_grade, $second_grade, $grade_letter);
       if($check_if_grade_range_exist==TRUE){
         echo "this grade range already exist please choose another grade range";
       }else if($check_if_grade_letter_exist==TRUE){
         echo "grade letter already exist if you want this grade letter for this grade score then delete grade range with this letter ";
       }else if($check_combined_grade_and_letter==TRUE){
         echo "the grade range with the same grade letter has aleady been entered";
       }else{
        $this->admin_student_results_mdl->add_grades($this->grade_mapping($first_grade,$second_grade,$grade_letter));
        echo "new grade range added successfully";
       }
     }
   }
  }

  public function paginate_grades()
  {
    $config["base_url"] = base_url() . "Home/Manage-Grade";
    $config['total_rows'] = $this->admin_student_results_mdl->count_grades();
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
    $data['results'] = $this->admin_student_results_mdl->fetch_grades($config["per_page"], $offset);
    $data["links"] = $this->pagination->create_links();
     return $data;  

  }

/**
 * mapping grade values that are to be added
 */
  
 public function grade_mapping($first_grade,$second_grade,$grade_letter)
 {
  $time = time();
   $data = array(
    "first_grade"=>$first_grade,
    "second_grade"=>$second_grade,
    "grade_letter"=>$grade_letter,
    "time_stamp_added"=>$time,
   );
   return $data;
 }
  /**
   * this is to delete a grade in the grade_view
   */
  public function delete_grades()
  {
    $id =  $this->input->get("id");
    if($id==""){
     echo "there seems to be a problem";    
    }else{
     $id = $this->security->xss_clean($id);
     $id = htmlspecialchars($id);
     $this->admin_student_results_mdl->delete_grades($id);
       echo "content was successfully deleted";
     }  
    }
/**
 * this loads the grade for each course once the save button is clicked before going ahead to save the data
 */
 function load_grade()
 {
   $get_data = $this->security->xss_clean(htmlspecialchars($this->input->get("score")));
   if($get_data==""){
     $msg = array("msg"=>"there seems to be a problem please refresh your browser");
     echo json_encode($msg);
   }else if(!is_numeric($get_data)){
    $msg = array("msg"=>"sorry score can only be numbers");
    echo json_encode($msg);
   }
   else if($get_data > 100){
    $msg = array("msg"=>"sorry you cannot score more than hundred in a subject");
    echo json_encode($msg);
   }else{
     $get_grade = $this->admin_student_results_mdl->get_grade($get_data);
     $msg = array("data"=>$get_grade);
     echo json_encode($msg);
   }
 }

 /**
  * this function saves each course score for the student ,it also undergoes some validation like:
  *@check_before_save_result($student_name, $class_name, $session,$course_name, $Year) which checks if content exist in the db before proceding other actions
  */
   public function save_course()
   {
     $Year = date("Y");
     $student_name = $this->authadmin->sanitize_string($this->input->post("student_name"));
     $course_name = $this->authadmin->sanitize_string($this->input->post("course_name")); 
      $quiz = $this->authadmin->sanitize_string($this->input->post("quiz"));
       $attendance = $this->authadmin->sanitize_string($this->input->post("attendance"));
      $exam = $this->authadmin->sanitize_string($this->input->post("exam"));
     $total_score = $this->authadmin->sanitize_string($this->input->post("total_score"));
     $grade = $this->authadmin->sanitize_string($this->input->post("grade"));
     $class_name = $this->authadmin->sanitize_string($this->input->post("class_name"));
     $slug = $this->authadmin->sanitize_string($this->input->post("slug"));
     $session =  $this->authadmin->sanitize_string($this->input->post("session"));
     $student_id =  $this->authadmin->sanitize_string($this->input->post("student_id"));
     if($course_name=="" || $quiz=="" || $attendance=="" || $exam =="" || $total_score=="" || $grade=="" || $student_id=="" ){
       $Msg = array("msg"=>"one or more fields for this course please be sure the quiz, attendance, exam is entered");
       echo json_encode($Msg);
     }else if($class_name=="" || $slug=="" || $student_name=="" || $session==""){
      $Msg = array("msg"=>"there seems to be a  problem please can you refresh your browser");
      echo json_encode($Msg);
     }else{
       $mapped_course =  $this->mapped_course_to_save($student_name, $course_name, $quiz,$attendance,
       $exam,$total_score,$grade,$class_name,$slug,$session,$student_id);
       $check_if_score_course_grade_already_exist =  $this->admin_student_results_mdl->check_before_save_result($student_name, $class_name, $session,$course_name, $Year,$student_id);
       if($check_if_score_course_grade_already_exist === TRUE){
        $Msg = array("msg"=>"sorry there seems to be a duplicate of this course for $student_name, 
        in class $class_name ,with the same session $session, the same course $course_name and the same year
        if you feel data entered is not correct or a need to update it simply click on the undo button and data will be deleted
        to allow add new score and grade for  $student_name in  $course_name during this same $session");
        echo json_encode($Msg);
       }else{
        $insert_data = $this->admin_student_results_mdl->save_course_result($mapped_course);
        $Msg = array("success"=>"this has been saved successfully");
      echo json_encode($Msg);
       }  
    }
   }
 /**
  * this will reset the course saved to the database by deleting it takes fours paramaters:
  *@$class_name, @$course_name, @$session, @$username
  */
   public function reset_course()
   {
     $class_name = $this->security->xss_clean(htmlspecialchars($this->input->get("class_name")));
     $course_name = $this->security->xss_clean(htmlspecialchars($this->input->get("course")));
     $session = $this->security->xss_clean(htmlspecialchars($this->input->get("session")));
     $username = $this->security->xss_clean(htmlspecialchars($this->input->get("username")));
     $student_id = $this->security->xss_clean(htmlspecialchars($this->input->get("student_id")));
     if($class_name=="" || $course_name=="" || $session=="" || $username=="" || $student_id==""){
       $msg = array("error"=>"there seems to be a problem please refresh your browser");
       echo json_encode($msg);
     }else{
        $check_score_exist = $this->admin_student_results_mdl->check_before_delete($class_name,$course_name,$session,$username,$student_id);
        if($check_score_exist==FALSE){
          $msg = array("error"=>"no content exist of such to be deleted");
       echo json_encode($msg);
        }else{
          $delete_single_course_from_db = $this->admin_student_results_mdl->delete_single_course_from_db($class_name,$course_name,$session,$username,$student_id);
          $msg = array("deleted"=>"this course has been successfully reset you can now save new score for this course");
          echo json_encode($msg);
        }
     }
    }
   
    public function save_final_result()
    {
      $class_name  = $this->authadmin->sanitize_string($this->input->post("class_name"));
      $session = $this->authadmin->sanitize_string($this->input->post("session"));
      $student_id = $this->authadmin->sanitize_string($this->input->post("student_id"));
      $username = $this->authadmin->sanitize_string($this->input->post("username"));
      $calendar_year = $this->authadmin->sanitize_string($this->input->post("calendar_year"));
      $remarks = $this->authadmin->sanitize_string($this->input->post("remarks"));
      $sub_class_name = $this->authadmin->sanitize_string($this->input->post("sub_class_name"));
      $calendar_check =(bool)preg_match("/^[0-9]{4}-[0-9]{4}$/",$calendar_year); //this is a regular expression to checkmate the year format
      if($calendar_year==""){
        $msg = array("error"=>"please ensure you enter a calendar year of valid format YYYY/YYYY");
        echo json_encode($msg);
      }else if($calendar_check==FALSE){
        $msg = array("error"=>"please ensure you enter a calendar year valid format YYYY/YYYY");
        echo json_encode($msg);
      }
      else if($class_name=="" || $session=="" || $username=="" || $student_id=="" || $sub_class_name==""){
        $msg = array("error"=>"there seems to be a problem please refresh your browser");
        echo json_encode($msg);
      }else{
         $check_total_available_course_result = $this->admin_student_results_mdl->check_total_avaialable_course_result($class_name,$session, $student_id);
         if($check_total_available_course_result==0){
           $msg = array("error"=>"no result exist for this session with this student please be sure to add some course scores first
           or if you feel thats a long process then just upload a file directly using the fab icon at the bottom right");
         echo json_encode($msg);
         }else{
           $total_score = $this->admin_student_results_mdl->fetch_total_score_for_all_courses_per_term($class_name,$session,$student_id);
          if($total_score <= 0){
            /**mapping if total score is zero to avoid certain logical errors  we simply field columns that perform evaluations with zero*/
            $mapped_zero_data = $this->mapped_average_total_score_to_save("0","0",$calendar_year,$remarks,
            $session,$class_name,$student_id,"0",$username);
            $save_result_zero =  $this->admin_student_results_mdl->save_final_results_for_session($mapped_zero_data);
            $msg = array("success"=>"student result was saved succesfully");
         echo json_encode($msg);
            /*save final score as zero and total courses as the amount avaialable*/;
           }else{
             /**check if similar result already exist in the databaser */
             $check_final_result_exist_in_db = $this->admin_student_results_mdl->check_final_result_exist_in_db($class_name,$session,$student_id,$calendar_year);
             if($check_final_result_exist_in_db > 0){
              $msg = array("override_error"=>"this result already has a duplicate in the database would you like to overide this result?");
         echo json_encode($msg);
             }else{
              $student_average = $total_score/$check_total_available_course_result;//this is to find the students average score
              $mapped_data = $this->mapped_average_total_score_to_save($total_score, $check_total_available_course_result,
              $calendar_year,$remarks,$session,$class_name,$student_id,$student_average,$username,$sub_class_name);
              /**save the total score for all the courses for the session and the average*/ 
             $save_result = $this->admin_student_results_mdl->save_final_results_for_session($mapped_data);
              $msg = array("success"=>"student result was saved successfully");
              echo json_encode($msg);
             }           
              
           }
         }
      }
    }
  /**
   * this function takes the same parameters and values as the save final result except that it updates the results 
   * with the new data
   */
  public function update_final_result()
  {
    $class_name  = $this->authadmin->sanitize_string($this->input->post("class_name"));
    $session = $this->authadmin->sanitize_string($this->input->post("session"));
    $student_id = $this->authadmin->sanitize_string($this->input->post("student_id"));
    $username = $this->authadmin->sanitize_string($this->input->post("username"));
    $calendar_year = $this->authadmin->sanitize_string($this->input->post("calendar_year"));
    $remarks = $this->authadmin->sanitize_string($this->input->post("remarks"));
    $sub_class_name = $this->authadmin->sanitize_string($this->input->post("sub_class_name"));
    $calendar_check =(bool)preg_match("/^[0-9]{4}-[0-9]{4}$/",$calendar_year); //this is a regular expression to checkmate the year format
    if($calendar_year==""){
      $msg = array("error"=>"please ensure you enter a calendar year of valid format YYYY/YYYY");
      echo json_encode($msg);
    }else if($calendar_check==FALSE){
      $msg = array("error"=>"please ensure you enter a calendar year valid format YYYY/YYYY");
      echo json_encode($msg);
    }
    else if($class_name=="" || $session=="" || $username=="" || $student_id=="" || $sub_class_name==""){
      $msg = array("error"=>"there seems to be a problem please refresh your browser ");
      echo json_encode($msg);
    }
    else{

      $get_content_file_name_to_update = $this->admin_student_results_mdl->get_file_name($class_name,$session,$student_id,
      $calendar_year);
      if($get_content_file_name_to_update==NULL){
        $check_total_available_course_result = $this->admin_student_results_mdl->check_total_avaialable_course_result($class_name,$session, $student_id);
        if($check_total_available_course_result==0){
          $msg = array("error"=>"no result exist for this session with this student please be sure to add some course scores first");
        echo json_encode($msg);
        }else{
          $total_score = $this->admin_student_results_mdl->fetch_total_score_for_all_courses_per_term($class_name,$session,$student_id);
          $student_average = $total_score/$check_total_available_course_result;//this is to find the students average score
          $mapped_data = $this->mapped_average_total_score_to_save($total_score, $check_total_available_course_result,$calendar_year,
         $remarks,$session,$class_name,$student_id,$student_average,$username,$sub_class_name);
          /**save the total score for all the courses for the session and the average*/ 
         $save_result = $this->admin_student_results_mdl->update_final_results_for_session($mapped_data,$class_name,$session,$student_id,$calendar_year);
          $msg = array("success"=>"student result was updated successfully");
          echo json_encode($msg);
        }
      }
      else{
        $check_total_available_course_result = $this->admin_student_results_mdl->check_total_avaialable_course_result($class_name,$session, $student_id);
        if($check_total_available_course_result==0){
          $msg = array("error"=>"no result exist for this session with this student please be sure to add some course scores first");
        echo json_encode($msg);
        }else{
          $total_score = $this->admin_student_results_mdl->fetch_total_score_for_all_courses_per_term($class_name,$session,$student_id);
          $student_average = $total_score/$check_total_available_course_result;//this is to find the students average score
          $mapped_data = $this->mapped_average_total_score_to_save($total_score, $check_total_available_course_result,$calendar_year,
         $remarks,$session,$class_name,$student_id,$student_average,$username,$sub_class_name);
          /**save the total score for all the courses for the session and the average*/ 
         $save_result = $this->admin_student_results_mdl->update_final_results_for_session($mapped_data,$class_name,$session,$student_id,$calendar_year);
                   unlink("assets/student_results/$get_content_file_name_to_update");
          $msg = array("error"=>"student result was updated successfully");
          echo json_encode($msg);
         
          
        }
      } 
    }

  }
 
  public function upload_result_file($file_name)
  {
   
   $config['upload_path'] = './assets/student_results/';
   $config['allowed_types'] = '*';
  //  $config['max_size']  = '100';
  //  $config['max_width']  = '1024';
  //  $config['max_height']  = '768';
    $config["file_name"] = rand();
   $config["encrypt_name"] = TRUE;
   $this->load->library('upload', $config);
   
   //if ( !
    $this->upload->do_upload($file_name);
  //)
    //{
  //    $error = array('error' => $this->upload->display_errors());
  //  }
  //  else{
  //    $data = array('upload_data' => $this->upload->data());
  //    echo "success";
  //  }
   
  }
 
  function check_doc_mime( $tmpname ) {
    @$mime_type  = array("application/pdf","application/docx","application/msword",
    "application/vnd.openxmlformats-officedocument.wordprocessingml.document");
    $finfo = finfo_open( FILEINFO_MIME_TYPE );
   $mtype = finfo_file( $finfo, $tmpname );
   finfo_close( $finfo );
   if(in_array($mtype,$mime_type)){
     return TRUE;
   }else{
     return FALSE;
   }
 }
 
  
/**
 * this function saves the final result with a file attached to it
 */
 public function save_final_result_with_file()
 {
  $class_name  = $this->authadmin->sanitize_string($this->input->post("class_name"));
  $session = $this->authadmin->sanitize_string($this->input->post("session"));
  $student_id = $this->authadmin->sanitize_string($this->input->post("student_id"));
  $username = $this->authadmin->sanitize_string($this->input->post("username"));
  $calendar_year = $this->authadmin->sanitize_string($this->input->post("calendar_year"));
  $remarks = $this->authadmin->sanitize_string($this->input->post("remarks"));
  $sub_class_name = $this->authadmin->sanitize_string($this->input->post("sub_class_name"));
  $calendar_check =(bool)preg_match("/^[0-9]{4}-[0-9]{4}$/",$calendar_year); //this is a regular expression to checkmate the year format
  @$file_name = $_FILES["result_file"]["name"];
    @$tempoary_name = $_FILES["result_file"]["tmp_name"];
    @$file_size = $_FILES["result_file"]["size"];
    if($calendar_year==""){
      $msg = array("error"=>"please ensure you enter a calendar year of valid format YYYY/YYYY");
      echo json_encode($msg);
    }else if($calendar_check==FALSE){
      $msg = array("error"=>"please ensure you enter a calendar year valid format YYYY/YYYY");
      echo json_encode($msg);
    }
    else if($class_name=="" || $session=="" || $username=="" || $student_id=="" || $sub_class_name==""){
      $msg = array("error"=>"there seems to be a problem please refresh your browser");
      echo json_encode($msg);
    }else{
      /**check if similar result already exist in the databaser */
      $check_final_result_exist_in_db = $this->admin_student_results_mdl->check_final_result_exist_in_db($class_name,$session,$student_id,$calendar_year);
      if($check_final_result_exist_in_db > 0){
       $msg = array("override_error"=>"this result already has a duplicate in the database would you like to overide this result?");
  echo json_encode($msg);
      }else{
        if($this->check_doc_mime($tempoary_name)==FALSE){
          $msg = array("error"=>"this file is not a pdf or an msword document please ensure it is one of them before uploading");
          echo json_encode($msg);
        }else{
          
         /**
         * rename result file and upload it before saving the data to the db
         */
        $temp = explode(".", $file_name);
        $newfilename = $username."_".$calendar_year."".round(microtime(true)) . '.' . end($temp); //rename file  
       $mapped_data = $this->mapped_average_total_score_to_save_with_file($class_name,$session,$student_id,$username,$calendar_year,
      $remarks,$sub_class_name,$newfilename);
       /**save the total score for all the courses for the session and the average*/ 
      if(file_exists("assets/student_results")){
        $save_result = $this->admin_student_results_mdl->save_final_results_for_session($mapped_data);
        move_uploaded_file($tempoary_name, "assets/student_results/$newfilename");
       $msg = array("success"=>"student result was saved successfully");
       echo json_encode($msg);
      }else{
        $msg = array("error"=>"there seems to be a problem please contact the developement team to help fix this problem");
        echo json_encode($msg);
      }
        }
        
      }           
     
    }
 }
/**
 * this function performs an update on a final result with a file
 */
 public function update_final_result_with_file()
 {
  $class_name  = $this->authadmin->sanitize_string($this->input->post("class_name"));
  $session = $this->authadmin->sanitize_string($this->input->post("session"));
  $student_id = $this->authadmin->sanitize_string($this->input->post("student_id"));
  $username = $this->authadmin->sanitize_string($this->input->post("username"));
  $calendar_year = $this->authadmin->sanitize_string($this->input->post("calendar_year"));
  $remarks = $this->authadmin->sanitize_string($this->input->post("remarks"));
  $sub_class_name = $this->authadmin->sanitize_string($this->input->post("sub_class_name"));
  $calendar_check =(bool)preg_match("/^[0-9]{4}-[0-9]{4}$/",$calendar_year); //this is a regular expression to checkmate the year format
  @$file_name = $_FILES["result_file"]["name"];
    @$tempoary_name = $_FILES["result_file"]["tmp_name"];
    @$file_size = $_FILES["result_file"]["size"];
    if($calendar_year==""){
      $msg = array("error"=>"please ensure you enter a calendar year of valid format YYYY/YYYY");
      echo json_encode($msg);
    }else if($calendar_check==FALSE){
      $msg = array("error"=>"please ensure you enter a calendar year valid format YYYY/YYYY");
      echo json_encode($msg);
    }
    else if($class_name=="" || $session=="" || $username=="" || $student_id=="" || $sub_class_name==""){
      $msg = array("error"=>"there seems to be a problem please refresh your browser");
      echo json_encode($msg);
    }else{
      /**
       * get the file name and then delete the file first before updating and uploading a new file to the db
       */
      /**
         * rename result file and upload it before saving the data to the db
         */
        $temp = explode(".", $file_name);
        $newfilename = $username."_".$calendar_year."".round(microtime(true)) . '.' . end($temp); //rename file 
      $mapped_data = $this->mapped_average_total_score_to_save_with_file($class_name,$session,$student_id,$username,$calendar_year,
      $remarks,$sub_class_name,$newfilename);
     $get_content_file_name_to_update = $this->admin_student_results_mdl->get_file_name($class_name,$session,$student_id,
     $calendar_year);
     if($get_content_file_name_to_update==NULL){ 
        $save_result = $this->admin_student_results_mdl->update_final_results_for_session($mapped_data,$class_name,$session,$student_id,$calendar_year);
        move_uploaded_file($tempoary_name, "assets/student_results/$newfilename");
       $msg = array("success"=>"student result was updated successfully");
       echo json_encode($msg);
       //if a file exist then delete the file first before updating content and saving file to the db
     }else{
      $save_result = $this->admin_student_results_mdl->update_final_results_for_session($mapped_data,$class_name,
      $session,$student_id,$calendar_year);
      unlink("assets/student_results/$get_content_file_name_to_update");
      move_uploaded_file($tempoary_name, "assets/student_results/$newfilename");
     $msg = array("success"=>"student result was updated successfully");
     echo json_encode($msg);
  
     }
       
    }
 }

/**
 * this function performs a mapping for the final result to be saved
 */
   public function mapped_average_total_score_to_save($total_score, $check_total_available_course_result,$calendar_year,
   $remarks,$session,$class_name,$student_id,$student_average,$username,$sub_class_name,$newfilename=NULL)
   {
    $data = array(
      "total_score"=> $total_score,
      "total_courses_compiled"=> $check_total_available_course_result,
       "calendar_year"=>$calendar_year,
       "remarks"=>$remarks,
       "session"=>$session,
       "class_name"=>$class_name,
       "student_id"=>$student_id,
       "student_average"=>$student_average,
        "time"=>time(),
        "student_name"=>$username,
        "sub_class_name"=>$sub_class_name,
        "file_result"=>$newfilename
    );
    return $data; 
   }

  /**
   * this function is to map results uploaded with a pdf file or a docx file
   */
  public function mapped_average_total_score_to_save_with_file($class_name,$session,$student_id,$username,$calendar_year,
  $remarks,$sub_class_name,$newfilename)
  {
  $data = array(
    "class_name"=>$class_name,
    "session"=>$session,
    "student_id"=>$student_id,
    "student_name"=>$username,
    "calendar_year"=>$calendar_year,
    "remarks"=>$remarks,
    "sub_class_name"=>$sub_class_name,
    "file_result" =>$newfilename,
    "time"=>time(),
  );
  return $data;
  }

  /**
   * this function maps courses to be saved  
   */
   public function mapped_course_to_save($student_name, $course_name, $quiz,$attendance,
   $exam,$total_score,$grade,$class_name,$slug,$session,$student_id)
   {
     $time = date("Y");
    $data = array(
      "student_name"=> $student_name,
      "course_name"=> $course_name,
       "quiz"=>$quiz,
       "attendance"=>$attendance,
       "exam"=>$exam,
       "total_score"=>$total_score,
       "grade"=>$grade,
       "class_name"=>$class_name,
       "slug"=>$slug,
       "session"=>$session,
       "time"=>$time,
       "student_id"=>$student_id
    );
    return $data;
   }
  /**
   * this function gets particular student result from db with pagination
   */

  public function fetch_paginated_students_results($id)
  {
    $config = array();
    $config["base_url"] = base_url() . "Home/View-Results/$id";
    $config['total_rows'] = $this->admin_student_results_mdl->count_particular_students_final_results($id);
    $config['per_page'] = 5;
    $config['use_page_numbers'] = TRUE;     
    $config['uri_segment'] = 4; 
   $this->pagination->initialize($config);   
    if($this->uri->segment(4) > 0){
      $offset = ($this->uri->segment(4) + 0)*$config['per_page'] - $config['per_page'];
    }
    else{
      $offset = $this->uri->segment(4);
    }
    $data['results'] = $this->admin_student_results_mdl->fetch_particular_students_final_results($config["per_page"], $offset,$id);
    $data["links"] = $this->pagination->create_links();
     return $data;  
  }
/**
 * this view displays particular student results details
 */
 public function view_results($id)
 {
    $data = $this->fetch_paginated_students_results($id);
  if($this->authadmin->checkSessionOrCookie()==TRUE){
    $data_send = Page_Settings::set_page('displayresultinfo_view', $data, '' , 'student result', 'Admin_student_results');
    $this->templates->backend($data_send); 
  }else if($this->authadmin->checkSessionOrCookie()==FALSE){
    redirect(base_url()."administrator/login");      
    } 
 }

//this http requet displays the full result in a modal 
public function show_full_result_details()
{
  $session = htmlspecialchars($this->input->get("session"));
  $class_name = htmlspecialchars($this->input->get("class_name"));
  $sub_class_name = htmlspecialchars($this->input->get("sub_class_name"));
  $student_id = htmlspecialchars($this->input->get("student_id"));
  $calendar_year = htmlspecialchars($this->input->get("calendar_year"));
 // echo json_encode(array("student_id"=>$student_id,"class_name"=>$class_name,"sub_class"=>$sub_class_name,"session"=>$session));
  //return;
 if($student_id=="" || $class_name=="" || $sub_class_name=="" || $session=="" || $calendar_year==""){
  $msg = array("error"=>"there seems to be a problem please refresh your browser");
  print json_encode($msg);
 }else{
  $check_if_its_a_file = $this->admin_student_results_mdl->get_file_name($class_name,$session,$student_id,$calendar_year);
  if($check_if_its_a_file==NULL){
 
  }else{
    $student_result_content = $check_if_its_a_file;
    $file = array("file_name"=>$student_result_content);
    echo json_encode($file);
  }
 }
}


  /**
   * this class ends herea
   */
  }


  