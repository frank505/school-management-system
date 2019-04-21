
<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<!-- BASIC TABLE -->
							<div class="panel top-campaign" style="background:white;">
							<h3 class="title-3 m-b-30">Students Grades</h3>
				<br>
								<div class="panel-body table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th>#</th>
                                                <th>Score Range</th>
												<th>Grade</th>
												<th>Delete</th>
											</tr>
										</thead>
										<tbody id="display_content">

                            <?php foreach ($results as $key => $value) {
							  echo  "<tr>
							   <td>$value->id</td> 
								<td>$value->first_grade</td>
								<td>$value->second_grade</td>
								<td>$value->grade_letter</td>
								<td><button  delete-id='$value->id' class='btn btn-primary delete_grade_btn'> <i class='fas fa-trash' aria-hidden='true'></i> </button></td>
							  </tr>";
							}
				                  ?>

										</tbody>
									</table>
								</div>
							</div>
							<!-- END BASIC TABLE -->
						</div>
						 <div class="center-me-btn "><p class="click_link"><?php // echo $links; ?></p></div>

					</div>
				
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div><br><br>



















        <div id="myModal" class="modal fade" role="dialog" style="display: none;" aria-hidden="true">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header header-content-modal" style="font-weight:bolder;background-color: #007bff;">
      <center><h5><b class="modal-title" style="color:white;font-size:15px;">ADD A NEW GRADE RANGE</b></h5></center>

        <button type="button" class="close" id="close_me" data-dismiss="modal"><i class="fa fa-close" aria-hidden="true"></i></button>
              </div>
      <div class="modal-body">
       <div class="notification">
           <center><b>Please enter a new Grade Range Details</b></center>
       </div>
        <form action="" method="post">
      <div class="form-group">
     <input class="form-control num_val" required="required" name="" id="grade_one_range" placeholder="enter first score for grade range" data-rule="minlen:4" data-msg="Please enter at least 4 chars" type="text">
        <div class="validation"  style="margin-top:15px;"></div>
            </div>
            <div class="form-group">
     <input class="form-control num_val" required="required" name="" id="grade_two_range" placeholder="enter second score for grade range" data-rule="minlen:4" data-msg="Please enter at least 4 chars" type="text">
        <div class="validation"  style="margin-top:15px;"></div>
            </div>           
             
            <div class="form-group">
     <input class="form-control grade" required="required" name="" id="grade_letter" placeholder="enter grade letter usually a single letter" data-rule="minlen:4" data-msg="Please enter at least 4 chars" type="text">
        <div class="validation" id="validation_class" style="margin-top:15px;"></div>
            </div>

      </form></div>
      <div class="modal-footer">
          <button class="btn header-bg custom_btn btn-primary" id="add_grade_range" name="send_content" style="font-weight:bolder;color:white;">Submit</button>
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

  
