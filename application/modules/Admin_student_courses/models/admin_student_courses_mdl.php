<?php
/* THIS CLASS WAS WRITTEN BY AKPU FRANKLIN CHIMAOBI*/
defined('BASEPATH') OR exit('No direct script access allowed');

class admin_student_courses_mdl extends CI_Model
{
 
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * this returns the students_courses table
     */
    public function return_table()
      {
        $table = "student_courses";
        return $table;
      }
      /**
       * this returns the merge_course table
       */
   public function return_merge_course_table()
   {
       $table = "merge_course";
       return $table;
   }
  
     /*
     * THIS RETURNS THE TABLE TO BE USED WHICH IS THE sessions TABLE
     * ==============================================================================
     */
    public function return_sessions_table()
    {
      $table = "sessions";
      return $table;
    } 
     /**
       * this returns the topics table
       */
      public function return_topic_table()
      {
          $table ="topic";
          return $table;
      }

   /**
    * this adds a course to the courses table
    */
      public function add_course($course)
      {
          $table = $this->return_table();
        $this->db->insert($table,$course);
      }
  /**
   * checks if the course already exist in the students_courses table
   */
      public function check_course($course)
      {
        $table = $this->return_table();
         $this->db->select("*");
         $this->db->from($table);
         $this->db->where("course_name", $course);
         $total_val = $this->db->count_all_results();
         return $total_val;
      }

      /**
       * this counts all the courses in the students_courses table
       */
     public function count_courses()
     {
       $table = $this->return_table();
      return $this->db->count_all($table);
     }
  
     /**
      * this returns the data of the total courses it has 2 paramaters:
      *@$limit:states the number of data it should collect from the db per page request
      *@$start:where it should start from to start collecting data
      */

     public function fetch_courses($limit,$start)
     {
       $table = $this->return_table();
       $this->db->order_by("id", "DESC");
      $this->db->limit($limit, $start);
      $query = $this->db->get($table);

      if ($query->num_rows() > 0) {
          foreach ($query->result() as $row) {
              $data[] = $row;
          }
          return $data;
      }
      return false;
     }
      
     /**
      * this functions gets a course from the id
      */

   public function course_from_id($id)
   {
       $table = $this->return_table();
       $this->db->where("id",$id);
     $query = $this->db->get($table);
     foreach ($query->result() as $key => $value) {
         $course = $value->course_name;
         return $course;
     }
     
   }
     /**
      * this function deletes a course from the id
      */
    public function delete_course($id)
    {
      $table = $this->return_table();
      $this->db->where('id', $id);
      return $this->db->delete($table);
    }

/**
 * this deletes courses in the merge_course table already deleted in the courses table
 */
     public function delete_course_everywhere($course_from_id)
     {
        $table = $this->return_merge_course_table();
        $this->db->where('course_name', $course_from_id);
        $total = $this->db->count_all_results($table);
        if($total==0){

        }else{
            $this->db->where('course_name', $course_from_id);
            return $this->db->delete($table);
        }
     
     }

    /**
     * this function searches for courses based on the paramter passed from the controller admin_student_courses
     */
        public function search_course($search_term)
    {
            $table = $this->return_table();
            $this->db->like('course_name',$search_term);  
            $total = $this->db->count_all_results($table);
            if($total==0){
                return array("content_error"=>"course cannot be found");
            }  else{
                $this->db->like('course_name',$search_term);
                $this->db->order_by("id","DESC");
                $query = $this->db->get($table);
                return $query->result_array();
            }          
     } 
     
    /**
     * this function checks if a pair of paramaters already exist in the merge_course table:
     * @$course_name:this is the name of the course in the merge_course table
     * @$class_name:this is the name of the class in the merge_course table
     */
     public function check_if_pair_exist($course_name, $class_name)
     {
         $table = $this->return_merge_course_table();
         $this->db->where("course_name", $course_name);
         $this->db->where("class_name", $class_name);
         $total = $this->db->count_all_results($table);
         if($total==0){
             return FALSE;
         }else{
             return TRUE;
         }
     }
     /**
     * this function inserts content into the merge_course table:
     * @$course_name:this is the name of the course in the merge_course table
     * @$class_name:this is the name of the class in the merge_course table
     */
     public function merge_new_course($course_name, $class_name)
     {
         $data_array = array(
             "course_name"=>$course_name,
             "class_name"=>$class_name
         );
         $table = $this->return_merge_course_table();
         $this->db->insert($table, $data_array);
     }

