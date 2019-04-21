
<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<!-- BASIC TABLE -->
							<div class="card">

<div class="card-header "><b style="font-size:20px;">Classes</b> <br>
<input id="live_search_class" style="width:60%;margin-left:20%;margin-right:20%;" class="form-control search-me-please" placeholder="🔎" name="" type="text"><br>
</div>
<div class="card-body card-block">
<table class="table  table-striped">
										<thead>
											<tr>
												<th>Class</th>
												<th>Delete</th>
											</tr>
										</thead>
										<tbody id="display_content">

                            <?php foreach ($results as $key => $value) {
							  echo  "<tr> 
								<td>$value->class_name</td>
								<td><button  delete-id='$value->id' class='btn btn-primary delete_class_btn'> <i class='fas fa-trash' aria-hidden='true'></i> </button></td>
							  </tr>";
							}
				                  ?>

										</tbody>
									</table>

</div>
</div>








							<!-- <div class="panel top-campaign" style="background:white;">
							<h4 class="title-3 m-b-30">Students Classes</h4>
					<input id="live_search_class" style="width:60%;margin-left:20%;margin-right:20%;" class="form-control search-me-please" placeholder="🔎" name="" type="text"><br>
								<div class="panel-body table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th>#</th>
												<th>Class</th>
												<th>Delete</th>
											</tr>
										</thead>
										<tbody id="display_content">

                            <?php //foreach ($results as $key => $value) {
							//   echo  "<tr>
							//    <td>$value->id</td> 
							// 	<td>$value->class_name</td>
							// 	<td><button  delete-id='$value->id' class='btn btn-primary delete_class_btn'> <i class='fas fa-trash' aria-hidden='true'></i> </button></td>
							//   </tr>";
							// }
				                  ?>

										</tbody>
									</table>
								</div>
							</div> -->
							<!-- END BASIC TABLE -->
						</div>

<!-- 
						<div class="card">
                                    <div class="card-header">
                                        <strong>Dropdowns</strong> Groups
                                    </div>
                                    <div class="card-body card-block">
                                        <form class="form-horizontal">
                                            <div class="row form-group">
                                                <div class="col col-md-12">
                                                    <div class="input-group">
                                                        <div class="input-group-btn">
                                                            <div class="btn-group">
                                                                <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle btn btn-primary">Dropdown</button>
                                                                <div tabindex="-1" aria-hidden="true" role="menu" class="dropdown-menu">
                                                                    <button type="button" tabindex="0" class="dropdown-item">Action</button>
                                                                    <button type="button" tabindex="0" class="dropdown-item">Another Action</button>
                                                                    <button type="button" tabindex="0" class="dropdown-item">Something else here</button>
                                                                    <div tabindex="-1" class="dropdown-divider"></div>
                                                                    <button type="button" tabindex="0" class="dropdown-item">Separated link</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="text" id="input1-group3" name="input1-group3" placeholder="Username" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-12">
                                                    <div class="input-group">
                                                        <input type="email" id="input2-group3" name="input2-group3" placeholder="Email" class="form-control">
                                                        <div class="input-group-btn">
                                                            <div class="btn-group">
                                                                <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle btn btn-primary">Dropdown</button>
                                                                <div tabindex="-1" aria-hidden="true" role="menu" class="dropdown-menu">
                                                                    <button type="button" tabindex="0" class="dropdown-item">Action</button>
                                                                    <button type="button" tabindex="0" class="dropdown-item">Another Action</button>
                                                                    <button type="button" tabindex="0" class="dropdown-item">Something else here</button>
                                                                    <div tabindex="-1" class="dropdown-divider"></div>
                                                                    <button type="button" tabindex="0" class="dropdown-item">Separated link</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-12">
                                                    <div class="input-group">
                                                        <div class="input-group-btn">
                                                            <div class="btn-group">
                                                                <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle btn btn-primary">Action</button>
                                                                <div tabindex="-1" aria-hidden="true" role="menu" class="dropdown-menu">
                                                                    <button type="button" tabindex="0" class="dropdown-item">Action</button>
                                                                    <button type="button" tabindex="0" class="dropdown-item">Another Action</button>
                                                                    <button type="button" tabindex="0" class="dropdown-item">Something else here</button>
                                                                    <div tabindex="-1" class="dropdown-divider"></div>
                                                                    <button type="button" tabindex="0" class="dropdown-item">Separated link</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="text" id="input3-group3" name="input3-group3" placeholder=".." class="form-control">
                                                        <div class="input-group-btn">
                                                            <div class="btn-group">
                                                                <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle btn btn-primary">Dropdown</button>
                                                                <div tabindex="-1" aria-hidden="true" role="menu" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                                    <button type="button" tabindex="0" class="dropdown-item">Action</button>
                                                                    <button type="button" tabindex="0" class="dropdown-item">Another Action</button>
                                                                    <button type="button" tabindex="0" class="dropdown-item">Something else here</button>
                                                                    <div tabindex="-1" class="dropdown-divider"></div>
                                                                    <button type="button" tabindex="0" class="dropdown-item">Separated link</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Reset
                                        </button>
                                    </div>
                                </div> -->

						 <div class="center-me-btn "><p class="click_link"><?php echo $links; ?></p></div>

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
      <center><h5><b class="modal-title" style="color:white;font-size:15px;">ADD A NEW CLASS</b></h5></center>

        <button type="button" class="close" id="close_me" data-dismiss="modal"><i class="fa fa-close" aria-hidden="true"></i></button>
              </div>
      <div class="modal-body">
       <div class="notification">
           <center><b>Please enter a new class</b></center>
       </div>
        <form action="" method="post">
      <div class="form-group">
     <input class="form-control" required="required" name="" id="class_text_area" placeholder="enter new class" data-rule="minlen:4" data-msg="Please enter at least 4 chars" type="text">
        <div class="validation" id="validation_class" style="margin-top:15px;"></div>
            </div>
                             

      </form></div>
      <div class="modal-footer">
          <button class="btn header-bg custom_btn btn-primary" id="add_class" name="send_content" style="font-weight:bolder;color:white;">Submit</button>
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

  
