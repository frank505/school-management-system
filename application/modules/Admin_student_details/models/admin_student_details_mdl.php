<?php
/* THIS CLASS WAS WRITTEN BY AKPU FRANKLIN CHIMAOBI*/
defined('BASEPATH') OR exit('No direct script access allowed');

class admin_student_details_mdl extends CI_Model
{
 
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * this returns the students_detail table
     */
    public function return_table()
      {
        $table = "student_details";
        return $table;
      } 
  /**
   * this returns the student class
   */
      public function return_class_table()
      {
       $table = "classes";
       return $table;
      }
      /**
       * this counts the total number of students in the students_details table
       */
      
    public function count_students()
    {
      $table = $this->return_table();
     return $this->db->count_all($table);
    }
  /**
   * this function counts the total number of students searched for it takes one paramter:
   * @$select_class:this is the countent to be searched for if the content ever exist in the database
   * it will return the total number of them
   * @note:this doesnt return the data but the total result searched
   */
    public function count_number_of_students_requested($select_class)
    {
        $table = $this->return_table();
        $this->db->where("class_name", $select_class);
        return $this->db->count_all_results($table);
    }
 /**
  * this function returns the total number of students requested/searched for in a paginated format:
  * @limit:the limit per page
  * @start:the starting point it should display per page 
  * e.g it could START displaying from student number 10 with a LIMIT of 5 that is to say it will display 15 students  
  */
    public function fetch_number_of_students_requested($limit,$start,$select_class)
    {
        $table = $this->return_table();
        $this->db->where("class_name", $select_class);
        $this->db->order_by("id", "DESC");
       $this->db->limit($limit, $start);
       $query = $this->db->get($table);
  
       if ($query->num_rows() > 0) {
           foreach ($query->result() as $row) {
               $data[] = $row;
           }
           return $data;
       }else{
           echo"";
       }
       return false;  
    }
    
/**
 * this function fetches students details in a paginated format
  * @limit:the limit per page
  * @start:the starting point it should display per page 
  * e.g it could START displaying from student number 10 with a LIMIT of 5 that is to say it will display 15 students  
 */
    public function fetch_students($limit,$start)
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
    * this adds a new student to the student details table
    *@$mapped_data:this is the data gotten from the controller which will be inserted.it is always an array.
    */
      public function add_students($mapped_data)
      {
         $table = $this->return_table();
         $this->db->insert($table, $mapped_data);
      }
   
  /**
   * this searches for students from the student_detail table.
   * @$limit:the limit per page
   * @$search_term:the term to be searched for.
   */
   public function search_student_detail_content($search_term,$limit)
    {
        $table = $this->return_table();
    $filter = $this->input->post('class_name');
    if($filter == 'class_name')
    {
        $this->db->like('class_name',$search_term);
    }
    else if($filter=='username')
    {
        $this->db->like('username',$search_term);
    }
     else if($filter == 'sub_class_name')
    {
        $this->db->like('sub_class_name',$search_term);
    }
    else if($filter=='sex'){
        $this->db->like('sex',$search_term);
    }
     else
    {
        $this->db->like('class_name',$search_term);
        $this->db->or_like("username", $search_term);
        $this->db->or_like('sub_class_name',$search_term);
        $this->db->or_like('sex', $search_term);
        }
        $this->db->order_by("id","DESC");
        $this->db->limit($limit);
        $query = $this->db->get($table);
        return $query->result_array();
    }