     /**
      * this function fetches all the courses in the student_course table
      */
     public function fetch_all_courses()
     {
         $table = $this->return_table();
        $query = $this->db->get($table);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
     }

    /**
      * this function fetches searches for courses in the merged course table based on the class_name column
      */

     public function search_for_merged_courses($class_name)
     {
         $table = $this->return_merge_course_table();
         $this->db->where("class_name", $class_name);
         $total = $this->db->count_all_results($table);
         if($total==0){
            return array("content_error"=>"no course added yet for this class");
         }else{
             $this->db->where("class_name", $class_name);
             $query = $this->db->get($table);
            foreach($query->result() as $row){
                $data[] = $row;
            }
            return $data;
         }
        return $false;
     }
/**
 * delete a specific merge course row in the merge course table using:
 * @$id:the id which is the unique identifier
 */
     public function delete_specific_merged_courses($get_id)
     {
         $table = $this->return_merge_course_table();
         $this->db->where("id", $get_id);
         $this->db->delete($table);
     }

  /**
   * this function checks if the class name exists in the database returns a boolean value
   */
     public function check_class_name_if_exist_in_merge_table($get_class_name)
     {
        $table =  $this->return_merge_course_table();
       $this->db->where("class_name", $get_class_name);
       $total = $this->db->count_all_results($table);
       if($total==0){
           return FALSE;
       }else{
           return TRUE;
       }

     }
  /**
   * deletes data in the merged table based on the class_name row if it is the same with the data passed from the controller
   */
     public function delete_merged_courses($get_class_name)
     {
        $table = $this->return_merge_course_table();
         $this->db->where("class_name", $get_class_name);
         $this->db->delete($table);
     }

   
/**
 * this adds a new session to the sessions table
 */
  public function add_sessions($sessions)
  {
      $table = $this->return_sessions_table();
    $this->db->insert($table,$sessions);
  }
     /**
      * this deletes a session based on the id passed to it from the controller admin_student_courses
      */
    public function delete_sessions($id)
    {
      $table = $this->return_sessions_table();
      $this->db->where('id', $id);
      return $this->db->delete($table);
    }
  /**
   * this searches for a session based on paramter gottten from the controller called the search_term:
   * the search query is returned in a descending order using CI query builders order_by function
   */
    public function search_sessions($search_term)
    {
            $table = $this->return_sessions_table();
            $this->db->like('sessions_name',$search_term);      
            $this->db->order_by("id","DESC");
            $query = $this->db->get($table);
            return $query->result_array();
     }   
   /**
    * this checks if session already exist and could be used for a key purposes:
    *to check if it already xist in the db to avoid a duplicated data in the databse
    */
    public function check_sessions($sessions)
    {
      $table = $this->return_sessions_table();
       $this->db->select("*");
       $this->db->from($table);
       $this->db->where("sessions_name", $sessions);
       $total_val = $this->db->count_all_results();
       return $total_val;
    }

   /**
    * this counts the total number of sessions in the sessions table available
    */
    public function count_sessions()
    {
      $table = $this->return_sessions_table();
     return $this->db->count_all($table);
    }




 
   /**
    * returns paginated data of session data from the session table
    */

