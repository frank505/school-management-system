<?php
/* THIS CLASS WAS WRITTEN BY AKPU FRANKLIN CHIMAOBI*/
/* THIS MODEL HANDLES OPERATIONS ON THE USER TABLE ESPECIALLY FETCHING USER DETAILS.. */

defined('BASEPATH') OR exit('No direct script access allowed');
class scheme_of_work_mdl extends CI_Model
{
 public function __construct()
 {
  parent::__construct();
 }

  /**
     * this returns the students_courses table
     */
    public function return_students_course_table()
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
      /*
     * THIS RETURNS THE TABLE TO BE USED WHICH IS THE Classes TABLE
     * ==============================================================================
     */
    public function return_class_table()
    {
      $table = "classes";
      return $table;
    } 


 public function getClassesName()
 {
    $table = $this->return_class_table();
    $this->db->order_by("id", "DESC");
    $query = $this->db->get($table);

    if ($query->num_rows() > 0) {
        foreach ($query->result() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    return false;
 }

 public function getCourseName($class_name)
 {
     $table = $this->return_merge_course_table();
     $this->db->where("class_name", $class_name);
     $query = $this->db->get($table);
     if ($query->num_rows() > 0) {
        foreach ($query->result() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    return false;
 }


 public function getSessionsAvailable($get_class_name, $get_course_name)
 {
    $table = $this->return_topic_table();
    $query = $this->db->query("SELECT DISTINCT sessions_name,course_name FROM $table WHERE class_name='$get_class_name' AND course_name='$get_course_name'");
    if ($query->num_rows() > 0) {
        foreach ($query->result() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    return false;

 }

 public function getTopicsForThisCoursePerSemester($class_name, $course_name, $session_name)
 {
     $table = $this->return_topic_table();
     $this->db->where("class_name", $class_name);
     $this->db->where("course_name", $course_name);
     $this->db->where("sessions_name", $session_name);
     $query = $this->db->get($table);
     if ($query->num_rows() > 0) {
        foreach ($query->result() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    return false;
 }



}