  /**
   * this is an ajax function that loads more content based on the search it takes three paramaters:
   * @$limit:the limit per page
   * @$search_term:the term to be searched for.
   * @id:this id is to monitor the last item searched so as to know where exactly the last previously returned search item stopped
   * and display more search item if there are no more search items it returns nothing
   */
    public function load_more_search_student_detail($search_term,$id,$limit)
     {
        $table = $this->return_table();
        $this->db->where("id <",$id);
        $filter = $this->input->post('class_name');
        if($filter == 'class_name')
        {
            $this->db->like('class_name',$search_term);
        }
        else if($filter=='username')
        {
            $this->db->like('username',$search_term);
        }
         else if($filter == 'sub_class_name')
        {
            $this->db->like('sub_class_name',$search_term);
        }
        else if($filter=='sex'){
            $this->db->like('sex',$search_term);
        }
         else
        {    
            $this->db->like('class_name',$search_term);
            $this->db->or_like("username", $search_term);
            $this->db->or_like('sub_class_name',$search_term);
            $this->db->or_like('sex', $search_term);
            }
            $this->db->order_by("id","DESC");
            $this->db->limit($limit);
            $query = $this->db->get($table);
            return $query->result_array();
     }

  /**
   * this function fetches returns student details based on the id supplied it takes one paramter
   * $id:this is used to query the database and return the student details from the db
   */
     public function fetch_student_by_id($id)
     {
         $table = $this->return_table();
         $this->db->where("id", $id);
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
   * this function deletes students based on one paramter:
   * @$id:the id supplied is used to check if it exist in the database and delete student
   */
     public function delete_student($id)
    {
      $table = $this->return_table();
      $this->db->where('id', $id);
      return $this->db->delete($table);
    }
   /**
    * this function updates students details it takes two parameter:
    * @$id:this is used to query the db to know which content should be updated
    * @mapped_data:this is the data to updated.
    */

    public function update_students($id,$mapped_data)
    {
        $table = $this->return_table();
        $this->db->where("id", $id);
        return $this->db->update($table,$mapped_data);
    }
    
    /**
     * this function upgrades students class by upgrading the  takes two parameters:
     * @$id:this are all the contents that ought to be updated
     * @$select_search:this is to upgrade the class_name column in student_details from what it is currently to the select_search content
     * and all that will be updated will be based on the $id
     */
    public function ugrade_student_class($id,$select_search)
    {
    $mapped_data = array(
        "class_name"=>$select_search,
    );
     $table = $this->return_table();
     $class_table = $this->return_class_table();
     $this->db->where("class_name", $select_search);
    $result_count = $this->db->count_all_results($class_table);
    if($result_count==0){

    }else{
        $this->db->where("id", $id);
         $this->db->update($table,$mapped_data);
    }
    }


/**
 * this function checks if  class exist in our table:
 * @$upgrade_from:this is first class we will be checking if it exists in our database
 */
    public function check_if_student_class_exist($upgrade_from,$upgrade_to)
    {
        $table = $this->return_table();
        $class_table = $this->return_class_table();
       $this->db->where("class_name", $upgrade_from);
       $results_total = $this->db->count_all_results($table);
       if($results_total==0){
           return FALSE;
       }else{
        $this->db->where("class_name", $upgrade_to);
       $total = $this->db->count_all_results($class_table);
       if($total==0){
       return FALSE;
         }else{
        return TRUE;
        }
       }
    }

     public function search_for_student_to_upgrade_by_name($search_name)
     {
        $table = $this->return_table();
        $filter = $this->input->post('username');
        
         if($filter=='username')
        {
            $this->db->like('username',$search_name);
        }
         else
        {    
            $this->db->or_like("username", $search_name);
            
        }
            $this->db->order_by("id","DESC");
            $query = $this->db->get($table);
            if($query->num_rows() == 0){
                $no_content_found = array("no_content"=>"no content found please search using student name only");
                return $no_content_found;
            }else{
                return $query->result_array();
            }
     }
     /**
    * this function upgrades all the students from one class @$upgrade_from to another class @$upgrade_to
    */
    
    public function upgrade_all_students_class_in_upgrade_from($upgrade_to,$upgrade_from)
    {
        $table = $this->return_table();
        $upgrade_to_arrray = array(
         "class_name"=>$upgrade_to,
        );
        $this->db->where("class_name", $upgrade_from);
        $this->db->update($table,$upgrade_to_arrray);
    } 




     //end of this class  
    }