    public function fetch_sessions($limit,$start)
    {
      $table = $this->return_sessions_table();
      $this->db->order_by("id", "DESC");
     $this->db->limit($limit, $start);
     $query = $this->db->get($table);

     if ($query->num_rows() > 0) {
         foreach ($query->result() as $row) {
             $data[] = $row;
         }
         return $data;
     }
     return false;
    }
    
     
/**
 * gets the value of a session based on the id suppied to it
 */
   public function sessions_from_id($id)
   {
       $table = $this->return_sessions_table();
       $this->db->where("id",$id);
     $query = $this->db->get($table);
     foreach ($query->result() as $key => $value) {
         $sessions = $value->sessions_name;
         return $sessions;
     }
     
   }
   /**
    * this deletes content in the topics table and this is activated if the sessions table content is about to be deleted
    *the essence is to save memory space
    */
    public function delete_deleted_sessions($sessions_from_id)
    {
      $table = $this->return_topic_table();
      $this->db->where("sessions_name",$sessions_from_id);
      $this->db->delete($table);
    }

    public function fetch_all_sessions()
    {
        $table = $this->return_sessions_table();
        $query = $this->db->get($table);

     if ($query->num_rows() > 0) {
         foreach ($query->result() as $row) {
             $data[] = $row;
         }
         return $data;
     }
     return false;
        
    }

    /**
     * check if the new topic already has exactly the same content from:
     * @topicname:the name of the topic
     * @sessionname:the name of the session
     * @coursename:the name of the course
     * @class_name which the class under which all this are in
     */
    
    public function check_if_new_topic_pair_exist_in_db($topic_name,$sessions_name,$course_name,$class_name)
    {
     $table = $this->return_topic_table();
     $this->db->where("topic", $topic_name);
     $this->db->where("sessions_name", $sessions_name);
     $this->db->where("course_name", $course_name);
     $this->db->where("class_name", $class_name);
     $count_all = $this->db->count_all_results($table);
     return $count_all;     
    }
    /**
     * this checks if classes and course name together exist exactly in the database
     */
    public function check_class_course_merge($course_name, $class_name)
    {
      $table = $this->return_merge_course_table();
      $this->db->where("course_name", $course_name);
      $this->db->where("class_name", $class_name);
      $count_all = $this->db->count_all_results($table);
      return $count_all;     
    }
    /**
    * this adds a topic to the topic table
    */
    public function add_topic($mapped_data)
    {
        $table = $this->return_topic_table();
      $this->db->insert($table,$mapped_data);
    }
    public function fetch_unique_session_for_class_and_course($get_class_name,$get_course_name)
    {
        $table = $this->return_topic_table();
        $query = $this->db->query("SELECT DISTINCT sessions_name FROM $table WHERE class_name='$get_class_name' AND course_name='$get_course_name'");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

   public function fetch_course_name_from_merged($get_id)
   {
       $table = $this->return_merge_course_table();
       $this->db->where("id", $get_id);
       $query = $this->db->get($table);
       if ($query->num_rows() > 0) {
        foreach ($query->result() as $row) {
            $course_name =  $row->course_name;
            $class_name =  $row->class_name;
            $data = array("course_name"=>$course_name, "class_name"=>$class_name);
        }
        return $data;
    }
    return false;
   }


   public function delete_course_children_topic_from_topic_table($course_name_and_class_name_array)
   {
    $table = $this->return_topic_table();
    $this->db->where($course_name_and_class_name_array);    
    $this->db->delete($table);  
   }     
  
   public function delete_class_children_topic_from_topic_table($get_class_name)
   {
       $table = $this->return_topic_table();
       $this->db->where("class_name",$get_class_name);
       $this->db->delete($table);
   }
   

   public function load_topics_per_term($get_course_name, $get_class_name,$get_session_name)
   { 
       $table = $this->return_topic_table();
       $this->db->where("class_name",$get_class_name);
       $this->db->where("course_name", $get_course_name);
       $this->db->where("sessions_name",$get_session_name);
       $query = $this->db->get($table);
       if ($query->num_rows() > 0) {
        foreach ($query->result() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    return false;

   }
   
   public function delete_topic($delete_topic_id)
   {
       $table = $this->return_topic_table();
       $this->db->where("id", $delete_topic_id);
       $this->db->delete($table);
   }
      /**
       * end of this class
       */
    }