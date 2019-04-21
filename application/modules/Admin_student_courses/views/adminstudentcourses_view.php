<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<!-- BASIC TABLE -->
							<div class="panel top-campaign" style="background:white;">
							<h3 class="title-3 m-b-30">Students Courses</h3>
					<input id="live_search_course" style="width:60%;margin-left:20%;margin-right:20%;" class="form-control search-me-please" placeholder="🔎" name="" type="text"><br>
             <div class="response_search "></div> <br>
          				<div class="panel-body table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th>#</th>
												<th>Course Name</th>
												<th>Merge Course</th>
                                                <th>Delete Course</th>
											</tr>
										</thead>
										<tbody id="display_content">
                                        <?php foreach ($results as $key => $value) {
							  echo  "<tr>
							   <td>$value->id</td> 
                                <td>$value->course_name</td>
                                <td><button  merge-course-id='$value->id'  data-toggle='modal' data-target='#myModal2' class='btn btn-primary merge_course_btn'><i class='fa fa-chain' aria-hidden='true'></i></td>
								<td><button  delete-course-id='$value->id' class='btn btn-primary delete_course_btn'> <i class='fas fa-trash' aria-hidden='true'></i> </button></td>
                              </tr>";
                             
							}
				                  ?>
                                  
										</tbody>
									</table>
								</div>
							</div>
							<!-- END BASIC TABLE -->
						</div>
						 <div class="center-me-btn "><p class="click_link"><?php echo $links; ?></p></div>

					</div>
				
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div><br><br>























<div id="myModal2" class="modal fade" role="dialog" style="display: none;" aria-hidden="true">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header header-content-modal" style="font-weight:bolder;background-color: #007bff;">
      <center><h5><b class="modal-title" style="color:white;font-size:15px;">MERGE COURSE/SUBJECT</b></h5></center>

        <button type="button" class="close" id="close_me" data-dismiss="modal"><i class="fa fa-close" aria-hidden="true"></i></button>
              </div>
      <div class="modal-body">
       <div class="notification">
           <center><b>merge course to thier classes </b></center>
       </div>
        <form action="" method="post">
      <div class="form-group">
     <input class="form-control" required="required" name="" id="merge_course_name" placeholder="enter new course/subject" data-rule="minlen:4" data-msg="Please enter at least 4 chars" type="text">
        
            </div>
         <div class="form-group">
           <select class="form-control" name="" id="SelectClass">
             <option>Select Class</option>
             <?php
              foreach ($fetch_classes_for_merge as $key => $value_class) {
                  $class_name = $value_class->class_name;
                  echo "<option value='$class_name'>$class_name</option>";
              }
             
             ?>
           </select><br>
           <div class="validation" id="validation_merge" style="margin-top:15px;"></div>
         </div>
       
      </form></div>
      <div class="modal-footer">
          <button class="btn header-bg custom_btn btn-primary" id="merge_course" name="send_content" style="font-weight:bolder;color:white;">Submit</button>
        <button type="button" class="btn btn-primary header-bg custom_btn" id="data_close" style="font-weight:bolder;color:white;" data-dismiss="modal">Close</button>
      </div>
      
    </div>

  </div>
</div>










<div id="myModal" class="modal fade" role="dialog" style="display: none;" aria-hidden="true">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header header-content-modal" style="font-weight:bolder;background-color: #007bff;">
      <center><h5><b class="modal-title" style="color:white;font-size:15px;">ADD A NEW COURSE/SUBJECT</b></h5></center>

        <button type="button" class="close" id="close_me" data-dismiss="modal"><i class="fa fa-close" aria-hidden="true"></i></button>
              </div>
      <div class="modal-body">
       <div class="notification">
           <center><b>Please enter a new course/subject</b></center>
       </div>
        <form action="" method="post">
      <div class="form-group">
     <input class="form-control" required="required" name="" id="course_name" placeholder="enter new course/subject" data-rule="minlen:4" data-msg="Please enter at least 4 chars" type="text">
        <div class="validation" id="validation_course" style="margin-top:15px;"></div>
            </div>
                             

      </form></div>
      <div class="modal-footer">
          <button class="btn header-bg custom_btn btn-primary" id="add_course" name="send_content" style="font-weight:bolder;color:white;">Submit</button>
        <button type="button" class="btn btn-primary header-bg custom_btn" id="data_close" style="font-weight:bolder;color:white;" data-dismiss="modal">Close</button>
      </div>
      
    </div>

  </div>
</div>






<div class="fixed-action-btn">
  <button class="btn-floating btn-large red add-color" data-toggle="modal" data-target="#myModal" style="font-weight:bolder;color:white;">
	<i class="fa fa-pencil-square" aria-hidden="true"></i>
						</button>
</div>