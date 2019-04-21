<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<!-- BASIC TABLE -->

							<div class="card">

<div class="card-header "><b style="font-size:20px;">Result Info</b> <br>
<input id="live_search_students_manage_results" style="width:60%;margin-left:20%;margin-right:20%;" class="form-control search-me-please" placeholder="🔎" name="" type="text"><br>
</div>
<div class="card-body card-block panel-body">
<table class="table   table-striped" style="width:100% !important;">
										<thead>
											<tr>
											<th>Name</th>
                                                <th>Class</th>
                                                <th>Sub Class</th>
                                                 <th>image</th>
                                                 <th>Add Results</th>
                                                 <th>View Results</th>
											</tr>
										</thead>
										<tbody id="display_content">

										<?php 
                            foreach ($results as $key => $value) {
                                $file_name = $value->file_name;
                                $base_url = base_url();
                                $id = $value->id;
							  echo  "<tr>
                               <td>$value->username</td>
                               <td>$value->class_name</td>
                               <td>$value->sub_class_name</td>
                               <td><img src='{$base_url}assets/student_image/$file_name' style='width:40px;height:40px;' ></td>
                               <td><a href='{$base_url}Home/Add-Results/$id' class='btn btn-primary'> <i class='fa fa-pencil-square' aria-hidden='true'></i> </a> </td>
                               <td><a href='{$base_url}Home/View-Results/$id' class='btn btn-primary'> <i class='fa fa-eye' aria-hidden='true'></i> </a> </td>
							  </tr>";
							}
				                  ?>
										</tbody>
									</table>

</div>
</div>

							<!-- <div class="panel top-campaign" style="background:white;">
							<h3 class="title-3 m-b-30">Students Information</h3>
					<input id="live_search_students_manage_results" style="width:60%;margin-left:20%;margin-right:20%;" class="form-control search-me-please" placeholder="🔎" name="" type="text"><br>
								<div class="panel-body table-responsive">
									<table class="table">
										<thead>
											<tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Class</th>
                                                <th>Sub Class</th>
                                                 <th>image</th>
                                                 <th>Add Results</th>
                                                 <th>View Results</th>
											</tr>
										</thead>
										<tbody id="display_content">

                            <?php 
                            // foreach ($results as $key => $value) {
                            //     $file_name = $value->file_name;
                            //     $base_url = base_url();
                            //     $id = $value->id;
							//   echo  "<tr>
                            //    <td>$value->id</td> 
                            //    <td>$value->username</td>
                            //    <td>$value->class_name</td>
                            //    <td>$value->sub_class_name</td>
                            //    <td><img src='{$base_url}assets/student_image/$file_name' style='width:40px;height:40px;' ></td>
                            //    <td><a href='{$base_url}Home/Add-Results/$id' class='btn btn-primary'> <i class='fa fa-pencil-square' aria-hidden='true'></i> </a> </td>
                            //    <td><a href='{$base_url}Home/View-Results/$id' class='btn btn-primary'> <i class='fa fa-eye' aria-hidden='true'></i> </a> </td>
							//   </tr>";
							// }
				                  ?>

										</tbody>
									</table>
								</div>
							</div> -->
							<!-- END BASIC TABLE -->
						</div>
						 <div class="center-me-btn "><p class="click_link"><?php   echo $links; ?></p></div>

					</div>
				
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div><br><br>
