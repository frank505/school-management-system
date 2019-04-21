<?php
/* THIS CLASS WAS WRITTEN BY AKPU FRANKLIN CHIMAOBI*/
defined('BASEPATH') OR exit('No direct script access allowed');

class admin_student_results_mdl extends CI_Model
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
     * this returns the topics table
     */
      public function return_topic_table()
      {
        $table ="topic";
        return $table;
      }
      /**
       * this returns student final results table
       */
      public function return_final_result()
      {
          $table="final_result";
          return $table;
      }
      /**
       * this returns the grades table
       */
      public function return_grade_table()
      {
        $table = "grade";
        return $table;
      }
   /**
    * this table contains students results for each course
    */
      public function return_course_result_table()
      {
          $table = "course_result";
         return $table;
      }
      public function fetch_course($class_name, $session)
      {
        $table = $this->return_topic_table();
        $query = $this->db->query("SELECT DISTINCT course_name FROM $table WHERE class_name='$class_name' AND sessions_name='$session'");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

      }
/**
 * this function check if this grade range already exists in the grades table
 */

  public function check_if_grade_range_exist($first_grade, $second_grade)
  {
    $table = $this->return_grade_table();
    $this->db->where("first_grade",$first_grade);
    $this->db->where("second_grade",$second_grade);
    $total = $this->db->count_all_results($table);
         if($total > 0){
             return TRUE;
         }else{
             return FALSE;
         }

  }
  /**
   * this function checks if grade letter exist in the database 
   */
  public function check_if_grade_letter_exist($grade_letter)
  {
    $table = $this->return_grade_table();
    $this->db->where("grade_letter",$grade_letter);
    $total = $this->db->count_all_results($table);
         if($total > 0){
             return TRUE;
         }else{
             return FALSE;
         }
  }
  /**
   * check combined grade and letter
   */
  public function check_combined_grade_and_letter($first_grade, $second_grade, $grade_letter)
  {
    $table = $this->return_grade_table();
    $this->db->where("first_grade",$first_grade);
    $this->db->where("second_grade",$second_grade);
    $this->db->where("grade_letter", $grade_letter);
    $total = $this->db->count_all_results($table);
         if($total > 0){
             return TRUE;
         }else{
             return FALSE;
         }
  }
  
/**
 * this function adds a new grade range 
 */

 public function add_grades($grade_mapped_array)
 {
   $table = $this->return_grade_table();
   $this->db->insert($table, $grade_mapped_array);
   
 }

/**
 * this function fetches grades data in a paginated format
  * @limit:the limit per page
  * @start:the starting point it should display per page 
  * e.g it could START displaying from student number 10 with a LIMIT of 5 that is to say it will display 15 grades  
 */

public function fetch_grades($limit,$start)
{
  $table = $this->return_grade_table();
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
       * this counts the total number of students in the students_details table
       */
      
      public function count_grades()
      {
        $table = $this->return_grade_table();
       return $this->db->count_all($table);
      }
 /**
  * this is used to delete grades
  */
  public function delete_grades($id)
  {
      $table = $this->return_grade_table();
      $this->db->where("id", $id);
      return $this->db->delete($table);
  }

   public function get_grade($score)
   {
       $table = $this->return_grade_table();
    $query =  $this->db->query("SELECT * FROM $table where first_grade <= '$score' AND second_grade >='$score' LIMIT 1  ");
     if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $grade_letter = $row->grade_letter;
            }
            return $grade_letter;
        }
        return false;
   
}

/**
 * this saves anew course result in the courses table
 */
  public function save_course_result($mapped_course)
  {
      $table = $this->return_course_result_table();
      $this->db->insert($table, $mapped_course);
  }
/**
 * this performs a check before it saves the course
 * checks for the student name student class term course name and year
 * if it returns true that means it exist in the database and if it returns false then it doesnt exist in the database
 */

  public function check_before_save_result($student_name, $class_name, $term,$course_name, $Year,$student_id)
  {
    $table = $this->return_course_result_table();
    $this->db->where("student_name", $student_name);
    $this->db->where("class_name",$class_name);
    $this->db->where("session",$term);
    $this->db->where("course_name", $course_name);
    $this->db->where("time",$Year);
    $this->db->where("student_id",$student_id);
    $count_all = $this->db->count_all_results($table);
    if($count_all > 0){
        return TRUE;
    }else{
        return FALSE;
    }
  }
  /**
   * this function checks if what is to be reset is authentic or not
   */
  public function check_before_delete($class_name,$course_name,$session,$username,$student_id)
  {
    $table = $this->return_course_result_table();
    $this->db->where(["class_name"=>$class_name,"session"=>$session,"student_id"=>$student_id,
    "course_name"=>$course_name,"student_name"=>$username]);
    $count_all = $this->db->count_all_results($table);
    if($count_all > 0){
        return TRUE;
    }else{
        return FALSE;
    }
  }
