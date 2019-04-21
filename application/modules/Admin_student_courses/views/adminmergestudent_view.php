<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
              <div class="card">

                                    <div class="card-header"><b>Manage Merged Courses</b></div>
                                    <div class="card-body card-block">
                           
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                       </button>
                       <strong> <i class="fa fa-warning" aria-hidden="true"></i> please note that any course/subject under any class selected without a topic will 
                       not be displayed. If you find any course already merged to a class that is required here for result 
                       compilation you can either add it by creating another section or go and add a topic 
                       to the course to enable the course to become eligible for result compilation.This is because results are compiled per session.</strong> 
                     </div>      
                     <script>
                       $(".alert").alert();
                     </script>


                                    <div class="form-group" style="width:100%;" id="response_area">
                                    <b class="show_errors"></b>
                                </div>
                                   <br><br>
                                  <div class="form-group" style="text-align:center;">
                                                <div class="input-group ">
                                           <input type="hidden" class="hidden_class" name="" id="hidden_class">     
                                                 &nbsp;&nbsp;&nbsp;
                                         <select name="" id="classes_area_content" class="form-control">
                                                <option value="">Select Class</option>

                                                <?php
                                                foreach ($fetch_classes_for_merge as $key => $value) {
                                                   $class_name = $value->class_name;
                                                   echo "<option value='$class_name'>$class_name</option>";
                                                }
                                                ?>
                                                </select> &nbsp;&nbsp;&nbsp;
                                                <button type="button" class="btn btn-primary search_btn_merge_cont"><i class="zmdi zmdi-search"></i>
                                            </button>&nbsp;&nbsp;&nbsp;
                                                
                                            &nbsp;&nbsp;&nbsp;
                                                

&nbsp;&nbsp;<button type="button"class="btn btn-primary check_all_merged_searched" title="check all merged course searched" ><i class="fa fa-check-square"></i></button>
&nbsp;&nbsp;<button  type="button" class="btn btn-primary delete_students_checked" title="delete all checked merged courses"><i class="fas fa-trash    "></i></button>
                                            
                                                </div>
                                            </div>

                                            
                                
                                        </form>
                                    </div>



                 <div class="panel-body table-responsive">
									<table class="table">
                                    <thead>
											<tr>
                                                <th>#</th>
                                                <th>Subject/Course</th>
                                                <th>Add Topic</th>
                                                <th>View Scheme Of Work</th>
                                                 <th>Check Subject/Course</th>
                                                 
											</tr>
										</thead>
										<tbody id="display_content">

                          
										</tbody>
									</table>
								</div> 
                                </div>							
						</div>
						

					</div>
				
				</div>
			</div>


  

  <div id="myModal" class="modal fade" role="dialog" style="display: none;" aria-hidden="true">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header header-content-modal" style="font-weight:bolder;background-color: #007bff;">
      <center><h5><b class="modal-title" style="color:white;font-size:15px;">ADD A NEW TOPIC FOR SCHEME OF WORK</b></h5></center>

        <button type="button" class="close" id="close_me" data-dismiss="modal"><i class="fa fa-close" aria-hidden="true"></i></button>
              </div>
      <div class="modal-body">
       <div class="notification">
           <center><b>Please enter a new Topic</b></center>
       </div><br>
        <form action="" method="post">
      <div class="form-group">
     <input class="form-control" required="required" name="" id="topic_name" placeholder="enter new topic name here" data-rule="minlen:4" data-msg="Please enter at least 4 chars" type="text">
        <div class="validation" id="validation_course" style="margin-top:15px;"></div>
            </div>
          <div class="form-group">
           
            <select class="form-control" name="" id="session_name">
              <option>Select A Session</option>
              <?php
              foreach ($fetch_all_sessions as $key => $value_session) {
                 $student_sessions = $value_session->sessions_name;
                 echo"<option value='$student_sessions'>$student_sessions</option>";
              }
              
              ?>
                </select>
          </div>
           <div class="form-group">
             <input type="text" disabled="disabled" class="form-control" name="" id="course_name_for_add_topic"  placeholder="">
           </div>
           <div class="form-group">
             <input type="text" class="form-control" disabled="disabled" name="" id="class_name_for_add_topic"  placeholder="">
           </div> 
      </form></div>
      <div class="modal-footer">
          <button class="btn header-bg custom_btn btn-primary" id="add_topic" name="send_content" style="font-weight:bolder;color:white;">Submit</button>
        <button type="button" class="btn btn-primary header-bg custom_btn" id="data_close" style="font-weight:bolder;color:white;" data-dismiss="modal">Close</button>
      </div>
      
    </div>

  </div>
</div>


 <div id="myModal2" class="modal fade" role="dialog" style="display: none;" aria-hidden="true">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" >
      <div class="modal-header header-content-modal" style="font-weight:bolder;background-color: #007bff;">
      <center><h5><b class="modal-title  modal-contents" style="color:white;font-size:15px;">Manage Topics Under This Course</b></h5></center>

        <button type="button" class="close" id="close_me" data-dismiss="modal"><i class="fa fa-close" aria-hidden="true"></i></button>
              </div>
      <div class="modal-body" style="max-height:300px;overflow:auto;" id="modal_body_display">
      
     
       </div>
    </div>

  </div>
</div>
			<!-- END MAIN CONTENT -->
		</div>
