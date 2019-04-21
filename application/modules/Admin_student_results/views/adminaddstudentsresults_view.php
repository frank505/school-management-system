<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
              <div class="card">

                                    <div class="card-header"><b>Add 
                                     
                                     <?php foreach ($students_name as $key => $value) {
                                        $students_user_name = $value->username;
                                        $student_id = $value->id;
                                        $student_sub_class = $value->sub_class_name;
                                     }   ?>
                                     
                                 <b class="user_result"><?php echo $students_user_name ?></b>  Results</b>
                                 <input type="hidden" name="" class="student_id" value="<?php echo $student_id;?>">
                                 <input type="hidden" name="" class="student_sub_class_name" value="<?php echo $student_sub_class;?>">
                                 
                                 </div>
                                    <div class="card-body card-block">
                                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                       </button>
                       <strong> <i class="fa fa-warning" aria-hidden="true"></i> please note that any course/subject under any class selected without a topic will 
                       not be displayed. If you find any course already merged to a class that is required here for result 
                       compilation you can either add it by creating another section or go and add a topic 
                       to the course to enable the course to become eligible for result compilation. </strong> 
                     </div>      
                     <script>
                       $(".alert").alert();
                     </script>

                                                 <div class="form-group" style="text-align:center;">

                                                <div class="input-group ">
                                                <select name="select_class" id="classes_area_content" class="form-control">
                                                <option value="">Select A Class</option>
                                                  <?php
                                                  foreach ($classes as $key => $values) {
                                                      $class_name  = $values->class_name;
                                                      echo "<option value='$class_name'>$class_name</option>";
                                                  }
                                                  
                                                  
                                                  
                                                  ?>
                                                        </select>
                                                 &nbsp;&nbsp;&nbsp;
                                                 <select name="select_session" id="sessions_area" class="form-control">
                                                <option value="">Select Session</option>
                                             <?php  foreach ($fetch_all_sessions as $key => $values_session) {
                                                 $sessions_name = $values_session->sessions_name;
                                                 echo "<option value='$sessions_name'>$sessions_name</option>";
                                             } 
                                             ?>
                                                        </select>&nbsp;&nbsp;&nbsp;        
                                                <button type="submit" class="btn btn-primary load_result_sheet"> <i class="fa fa-pencil-square" aria-hidden="true"></i></i>
                                            </button>&nbsp;&nbsp;&nbsp;
                                                                                         </div>
                                            </div>


                     
                                            
                                
               





                                </div>
                


               <div class="content_results">
                
               
               </div><br><br>

							
						</div>
						

					</div>
				
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>

  <div class="fixed-action-btn">
  <button class="btn-floating btn-large red add-color" data-toggle="modal" data-target="#myModal" style="font-weight:bolder;color:white;">
	<i class="fa fa-pencil-square" aria-hidden="true"></i>
						</button>
</div>



<!--MODAL AREA-->
<div id="myModal" class="modal fade" role="dialog" style="display: none;" aria-hidden="true">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header header-content-modal" style="font-weight:bolder;background-color: #007bff;">
      <center><h5><b class="modal-title" style="color:white;font-size:15px;">ADD RESULT</b></h5></center>

        <button type="button" class="close" id="close_me" data-dismiss="modal"><i class="fa fa-close" aria-hidden="true"></i></button>
              </div>
      <div class="modal-body">
       <!-- <div class="notification">
           <center><b>Add New Result </b></center>
       </div> -->
        <form action="" method="post">
           <div class="form-group">
           <select name="select_class" id="student_class_to_attach" class="form-control">
            <option value="">Select A Class</option>
              <?php
              foreach ($classes as $key => $values) {
              $class_name  = $values->class_name;
            echo "<option value='$class_name'>$class_name</option>";
              }                                    
              ?>
                  </select>
           
           </div>

           <div class="form-group">
           <select name="select_session" id="student_session_to_attach" class="form-control">
                <option value="">Select Session</option>
          <?php  foreach ($fetch_all_sessions as $key => $values_session) {
              $sessions_name = $values_session->sessions_name;
              echo "<option value='$sessions_name'>$sessions_name</option>";
                                } 
                            ?>
                     </select>
           </div>
      <div class="form-group">
       <label for="student_result_to_attach" id="file-label" class="form-control btn btn-primary label-file">&nbsp; <i class="fa fa-file-picture-o" aria-hidden="true"></i> PLease Select Student result pdf or ms word file</label>
              <input id="student_result_to_attach" style="display:none;" required="required" class=" file-hide" type="file">        
                                </div>
      <div class="form-group">
     <input class="form-control" required="required" name="" id="student_calendar_year_attach" placeholder="calendar year"  type="text">
        <div class="validation" id="validation_class" style="margin-top:15px;"></div>
            </div>
            
        <div class="form-group">
         <textarea name="" id="student_remark_attach" placeholder="enter a student remarks" class="form-control"></textarea>
         <div class="validation" id="validation_class" style="margin-top:15px;"></div>
        </div>
      </form></div>
      <div class="modal-footer">
          <button class="btn header-bg custom_btn btn-primary" id="add_new_student_result" name="send_new_result" style="font-weight:bolder;color:white;">Save</button>
        <button type="button" class="btn btn-primary header-bg custom_btn" id="data_close" style="font-weight:bolder;color:white;" data-dismiss="modal">Close</button>
      </div>
      
    </div>

  </div>
</div>
<script>
//this function is specific to this page to notify available file formats if the user wants to just
//upload result
  window.addEventListener("load",show_possible_result_methods);
function show_possible_result_methods()
{
 swal("note also that you can add pdf documents or ms word documents as results using the fab button at the bottom right hand of your screen");
}
</script>