/**
 * this function is used to reset courses saved during student result compilation
 */
  public function delete_single_course_from_db($class_name,$course_name,$session,$username,$student_id)
  {
    $table = $this->return_course_result_table();
    $this->db->where(["class_name"=>$class_name,"session"=>$session,"student_id"=>$student_id,
    "course_name"=>$course_name,"student_name"=>$username]);
   $this->db->delete($table);
  }

/**this function checks for available course results in the course result table. this is checked using some parameters
 * $class_name:which is the name of the class the student belongs to add the time of result compilation
 * $session:the session school is currently in for example if the sessions created in the app are first term second term and third
 * the id of the specific student which is a primary key in the students details table
 */
 public function check_total_avaialable_course_result($class_name,$session, $student_id)
 {
   $table = $this->return_course_result_table();
   $this->db->where(["class_name"=>$class_name,"session"=>$session,"student_id"=>$student_id]);
   $count_all = $this->db->count_all_results($table);
   return $count_all;
 }
 /**
  * this fetches the total score of the student from all the courses from that term and session
  */
  public function fetch_total_score_for_all_courses_per_term($class_name,$session,$student_id)
  {
    $table = $this->return_course_result_table();
    $this->db->where(["class_name"=>$class_name,"session"=>$session,"student_id"=>$student_id]);
    $query = $this->db->get($table);

    if ($query->num_rows() > 0) {
        foreach ($query->result() as $row) {
           $data_gotten = $row->total_score;
           $convert_data = $data_gotten * 1;
           @$data +=$convert_data;
          
        }
        return $data;
    }
    return false;
  }

  /**
   * this checks if the result entered is a already exist or not
   */
  public function check_final_result_exist_in_db($class_name,$session,$student_id,$calendar_year)
  {
    $table = $this->return_final_result();
    $this->db->where(["class_name"=>$class_name,"session"=>$session,"student_id"=>$student_id,"calendar_year"=>$calendar_year]);
    $count_all = $this->db->count_all_results($table);
   return $count_all;
  }

  /**
   * this inserts the final students results with things like student total score and student average
   */
  public function save_final_results_for_session($mapped_data)
  {
    $table = $this->return_final_result();
    $this->db->insert($table, $mapped_data);
  }
/**
 *  this updates the final students results with things like student total score and student average
 */
  public function update_final_results_for_session($mapped_data,$class_name,$session,$student_id,$calendar_year)
  {
    $table = $this->return_final_result();
    $this->db->where(["class_name"=>$class_name,"session"=>$session,"student_id"=>$student_id,"calendar_year"=>$calendar_year]);
    $this->db->update($table, $mapped_data);
  }
  /**
   * this is to return the file name
   */
   public function get_file_name($class_name,$session,$student_id,$calendar_year)
   {
    $table = $this->return_final_result();
     $this->db->where(["class_name"=>$class_name,"session"=>$session,"student_id"=>$student_id,"calendar_year"=>$calendar_year]);
    $query = $this->db->get($table);
    if ($query->num_rows() > 0) {
        foreach ($query->result() as $row) {
           $data = $row->file_result;
        }
        return $data;
    }
    return false;    
   }
/**
 * this function counts the total number of final results 
 * 
 */

  public function count_particular_students_final_results($id)
  {
      $table = $this->return_final_result();
      $this->db->where(["student_id"=>$id]);
      $count_all = $this->db->count_all_results($table);
      return $count_all;
     
  }
  /**
   * this function performs pagination on students final results to be displayed
   * @limit:limit per page
   * @start:the starting point it should display per page
   */

 public function fetch_particular_students_final_results($limit,$start,$id)
 {
  
        $table = $this->return_final_result();
        $this->db->where('student_id', $id);
         $this->db->order_by('id', 'DESC');
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
   * this class ends here
   */
}