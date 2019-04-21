/*THIS FILE WAS WRITTEN BY AKPU FRANKLIN CHIMAOBI*/
/*
     * THIS ADDS A NEW CLASS
     * ========================================================================
     */
$("#add_class").on("click", function () {
  var this_btn = this;
  $category = $("#class_text_area").val();
  this_btn.disabled = "true";
  $(".validation").html("<center class='alert alert-danger'><b>Loading...</b></center>")
  $.ajax({
    type: "POST",
    url: global_url + "admin_classes/add",
    data: "class=" + $category,
    success: function (response) {
      $(".validation").html("<center class='alert alert-danger'><b><i class='fa fa-warning' aria-hidden='true'></i>" + response + "</b></center>");
      this_btn.disabled = false;
    },

  });
})

/*
    * THIS BUTTON IS TO DELETE A CLASS
    * ========================================================================
    */

$(document).on("click", ".delete_class_btn", function () {
  swal("Are You sure you want to delete this class? note that any class deleted automatically all sub classes under it", {
    buttons: {
      Yes: {
        text: "yes",
        value: "Yes",
      },
      No: {
        text: "no",
        value: "No",
      },
      cancel: "cancel",
    },
  })
    .then((value) => {
      switch (value) {
        case "Yes":
          var id_delete = this.getAttribute("delete-id");
          $.ajax({
            type: "GET",
            url: global_url + "admin_classes/delete_classes?id=" + id_delete,
            success: function (response) {
              swal(response);
              setTimeout(() => {
                document.location.reload(true);
              }, 2000);

            }
          });
          break;

        case "No":

          break;

        default:

      }
    });

})


/*
* THIS FUNCTION IS TO SEARCH FOR A CLASS
* ===============================================================================
*/
$("#live_search_class").on("keyup", function () {
  $val = $(this).val();
  $.ajax({
    type: "GET",
    url: global_url + "admin_classes/search_class?search=" + $val,
    success: function (response) {
      var response_text = JSON.parse(response);
      var myObj = response_text.results;
      var value;
      var display_content = document.querySelector("#display_content");
      display_content.innerHTML = "";
      for (var index = 0; index < myObj.length; index++) {
        var index_elem = myObj[index];
        value = "<tr>";
        value += "<td>" + index_elem.id + "</td>";
        value += "<td>" + index_elem.class_name + "</td>";
        value += "<td><button class='btn btn-primary delete_class_btn'  id='" + index_elem.id + "' delete-id='" + index_elem.id + "'><i class='fas fa-trash'></i></button></td>";
        value += "</tr>";
        console.log(value);
        display_content.innerHTML += value;
      }

    }
  });
});

/*
     * THIS IS TO ADD A SUBCLASS
     * ========================================================================
     */

$("#add_sub_class").on("click", function () {
  var this_btn = this;
  this_btn.disabled = "true";
  $validation = $("#sub_validation_class");
  var select_comp = document.querySelector("#content_class");
  var selected_text = select_comp.options[select_comp.selectedIndex].text;
  $sub_class_text_area = $("#sub_class_text_area");
  var form_data_add = new FormData();
  form_data_add.append("class", selected_text);
  form_data_add.append("sub_class", $sub_class_text_area.val());
  $validation.html("<center class='alert alert-danger'><b>Loading...</b></center>");
  $.ajax({
    type: "POST",
    url: global_url + "admin_sub_classes/add_sub_classes",
    data: form_data_add,
    processData: false,
    contentType: false,
    success: function (response) {
      $validation.html("<center class='alert alert-danger'><b>" + response + "</b></center>");
      this_btn.disabled = false;
    }
  });
});

/*
       * THIS BUTTON IS TO DELETE A SUB CLASS
       * ========================================================================
       */
$(document).on("click", ".delete_sub_class_btn", function () {
  swal("Are You sure you want to delete this sub class?", {
    buttons: {
      Yes: {
        text: "yes",
        value: "Yes",
      },
      No: {
        text: "no",
        value: "No",
      },
      cancel: "cancel",
    },
  }).then((value) => {
    switch (value) {
      case "Yes":
        var id_delete = this.getAttribute("delete-id");
        $.ajax({
          type: "GET",
          url: global_url + "admin_sub_classes/delete_sub_classes?id=" + id_delete,
          success: function (response) {
            swal(response);
            setTimeout(() => {
              document.location.reload(true);
            }, 2000);
          }
        });
        break;

      case "No":


        break;

      default:

    }
  });
})



/*
* THIS FUNCTION IS TO SEARCH FOR A SUB CLASS
* ===============================================================================
*/
$("#live_search_sub_class").on("keyup", function () {
  $val = $(this).val();
  $.ajax({
    type: "GET",
    url: global_url + "admin_sub_classes/search_sub_class?search=" + $val,
    success: function (response) {
      var response_text = JSON.parse(response);
      var myObj = response_text.results;
      var value;
      var display_content = document.querySelector("#display_content");
      display_content.innerHTML = "";
      for (var index = 0; index < myObj.length; index++) {
        var index_elem = myObj[index];
        value = "<tr>";
        value += "<td>" + index_elem.id + "</td>";
        value += "<td>" + index_elem.sub_class_name + "</td>";
        value += "<td>" + index_elem.class_name + "</td>";
        value += "<td><button class='btn btn-primary delete_sub_class_btn'  id='" + index_elem.id + "' delete-id='" + index_elem.id + "'><i class='fas fa-trash'></i></button></td>";
        value += "</tr>";
        display_content.innerHTML += value;
      }

    }
  });
});

/*
     * THIS IS FOR THE TABS IN THE adminsettings  FOR CHANGING THE ACTIVE CLASS
     * ========================================================================
     */
var btn_personal = document.querySelectorAll(".btn-personal");
if (btn_personal !== null) {
  for (let index = 0; index < btn_personal.length; index++) {
    btn_personal[index].addEventListener("click", change_me);
  }
}
function change_me() {
  var t_row_display = document.querySelector(".t-row-display");
  var btn_personal_change = document.querySelectorAll(".btn-personal");
  for (let index = 0; index < btn_personal.length; index++) {
    btn_personal_change[index].classList.remove("active-btn");
  }
  this.classList.add("active-btn");
}

/*
   * THIS IS TO HIDE AND SHOW EACH TABS
   * ========================================================================
   */
$(".total").on("click", function () {
  var this_dt = this;
  var hide_area = document.querySelectorAll(".hide-area");
  hide_area.forEach(function (value, index) {
    var attribute = value.getAttribute("data-id");
    var attr_this = this_dt.getAttribute("id");
    if (attr_this == attribute) {
      value.style.display = "block";
    } else {
      value.style.display = "none";
    }
  });
});

/*
 * THIS WILL ADD A NEW ADMIN IN THE ADMIN SECTION
 * ========================================================================
 */
$("#btn-add-admin").on("click", function () {
  $username = $("#add_username").val();
  $email = $("#add_email").val();
  $password = $("#add_password").val();
  $confirm = $("#add_confirm").val();
  var form_data = new FormData();
  form_data.append("username", $username);
  form_data.append("email", $email);
  form_data.append("password", $password);
  form_data.append("confirm", $confirm);
  $("#sent_indicator_additional").html("<center class='alert alert-danger'><b>Loading...</b></center>");
  $.ajax({
    type: "POST",
    url: global_url + "adminsettings/add_new_admin",
    data: form_data,
    processData: false,
    contentType: false,
    success: function (response) {
      $("#sent_indicator_additional").html("<center class='alert alert-danger'><b>" + response + "</b></center>");
    }
  });
})

/*
     * THIS WILL CLEAR ADD ADMIN TAB VALUES
     * ========================================================================
     */
$("#btn-clear-admin").on("click", function () {
  $("#add_username").val("");
  $("#add_email").val("");
  $("#add_password").val("");
  $("#add_confirm").val("");

});

/*
     * THIS WILL UPDATE ADMIN DETAILS
     * ========================================================================
     */
$("#update-admin").on("click", function () {
  $username = $("#update_username").val();
  $email = $("#update_email").val();
  $password = $("#update_password").val();
  $confirm = $("#update_confirm").val();
  var form_data = new FormData();
  form_data.append("username", $username);
  form_data.append("email", $email);
  form_data.append("password", $password);
  form_data.append("confirm", $confirm);
  $("#sent_indicator_update").html("<center class='alert alert-danger'><b>Loading...</b></center>");
  $.ajax({
    type: "POST",
    url: global_url + "adminsettings/update_admin_profile",
    data: form_data,
    processData: false,
    contentType: false,
    success: function (response) {
      $("#sent_indicator_update").html("<center class='alert alert-danger'><b>" + response + "</b></center>");
    }
  });
})

/*
    * FETCH SUB CLASS FROM CLASS SELECTED
    * ========================================================================
    */
$("#classes_area").on("change", function () {
  var selected_content = this.options[this.selectedIndex].text;
  //this will remove the sub class content in other to avoid appending data to the same previously available sub class content
  var sub_class_content = document.querySelector("#sub_class_content");
  if (sub_class_content !== null) {
    let option_clear = sub_class_content.querySelectorAll("option");
    for (let index = 0; index < option_clear.length; index++) {
      sub_class_content.remove(option_clear[index]);
    }
  }


  if (selected_content == "") {

  } else if (selected_content == "Select A Class") {

  } else {
    $.ajax({
      type: "GET",
      url: global_url + "admin_student_details/load_sub_class?content=" + selected_content,
      success: function (response) {
        var response_text = JSON.parse(response);
        for (let index = 0; index < response_text.length; index++) {
          let sub_class_response = response_text[index].sub_class_name;
          var option = document.createElement("option");
          option.innerHTML = "" + sub_class_response + "";
          sub_class_content.appendChild(option);

        }
      }
    });
  }
})

/*
    * ADD BOOTSTRAP MODAL ATTRIBUTES ON MOUSE FOCUS
    * ========================================================================
    */
$("#password_new_student").on("focus", function () {
  if (this.value == "") {
    $(this).attr("data-toggle", "modal");
    $(this).attr("data-target", "#myModal");
  } else {
    $(this).attr("data-toggle", "");
    $(this).attr("data-target", "");
  }

});
/*
   * GENERATE A RANDOM PASSWORD
   * ========================================================================
   */
function generatePassword() {
  var length = 10,
    charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
    retVal = "";
  for (var i = 0, n = charset.length; i < length; ++i) {
    retVal += charset.charAt(Math.floor(Math.random() * n));
  }
  return retVal;
}
/*
     * STORE PASSWORD GENERATED IN A TEXT INPUT
     * ========================================================================
     */
$("#generate_password").on("click", function () {
  $password = generatePassword();
  $("#password_generate").val($password);
})
/*
   * SET PASSWORD TO THE PASSWORD FIELD THAT USER IS REGISTERING FOR
   * ========================================================================
   */
$("#set_password").on("click", function () {
  $generated_password = $("#password_generate").val();
  $password_student = $("#password_new_student");
  if ($generated_password == "") {
    swal("generate a password first");
  } else {
    $password_student.val($generated_password);
    swal("password added successfully");
  }
});

/*
 * THIS ADDS A NEW STUDENT
 * ========================================================================
 */
$("#add_new_student").on("click", function () {
  $("#response_area").html("<b class='alert alert-danger form-control' style='width:100%;'>loading...</b>");
  $username = $("#username").val();
  $password_student = $("#password_new_student").val();
  $year = $("#date_of_birth").val();
  var sex_value = document.querySelector("#sex");
  var sex = sex_value.options[sex_value.selectedIndex].text;
  var class_content = document.querySelector("#classes_area");
  var file_content = document.querySelector("#file-content");
  console.log(class_content);
  var class_cont = class_content.options[class_content.selectedIndex].text;
  var sub_class_content = document.querySelector("#sub_class_content");
  var sub_class = sub_class_content.options[sub_class_content.selectedIndex].text;
  var form_data = new FormData();
  form_data.append("username", $username);
  form_data.append("password", $password_student);
  form_data.append("date_of_birth", $year);
  form_data.append("sex", sex);
  form_data.append("class", class_cont);
  form_data.append("sub_class", sub_class);
  form_data.append("image", file_content.files[0]);
  $.ajax({
    type: "POST",
    url: global_url + "admin_student_details/add_students",
    processData: false,
    contentType: false,
    data: form_data,
    success: function (response) {
      $("#response_area").html("<b class='alert alert-danger form-control' style='width:100%;'>" + response + "</b>");
    }
  });
})
/*
   * THIS CLEARS THE ADD STUDENTS SECTION
   * ========================================================================
   */
$("#btn-clear-new-student-form").on("click", function () {
  $username = $("#username").val("");
  $password_student = $("#password_new_student").val("");
  $year = $("#date_of_birth").val("");
  $("#sex").val("");
  $("#classes_area").val("");
  ("#sub_class_content").val("");
})

/**
 * this searches for a student and returns the vaue which with a button for pagination
 */
$("#live_search_students").on("keyup", function () {
  var wrapper = document.querySelector(".panel-body");
  var display_contents = document.querySelector("#display_content");
  btn_to_remove = wrapper.querySelector(".btn_more");
  $val = $(this).val();
  if (btn_to_remove !== null) {
    if ($val == "") {
      display_contents.removeChild(btn_to_remove);
    }
  }
  $.ajax({
    type: "GET",
    url: global_url + "admin_student_details/search_students?search=" + $val,
    success: function (response) {
      var response_text = JSON.parse(response);
      var myObj = response_text.results;
      var value;
      var display_content = document.querySelector("#display_content");
      display_content.innerHTML = "";
      for (var index = 0; index < myObj.length; index++) {
        var index_elem = myObj[index];
        value = "<tr>";
        value += "<td>" + index_elem.id + "</td>";
        value += "<td>" + index_elem.username + "</td>";
        value += "<td>" + index_elem.class_name + "</td>";
        value += "<td>" + index_elem.sub_class_name + "</td>";
        value += "<td><img src='" + global_url + "assets/student_image/" + index_elem.file_name + "' style='width:40px;height=40px;'/></td>";
        value += "<td><a href='" + global_url + "Home/Update-Student/" + index_elem.id + "' class='btn btn-primary'><i class='fa fa-pencil-square'></i></a></td>";
        value += "<td><a href='" + global_url + "Home/View-Profile/" + index_elem.id + "' class='btn btn-primary'><i class='fa fa-eye'></i></a></td>";
        value += "<td><button class='btn btn-primary delete_student_btn'  id='" + index_elem.id + "' delete-id='" + index_elem.id + "'><i class='fas fa-trash'></i></button></td>";
        value += "</tr>";
        display_content.innerHTML += value;
      }
      var wrapper = document.querySelector(".panel-body"); /*had to declare a second time to avoid any undefined error 
         plus i also want to avoid the global scope error*/
      if (myObj.length !== 5) {
        //do nothing
        if (btn_to_remove !== null) {
          if ($val == "") {
            display_contents.removeChild(btn_to_remove);
          }
        }
      } else {
        display_content.innerHTML += "<tr><button class='btn btn-primary btn_more'  id='" + index_elem.id + "'>more<i class='fa fa-hand-o-down' aria-hidden='true'></i></button></tr>";
      }
    }
  });
});



$(document).on("click", ".btn_more", function () {
  var $id = $(this).attr("id");
  $val = $("#live_search_students").val();
  this.parentNode.removeChild(this);
  var display_content = document.querySelector("#display_content");
  $.ajax({
    type: "GET",
    url: global_url + "admin_student_details/load_more_student_search?search=" + $val + "&id=" + $id,
    success: function (response) {
      var response_text = JSON.parse(response);
      var myObj = response_text.results;
      var value;
      display_content.innerHTML = "";
      for (var index = 0; index < myObj.length; index++) {
        var index_elem = myObj[index];
        value = "<tr>";
        value += "<td>" + index_elem.id + "</td>";
        value += "<td>" + index_elem.username + "</td>";
        value += "<td>" + index_elem.class_name + "</td>";
        value += "<td>" + index_elem.sub_class_name + "</td>";
        value += "<td><img src='" + global_url + "assets/student_image/" + index_elem.file_name + "' style='width:40px;height=40px;'/></td>";
        value += "<td><a href='" + global_url + "Home/Update-Student/" + index_elem.id + "' class='btn btn-primary'><i class='fa fa-pencil-square'></i></a></td>";
        value += "<td><a href='" + global_url + "Home/View-Profile/" + index_elem.id + "' class='btn btn-primary'><i class='fa fa-eye'></i></a></td>";
        value += "<td><button class='btn btn-primary delete_student_btn'  id='" + index_elem.id + "' delete-id='" + index_elem.id + "'><i class='fas fa-trash'></i></button></td>";
        value += "</tr>";
        display_content.innerHTML += value;
      }
      if (index_elem.id == 1) {

      } else {
        display_content.innerHTML += "<tr><button class='btn btn-primary btn_more'  id='" + index_elem.id + "'>more<i class='fa fa-hand-o-down' aria-hidden='true'></i></button></tr>";
      }


    }

  });

})




$(document).on("click", ".delete_student_btn", function () {
  swal("Are You sure you want to delete this student details?", {
    buttons: {
      Yes: {
        text: "yes",
        value: "Yes",
      },
      No: {
        text: "no",
        value: "No",
      },
      cancel: "cancel",
    },
  }).then((value) => {
    switch (value) {
      case "Yes":
        var id_delete = this.getAttribute("delete-id");
        $.ajax({
          type: "GET",
          url: global_url + "admin_student_details/delete_student?id=" + id_delete,
          success: function (response) {
            swal(response);
            setTimeout(() => {
              document.location.reload(true);
            }, 2000);
          }
        });
        break;

      case "No":


        break;

      default:

    }
  });
});

/*
     * THIS ADDS A NEW STUDENT
     * ========================================================================
     */
$("#update_new_student").on("click", function () {
  $("#response_area").html("<b class='alert alert-danger form-control' style='width:100%;'>loading...</b>");
  $username = $("#username").val();
  $user_id = $("#hidden_id").val();
  var graduate_value = document.querySelector("#graduate");
  var graduate = graduate_value.options[graduate_value.selectedIndex].text;
  var class_content = document.querySelector("#classes_area");
  var class_cont = class_content.options[class_content.selectedIndex].text;
  var sub_class_content = document.querySelector("#sub_class_content");
  var sub_class = sub_class_content.options[sub_class_content.selectedIndex].text;
  var form_data = new FormData();
  form_data.append("username", $username);
  form_data.append("graduate", graduate);
  form_data.append("class", class_cont);
  form_data.append("sub_class", sub_class);
  form_data.append("id", $user_id);
  $.ajax({
    type: "POST",
    url: global_url + "admin_student_details/update_students_details",
    processData: false,
    contentType: false,
    data: form_data,
    success: function (response) {
      $("#response_area").html("<b class='alert alert-danger form-control' style='width:100%;'>" + response + "</b>");
    }
  });
})
/*
    * CHECK AND UNCHECK STUDENTS TO BE PROMOTED TO CLASSES OR DOWNGRADED
    * ========================================================================
    */

$(".check_all_students_searched").on("click", function () {
  var check_comments = document.querySelectorAll(".check-me");
  for (let index = 0; index < check_comments.length; index++) {
    if (!(check_comments[index].checked)) {
      check_comments[index].checked = true;
    } else if (check_comments[index].checked) {
      check_comments[index].checked = false;
    }
  }
});

/*
    * SEND HTTP REQUEST TO UPDATE CHECKED STUDENTS CLASSES
    * ========================================================================
    */

$(".update_checked_students").on("click", function () {
  $select_search = $(".select_class_to_update").val();
  var form_data_send = new FormData();
  if ($select_search == "") {
    swal("please select a class to be upgraded to");
  } else {
    var check_comments = document.querySelectorAll(".check-me");
    for (let index = 0; index < check_comments.length; index++) {
      if (check_comments[index].checked == true) {
        var id = check_comments[index].getAttribute("id");
        form_data_send.append("select_search", $select_search);
        form_data_send.append("id", id);
        $.ajax({
          type: "POST",
          url: global_url + "admin_student_details/upgrade_student_class",
          processData: false,
          contentType: false,
          data: form_data_send,
          success: function (response) {
            //  $("#response_area").html("<b class='alert alert-danger form-control' style='width:100%;'>"+response+"</b>");
            if (response == "student update succesfully") {
              swal(response)
              setTimeout(() => {
                document.location.reload(true);
              }, 200);

            } else {
              swal(response);
            }
          }
        });

      } else {
        var elem = document.querySelector("#display_content");
        //perform dom manipulation to get the class name so as to update them all
        var elem_to_be_updated = elem.querySelector("tr").querySelector("td").nextElementSibling.nextElementSibling.innerHTML;

        swal("Are You sure you want to upgrade all students in " + elem_to_be_updated + " to " + $select_search + "?", {
          buttons: {
            Yes: {
              text: "yes",
              value: "Yes",
            },
            No: {
              text: "no",
              value: "No",
            },
            cancel: "cancel",
          },
        }).then((value) => {
          switch (value) {
            case "Yes":
              $.ajax({
                type: "GET",
                url: global_url + "admin_student_details/upgrade_all_students_class?upgrade_from=" + elem_to_be_updated + "&upgrade_to=" + $select_search,
                success: function (response) {
                  if (response == "all students in " + elem_to_be_updated + " have been successfully upgraded to " + $select_search + "") {
                    swal(response);
                    setTimeout(() => {
                      document.location.reload(true);
                    }, 2000);
                  } else {
                    swal(response);
                  }

                }
              });
              break;

            case "No":
              swal("if you want to upgrade a particular student then please use the search bar to search for specific student and then check the checkbox before clicking on the upgrade button or if you want to update only students on the current page the simply click on the checkbox before clicking the upgrade button ");

              break;

            default:

          }
        });

      }
    }

  }

});
/**
 * this function searches for a student in admin_student_details controller with the function search_specific_class
 */

/**
 * for future versions of this web application the student_search_upgrade_class section will definitely need to be paginated 
 */
$("#student_search_upgrade_class").on("keyup", function () {
  $search_val = $(this).val();
  if ($search_val == "") {

  } else {
    $.ajax({
      type: "GET",
      url: global_url + "admin_student_details/search_specific_student_name?search_name=" + $search_val,
      success: function (response) {
        response_error = JSON.parse(response);
        if (response_error.hasOwnProperty("no_content")) {
          swal(response_error.no_content);
        } else {
          var response_text = JSON.parse(response);
          var myObj = response_text;
          var value;
          display_content.innerHTML = "";
          for (var index = 0; index < myObj.length; index++) {
            var index_elem = myObj[index];
            value = "<tr>";
            value += "<td>" + index_elem.id + "</td>";
            value += "<td>" + index_elem.username + "</td>";
            value += "<td>" + index_elem.class_name + "</td>";
            value += "<td>" + index_elem.sub_class_name + "</td>";
            value += "<td><img src='" + global_url + "assets/student_image/" + index_elem.file_name + "' style='width:40px;height:40px;'/></td>";
            value += "<td><input type='checkbox' name='' class='check-me' id='" + index_elem.id + "'></td>";
            value += "</tr>";
            display_content.innerHTML += value;
          }
        }
      }
    });
  }
})
/**
 * this sends an ajax request to add a new course
 */
$("#add_course").on("click", function () {
  var this_btn = this;
  $course_name = $("#course_name").val();
  this_btn.disabled = "true";
  $("#validation_course").html("<center class='alert alert-danger'><b>Loading...</b></center>")
  $.ajax({
    type: "POST",
    url: global_url + "admin_student_courses/add_course",
    data: "course_name=" + $course_name,
    success: function (response) {
      $("#validation_course").html("<center class='alert alert-danger'><b><i class='fa fa-warning' aria-hidden='true'></i>" + response + "</b></center>");
      this_btn.disabled = false;
    },

  });
});
/**
 * basically this deletes a course in the home/student-course view 
 */
$(document).on("click", ".delete_course_btn", function () {
  swal("Are You sure you want to delete this course? note that any course deleted automatically will delete all merges with any class", {
    buttons: {
      Yes: {
        text: "yes",
        value: "Yes",
      },
      No: {
        text: "no",
        value: "No",
      },
      cancel: "cancel",
    },
  })
    .then((value) => {
      switch (value) {
        case "Yes":
          var id_delete = this.getAttribute("delete-course-id");
          $.ajax({
            type: "GET",
            url: global_url + "admin_student_courses/delete_course?id=" + id_delete,
            success: function (response) {
              swal(response);
              setTimeout(() => {
                document.location.reload(true);
              }, 2000);
            }
          });
          break;

        case "No":

          break;

        default:

      }
    });
})
/**
 * this function searches for courses in the home/Student-Course view
 */
$("#live_search_course").on("keyup", function () {
  $val = $(this).val();
  $.ajax({
    type: "GET",
    url: global_url + "admin_student_courses/search_course?search=" + $val,
    success: function (response) {
      var response_text = JSON.parse(response);
      if (response_text.hasOwnProperty("content_error")) {
        $(".response_search").html("<b class='alert alert-danger form-control' style='text-align:center;width:100%;'><i class='fa fa-exclamation-circle' aria-hidden='true'></i>   " + response_text.content_error + "</b>");
      } else {
        $(".response_search").html("");
        var myObj = response_text;
        var value;
        var display_content = document.querySelector("#display_content");
        display_content.innerHTML = "";
        for (var index = 0; index < myObj.length; index++) {
          var index_elem = myObj[index];
          value = "<tr>";
          value += "<td>" + index_elem.id + "</td>";
          value += "<td>" + index_elem.course_name + "</td>";
          value += "<td><button class='btn btn-primary merge_course_btn' data-toggle='modal' data-target='#myModal2' id='" + index_elem.id + "' merge-course-id='" + index_elem.id + "'><i class='fas fa-chain'></i></button></td>";
          value += "<td><button class='btn btn-primary delete_course_btn'  id='" + index_elem.id + "' delete-course-id='" + index_elem.id + "'><i class='fas fa-trash'></i></button></td>";
          value += "</tr>";
          display_content.innerHTML += value;
        }

      }
      console.log(response)
    }
  });
});

/*
   * THIS ADDS A NEW SESSION
   * ========================================================================
   */
$("#add_sessions").on("click", function () {
  var this_btn = this;
  $category = $("#sessions_text_area").val();
  this_btn.disabled = "true";
  $(".validation").html("<center class='alert alert-danger'><b>Loading...</b></center>")
  $.ajax({
    type: "POST",
    url: global_url + "admin_student_courses/add_sessions",
    data: "sessions=" + $category,
    success: function (response) {
      $(".validation").html("<center class='alert alert-danger'><b><i class='fa fa-warning' aria-hidden='true'></i>" + response + "</b></center>");
      this_btn.disabled = false;
    },

  });
})

/*
    * THIS BUTTON IS TO DELETE A CLASS
    * ========================================================================
    */

$(document).on("click", ".delete_sessions_btn", function () {
  swal("Are You sure you want to delete this session? note that any topic placed under this session will also be deleted too", {
    buttons: {
      Yes: {
        text: "yes",
        value: "Yes",
      },
      No: {
        text: "no",
        value: "No",
      },
      cancel: "cancel",
    },
  })
    .then((value) => {
      switch (value) {
        case "Yes":
          var id_delete = this.getAttribute("delete-id");
          $.ajax({
            type: "GET",
            url: global_url + "admin_student_courses/delete_sessions?id=" + id_delete,
            success: function (response) {
              swal(response);
              setTimeout(() => {
                document.location.reload(true);
              }, 2000);
            }
          });
          break;

        case "No":

          break;

        default:

      }
    });

})


/*
* THIS FUNCTION IS TO SEARCH FOR A SESSIONS
* ===============================================================================
*/
$("#live_search_sessions").on("keyup", function () {
  $val = $(this).val();
  $.ajax({
    type: "GET",
    url: global_url + "admin_student_courses/search_sessions?search=" + $val,
    success: function (response) {
      var response_text = JSON.parse(response);
      var myObj = response_text.results;
      var value;
      var display_content = document.querySelector("#display_content");
      display_content.innerHTML = "";
      for (var index = 0; index < myObj.length; index++) {
        var index_elem = myObj[index];
        value = "<tr>";
        value += "<td>" + index_elem.id + "</td>";
        value+="<td>"+index_elem.sessions_name+"</td>";
        value += "<td><button  delete-id='"+index_elem.id+"' class='btn btn-primary delete_sessions_btn'> <i class='fas fa-trash' aria-hidden='true'></i> </button></td>";
        value += "</tr>";
        console.log(value);
        display_content.innerHTML += value;
      }
    }
  });
});

/**
 * this function fetches course name based on the id supplied to it
 */
$(document).on("click", ".merge_course_btn", function () {
  $(".animation-ajax-loader").show();
  $.ajax({
    type: "method",
    url: global_url + "admin_student_courses/fetch_course_name_for_merging?id=" + $(this).attr("merge-course-id"),
    success: function (response) {
      $("#merge_course_name").val("" + response + "");
      $(".animation-ajax-loader").fadeOut();
    }
  });
});

$(document).on("click", "#merge_course", function () {
  var this_btn = this;
  $input_val = $("#merge_course_name").val();
  $select_class = $("#SelectClass").val();
  $validation = $("#validation_merge");
  var form_data = new FormData();
  form_data.append("course_name", $input_val);
  form_data.append("class_name", $select_class);
  $validation.html("<center class='alert alert-danger'><b>Loading...</b></center>");
  $.ajax({
    type: "POST",
    url: global_url + "admin_student_courses/add_new_merge",
    data: form_data,
    processData: false,
    contentType: false,
    success: function (response) {
      $validation.html("<center class='alert alert-danger'><b>" + response + "</b></center>");
      this_btn.disabled = false

    }
  });

})

$(".search_btn_merge_cont").on("click", function () {
  var this_btn = this;
  $classes_area = $("#classes_area_content").val();
  var display_content = document.querySelector("#display_content");
  if ($classes_area == "") {
    swal("please select a class before searching for merged courses");
  } else {
    this_btn.disabled="true";
    display_content.innerHTML = "<center><b>please wait while courses merged for this class loads....</b></center>";
    $.ajax({
      type: "GET",
      url: global_url + "admin_student_courses/search_for_merged_courses?class_name=" + $classes_area,
      success: function (response) {
        $("#hidden_class").val($classes_area);
        response_text = JSON.parse(response);
        if (response_text.hasOwnProperty("content_error")) {
          display_content.innerHTML = "";
          swal(response_text.content_error);
          this_btn.disabled=false;
        } else {
          var myObj = response_text;
          var value;
          display_content.innerHTML = "";
          for (var index = 0; index < myObj.length; index++) {
            var index_elem = myObj[index];
            value = "<tr>";
            value += "<td>" + index_elem.id + "</td>";
            value += "<td class='course_name_cont_use'>" + index_elem.course_name + "</td>";
            value += "<td><button  data-toggle='modal' data-target='#myModal' class='btn btn-primary add_topic' id-add-topic='" + index_elem.id + "' ><i class='fa fa-pencil-square' aria-hidden='true'></i> </button></td>";
            value += "<td><button id-topic-class-name='"+index_elem.class_name+"' id-topic-course-name='"+index_elem.course_name+"' class='btn btn-primary load-topics-according-to-class' data-target='#myModal2' data-toggle='modal'><i class='fas fa-eye' ></i></button></td>";
            value += "<td><input type='checkbox' name='check_merge[]' class='check_me_merge' id-merge-check='" + index_elem.id + "'/></td>";
            value += "</tr>";
            display_content.innerHTML += value;
            this_btn.disabled=false;
          }
        }
      }
    });
  }
});

/*
  * CHECK AND UNCHECK STUDENTS TO BE PROMOTED TO CLASSES OR DOWNGRADED
  * ========================================================================
  */

$(".check_all_merged_searched").on("click", function () {
  var check_comments = document.querySelectorAll(".check_me_merge");
  for (let index = 0; index < check_comments.length; index++) {
    if (!(check_comments[index].checked)) {
      check_comments[index].checked = true;
    } else if (check_comments[index].checked) {
      check_comments[index].checked = false;
    }
  }
});

$(document).on("click", ".delete_students_checked", function () {

  var inputElems = document.querySelectorAll(".check_me_merge");
  $hidden_class = $("#hidden_class").val();
  count = 0;
  for (var i = 0; i < inputElems.length; i++) {
    if (inputElems[i].type == "checkbox" && inputElems[i].checked == true) {
      count++;
    }
  }
  if (count >= 1) {

    var form_data_send = new FormData();
    for (let index = 0; index < inputElems.length; index++) {
      if (inputElems[index].checked == true) {
        var id = inputElems[index].getAttribute("id-merge-check");
        form_data_send.append("id", id);
        $.ajax({
          type: "POST",
          url: global_url + "admin_student_courses/delete_specific_merged_courses",
          processData: false,
          contentType: false,
          data: form_data_send,
          success: function (response) {
            //  $("#response_area").html("<b class='alert alert-danger form-control' style='width:100%;'>"+response+"</b>");
            if (response == "merged courses were succesfully") {
              swal(response)
              setTimeout(() => {
                document.location.reload(true);
              }, 200);

            } else {
              swal(response);
            }
          }
        });
      }
    }
  } else {

    swal("Are You sure you want to delete all merged courses since you did not select any merged course to be deleted?", {
      buttons: {
        Yes: {
          text: "yes",
          value: "Yes",
        },
        No: {
          text: "no",
          value: "No",
        },
        cancel: "cancel",
      },
    })
      .then((value) => {
        switch (value) {
          case "Yes":
            $.ajax({
              type: "GET",
              url: global_url + "admin_student_courses/delete_merged_courses?class_name=" + $hidden_class,
              success: function (response) {
                swal(response);
                setTimeout(() => {
                  document.location.reload(true);
                }, 2000);
              }
            });
            break;

          case "No":

            break;

          default:
            swal("please be sure to select the courses merged if you dont want to delete all merged courses");
        }
      });
  }
});
   
$(document).on("click", ".add_topic", function () {
  $id = $(this).attr("id-add-topic");
  $course_name_for_add_topic = $("#course_name_for_add_topic");
  $class_name_for_add_topic = $("#class_name_for_add_topic");
  $(".animation-ajax-loader").show();
  var course_name = this.parentNode.parentNode.querySelector(".course_name_cont_use").innerHTML;
      $course_name_for_add_topic.val(""+course_name+"");
      $class_name_for_add_topic.val(""+$("#hidden_class").val()+"");
      $(".animation-ajax-loader").fadeOut();
})
$("#add_topic").on("click",function(){
  $course_name_for_add_topic = $("#course_name_for_add_topic");
  $class_name_for_add_topic = $("#class_name_for_add_topic");
  $topic_name =  $("#topic_name");
  $session_name = $("#session_name");
  if($topic_name.val()==""){
   swal("topic name cannot be left empty") 
  }
  else if($session_name.val()==""){
  swal("session cannot be left empty please choose a session for this course")
  }else{
    this_btn = this;
    this_btn.disabled="true";
    var form_data = new FormData();
     form_data.append("topic_name",$topic_name.val());
     form_data.append("sessions_name", $session_name.val());
     form_data.append("course_name", $course_name_for_add_topic.val());
     form_data.append("class_name", $class_name_for_add_topic.val());
    $.ajax({
      type: "POST",
      url: global_url+"admin_student_courses/add_topic",
      data: form_data,
      processData: false,
      contentType: false,
      success: function (response) {
        swal(response)
        this_btn.disabled=false;
      }
    });
  } 
});
  $(document).on("click",".load-topics-according-to-class",function(){
    var value;
    $("#modal_body_display").html("");
      $get_course_name = $(this).attr("id-topic-course-name");
      $get_class_name = $(this).attr("id-topic-class-name");
    $(".animation-ajax-loader").show();
       $.ajax({
         type: "GET",
         url: global_url+"admin_student_courses/load_term_for_course?course_name="+$get_course_name+"&class_name="+$get_class_name,
         success: function (response) {
           var parse_response = JSON.parse(response);
           if(response.hasOwnProperty("content_error")){
               swal(parse_response.content_error)
               $(".animation-ajax-loader").fadeOut();
           }else {
            $(".animation-ajax-loader").fadeOut();
            $(".modal-contents").html(""+$get_class_name+" "+$get_course_name+" scheme of work");
            value="";
                for (let index = 0; index < parse_response.length; index++) {
                var session_specific = parse_response[index]; 
value += "<div class='card load-more-term-topic' style='margin-bottom:0;cursor:pointer;' id-session='"+session_specific.sessions_name+"'><div class='' style=''><ul class='accordion-second'><li style='margin-top: 10px;margin-left: 10px;'><h5 class='mb-0'>"+session_specific.sessions_name+"</h5></li>";
 value+=" <li><div class='clicks' >";          
 value+="</div></li></ul></div></div><div class='content-display-topics' style='display:none;'><img src='"+global_url+"assets/images_admin/spinner.gif'/></div><input type='hidden' id-course='"+$get_course_name+"' class='get-course'/><input type='hidden' id-class='"+$get_class_name+"' class='get-class'/>";
                    $("#modal_body_display").html(""+value+""); 
                    }
               $(".animation-ajax-loader").fadeOut();
           }
          
         }
       });   
  })
  
  $(document).on("click",".load-more-term-topic",function(){
  $course_name= $(this).next().next().attr("id-course");
  $class_name = $(this).next().next().next().attr("id-class");
  $session = $(this).attr("id-session");
  $content = $(this);
  //$(".content-display-topics").html("<img src='"+global_url+"assets/images_admin/spinner.gif'/>");
  //$(".content-display-topics").html("");
  var value;
    $.ajax({
      type: "GET",
      url: global_url+"admin_student_courses/load_topics_per_term?course_name="+$course_name+"&class_name="+$class_name+"&session="+$session,
      success: function (response) {
       value="";
       var parse_response = JSON.parse(response);
       for (let index = 0; index < parse_response.length; index++) {
         const response_details = parse_response[index];
         value += "<div class='card' style='margin-bottom:0;cursor:pointer;'><div class='change-look' style=''><ul class='accordion-second'><li style='margin-top: 10px;margin-left: 10px;'><h5 class='mb-0 header-topic-design-class'>"+response_details.topic+"</h5></li>";
 value+=" <li><div>";
 value+="<li class='nav-item ' style='float:right;' ><a class='nav-link delete-topic  btn bold-cont' id='"+response_details.id+"' href='#'><i class='fa fa-trash' aria-hidden='true'></i></a>";                   
value+="</li>";           
 value+="</div></li></ul></div></div>";
 $content.next().html(""+value+"");
       }
      }
    });
   $(this).next().slideToggle();
  })

  $(document).on("click", ".delete-topic",function(){
    $get_id = $(this).attr("id"); 
    var this_btn = $(this);
    swal("Are You sure you want to delete this topic for this term?", {
      buttons: {
        Yes: {
          text: "yes",
          value: "Yes",
        },
        No: {
          text: "no",
          value: "No",
        },
        cancel: "cancel",
      },
    })
      .then((value) => {
        switch (value) {
          case "Yes":
            $.ajax({
              type: "GET",
              url: global_url + "admin_student_courses/delete_topic?id=" + $get_id,
              success: function (response) {
                swal(response);
                if(response=="topic was successfully deleted"){
                 this_btn.parent().parent().parent().parent().remove();
                }else{
                  
                }
              }
            });
            break;

          case "No":

            break;

          default:
        }
      });
 
  });

  $("#live_search_students_manage_results").on("keyup", function(){
    var wrapper = document.querySelector(".panel-body");
  var display_contents = document.querySelector("#display_content");
  btn_to_remove = wrapper.querySelector(".btn_more_manage_results");
  $val = $(this).val();
  if (btn_to_remove !== null) {
    if ($val == "") {
      display_contents.removeChild(btn_to_remove);
    }
  }
  $.ajax({
    type: "GET",
    url: global_url + "admin_student_results/search_students?search=" + $val,
    success: function (response) {
      var response_text = JSON.parse(response);
      var myObj = response_text.results;
      var value;
      var display_content = document.querySelector("#display_content");
      display_content.innerHTML = "";
      for (var index = 0; index < myObj.length; index++) {
        var index_elem = myObj[index];
        value = "<tr>";
        value += "<td>" + index_elem.id + "</td>";
        value += "<td>" + index_elem.username + "</td>";
        value += "<td>" + index_elem.class_name + "</td>";
        value += "<td>" + index_elem.sub_class_name + "</td>";
        value += "<td><img src='" + global_url + "assets/student_image/" + index_elem.file_name + "' style='width:40px;height=40px;'/></td>";
        value += "<td><a href='" + global_url + "Home/Add-Results/" + index_elem.id + "' class='btn btn-primary'><i class='fa fa-pencil-square'></i></a></td>";
        value += "<td><a href='" + global_url + "Home/View-Results/" + index_elem.id + "' class='btn btn-primary'><i class='fa fa-eye'></i></a></td>";
        value += "</tr>";
        display_content.innerHTML += value;
      }
      var wrapper = document.querySelector(".panel-body"); /*had to declare a second time to avoid any undefined error 
         plus i also want to avoid the global scope error*/
      if (myObj.length !== 5) {
        //do nothing
        if (btn_to_remove !== null) {
          if ($val == "") {
            display_contents.removeChild(btn_to_remove);
          }
        }
      } else {
        display_content.innerHTML += "<tr><button style='margin-left:400%;'class='btn btn-primary btn_more_manage_results'  id='" + index_elem.id + "'>more<i class='fa fa-hand-o-down' aria-hidden='true'></i></button></tr>";
      }
    }
  });
  })

  $(document).on("click", ".btn_more_manage_results", function () {
    var $id = $(this).attr("id");
    $val = $("#live_search_students_manage_results").val();
    this.parentNode.removeChild(this);
    var display_content = document.querySelector("#display_content");
    $.ajax({
      type: "GET",
      url: global_url + "admin_student_results/load_more_student_search?search=" + $val + "&id=" + $id,
      success: function (response) {
        var response_text = JSON.parse(response);
        var myObj = response_text.results;
        var value;
        display_content.innerHTML = "";
        for (var index = 0; index < myObj.length; index++) {
          var index_elem = myObj[index];
          value = "<tr>";
          value += "<td>" + index_elem.id + "</td>";
          value += "<td>" + index_elem.username + "</td>";
          value += "<td>" + index_elem.class_name + "</td>";
          value += "<td>" + index_elem.sub_class_name + "</td>";
          value += "<td><img src='" + global_url + "assets/student_image/" + index_elem.file_name + "' style='width:40px;height=40px;'/></td>";
          value += "<td><a href='" + global_url + "Home/Add-Results/" + index_elem.id + "' class='btn btn-primary'><i class='fa fa-pencil-square'></i></a></td>";
          value += "<td><a href='" + global_url + "Home/View-Results/" + index_elem.id + "' class='btn btn-primary'><i class='fa fa-eye'></i></a></td>";
          value += "</tr>";
          display_content.innerHTML += value;
        }
        if (index_elem.id == 1) {
  
        } else {
          display_content.innerHTML += "<tr><button style='margin-left:400%;' class='btn btn-primary btn_more_manage_results'  id='" + index_elem.id + "'>more<i class='fa fa-hand-o-down' aria-hidden='true'></i></button></tr>";
        }
  
  
      }
  
    });
  
  });
   
  $("#add_grade_range").on("click",function(){
    this_btn = this;
    $grade_one_range = $("#grade_one_range").val();
    $grade_two_range = $("#grade_two_range").val();
    $Grade_letter = $("#grade_letter").val();
    if($grade_one_range==""){
     $("#validation_class").html("<center class='alert alert-danger'><b>pleaseenter grade range score one</b></center>")
    }else if($grade_two_range==""){
      $("#validation_class").html("<center class='alert alert-danger'><b>please enter grade range score two</b></center>")
    }else if($Grade_letter==""){
      $("#validation_class").html("<center class='alert alert-danger'><b>please enter a grade containing only a single character of text from A-F)</b></center>")
    }
    else {
      var form_data_add = new FormData();
  form_data_add.append("first_grade", $grade_one_range);
  form_data_add.append("second_grade", $grade_two_range);
  form_data_add.append("grade_letter", $Grade_letter);
$("#validation_class").html("<center class='alert alert-danger'><b>Loading...</b></center>");
  $.ajax({
    type: "POST",
    url: global_url + "admin_student_results/add_grades",
    data: form_data_add,
    processData: false,
    contentType: false,
    success: function (response) {
      $("#validation_class").html("<center class='alert alert-danger'><b>" + response + "</b></center>");
      this_btn.disabled = false;
    }
  });
    }
  })
   $(document).on("click", ".delete_grade_btn",function(){
    swal("Are You sure you want to delete this grade range? ", {
      buttons: {
        Yes: {
          text: "yes",
          value: "Yes",
        },
        No: {
          text: "no",
          value: "No",
        },
        cancel: "cancel",
      },
    })
      .then((value) => {
        switch (value) {
          case "Yes":
            var id_delete = this.getAttribute("delete-id");
            $.ajax({
              type: "GET",
              url: global_url + "admin_student_results/delete_grades?id=" + id_delete,
              success: function (response) {
                swal(response);
                setTimeout(() => {
                  document.location.reload(true);
                }, 2000);
              }
            });
            break;
  
          case "No":
  
            break;
  
          default:
          
        }
      });
   })

   function CreateSlug()
   {
    var length = 30,
    charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
    retVal = "";
  for (var i = 0, n = charset.length; i < length; ++i) {
    retVal += charset.charAt(Math.floor(Math.random() * n));
  }
  return retVal;
   }

  /**
   * this loads the result views
   */
  $(".load_result_sheet").on("click",function(){
    $sessions_area = $("#sessions_area").val();
    $classes_area = $("#classes_area_content").val();
    var content_results = document.querySelector(".content_results");
    $user_result = $(".user_result").html(); /**this is the username */
    $student_id = $(".student_id").val();
    $calendar_year = $("#calendar_year").val();
    var content;
    if($classes_area==""){
      swal("please to generate the appropiate result sheet please be sure to select a class ");
    }
    else if($sessions_area==""){
      swal("please to generate the appropiate result sheet please be sure to select a session ");
    }else if($calendar_year==""){
      swal("please enter a calendar year and do so in the required format to accurately perform seacrh");
    } 
    else{
            $(".content_results").html("<center><img src='"+global_url+"assets/images_admin/gif.gif'/></center>");
      $.ajax({
        type: "GET",
        url: global_url+"admin_student_results/load_result_sheet?session="+$sessions_area+"&class_name="+$classes_area,
        success: function (response) {
         var parse_response = JSON.parse(response);
         content_results.innerHTML="";
         $slug_value = CreateSlug();
          content ="<table class='table table-striped table-responsive'>";
         content+="<thead class=''><tr><td>Course</td><td>Quiz</td><td>Attendance</td><td>Exam</td><td>total</td><td>grade</td><td>Add/Delete Subject Result</td></tr></thead>";
         content+="<tbody>";
         $slug = ""+$slug_value+""+$user_result; /**this is a slug that will be used to query the database on the view */  
         content+="<input type='hidden' value='"+$slug+"' id='slug'/>"; 
          for (let index = 0; index < parse_response.length; index++) {
            content_get = parse_response[index];
            content+="<tr>";  
            content+="<td id='"+content_get.course_name+"' class='course-loaded'>"+content_get.course_name+"</td>";
            content+="<td class='td-quiz'><div class='form-group'><input type='text'  class='form-control num_val student_quiz' placeholder=''></div></td>";
            content+="<td class='td-attendance'><div class='form-group'><input type='text' class='form-control num_val student_attendance' placeholder=''></div></td>";
            content+="<td class='td-student-exam'><div class='form-group'><input type='text' class='form-control num_val student_exam' placeholder=''></div></td>";
            content+="<td class='td-total'><div class='form-group'><input type='text'  class='form-control num_val total_score' disabled  placeholder=''></div></td>";
            content+="<td class='td-grade'><div class='form-group'><input type='text'  class='form-control  grade' placeholder='' disabled></div> </td>";
            content+="<td><div class='form-group'><button class=' btn-res btn-add-course-result "+$student_id+"'><i class='fa fa-floppy-o' ></i></button><br><button class=' btn-reset-added-course btn-res "+$student_id+"'><i class='fas fa-redo'></i></button><br><b class='display_result' style='color:red;'></b></div></td>";
            content+="</tr>";
          }
          
          

         content+="</tbody></table><br>";
         content+="<center><div class='row' style='margin-left:3%;margin-right:3%;'><div class='col-md-5'><input type='text' class='form-control' id='calendar_year_content' placeholder='enter calendar year of this result in format 2012-2013'/></div><div class='col-md-7'><textarea class='form-control' id='remarks' placeholder='please enter students remark here, this is optional'></textarea></div></div></center><br><br>";
         content+="<center><button class='btn btn-primary submit_content' id='save_course_total'><i class='fa fa-floppy-o' ></i> save</button>&nbsp;&nbsp;";
         content+="&nbsp;";
         content+="</center><br><br>";
         content+="<input type='hidden' class='cotent_hide_classes' value='"+$classes_area+"'/>";/**this contains the class of the user too */
          content+="<input type='hidden' class='cotent_hide_sessions' value='"+$sessions_area+"'/>";
          content_results.innerHTML=content;
        }
      });
    }
  })
        
  $(document).on("click",".btn-add-course-result",function changeMe(){
    var this_btn = $(this);
    $student_id = $(".student_id").val();
    var display_response = this.parentNode.querySelector(".display_result");
   var course_name = this.parentNode.parentNode.parentNode.firstChild.innerHTML;
   var student_quiz = this.parentNode.parentNode.parentNode.querySelector(".td-quiz").querySelector(".student_quiz");
   var student_attendance = this.parentNode.parentNode.parentNode.querySelector(".td-attendance").querySelector(".student_attendance");
   var student_exam = this.parentNode.parentNode.parentNode.querySelector(".td-student-exam").querySelector(".student_exam");
   var total_score = this.parentNode.parentNode.parentNode.querySelector(".td-total").querySelector(".total_score");
   var grade = this.parentNode.parentNode.parentNode.querySelector(".td-grade").querySelector(".grade");
   var slug = $("#slug").val();
   var values = total_score.value;
   if(student_quiz.value=="" || student_exam.value=="" || student_attendance.value==""){
     swal("please be sure student quiz,student attendance or exam is not empty to compile total score and his grade for this course");
   }else{
    total_score.disabled = false;
     total_score.value = parseFloat( student_quiz.value)  + parseFloat( student_attendance.value)  +  parseFloat(student_exam.value) * 1 ;
     total_score.disabled="true";
     final_score = total_score.value;
     if(values!=final_score){
       grade.value="loading...";
       /**
        * this first ajax function loads the user grade
        */
       this_btn.disabled="true";
       display_response.innerHTML="loading....";
       $.ajax({
         type: "GET",
         url: global_url+"admin_student_results/load_grade?score="+total_score.value,
         success: function (response) {
         var resp = JSON.parse(response);
         if(resp.hasOwnProperty("msg")){
           swal(resp.msg)
           display_response.innerHTML="";
           grade.value="";
         }else{
           grade.value= resp.data;
           

  /**
   * this second ajax function sends the user course detail to the database for storage
   */ 
      var form_data = new FormData();
      form_data.append("student_name",$(".user_result").html());
      form_data.append("course_name",course_name);
      form_data.append("quiz", student_quiz.value);
      form_data.append("attendance", student_attendance.value);
      form_data.append("exam", student_exam.value);
      form_data.append("total_score", total_score.value);
      form_data.append("grade", grade.value);
      form_data.append("class_name", $(".cotent_hide_classes").val());
      form_data.append("slug", slug);
      form_data.append("session", $(".cotent_hide_sessions").val());
      form_data.append("student_id", $student_id);
     $.ajax({
       type: "POST",
       url: global_url+"admin_student_results/save_course",
       data: form_data,
       processData: false,
       contentType: false,
       success: function (response) {
         var res_json = JSON.parse(response);
         if(res_json.hasOwnProperty("msg")){
           swal(res_json.msg);
           display_response.innerHTML="";
         }else{
          display_response.innerHTML = res_json.success;
         }
         
         this_btn.disabled =false;
       //  console.log(response+"here data"+$(".user_result").html()+""+course_name+""+student_quiz.value+""+total_score.value);
       }
     });
         } 
         }
       });
       values=final_score;
     }else{
       swal("if this was saved then you cannot save it again unless you use the reset button to reset this data,if there was an error also use the reset button before trying to save course score again ");
     }  
   }
  })

  /**
   * this function resets a course saved this is an ajax request
   */
  $(document).on("click", ".btn-reset-added-course",function(){
   var this_btn = this;
    $student_id = $(".student_id").val();
    var course_name = this.parentNode.parentNode.parentNode.firstChild.innerHTML;
  $class_name =   $(".cotent_hide_classes").val();
  $session =  $(".cotent_hide_sessions").val();
    $user_result = $(".user_result").html(); /**this is the username */
    var display_response = this.parentNode.querySelector(".display_result");
    swal("Are You sure you want to reset student score for this course?", {
      buttons: {
        Yes: {
          text: "yes",
          value: "Yes",
        },
        No: {
          text: "no",
          value: "No",
        },
        cancel: "cancel",
      },
    })
      .then((value) => {
        switch (value) {
          case "Yes":
           $.ajax({
             type: "GET",
             url: global_url+"admin_student_results/reset_course?class_name="+$class_name+"&session="+$session+"&username="+$user_result+"&course="+course_name+"&student_id="+$student_id,
               success: function (res) {
                 var response = JSON.parse(res);
               if(response.hasOwnProperty("error")){
                 swal(response.error);
               }else if(response.hasOwnProperty("deleted")){
                  swal(response.deleted);
                  display_response.innerHTML="";
            this_btn.parentNode.parentNode.parentNode.querySelector(".td-total").querySelector(".total_score").value="";
            this_btn.parentNode.parentNode.parentNode.querySelector(".td-grade").querySelector(".grade").value="";
               }
             }
           });  


            break;
  
          case "No":
  
            break;
  
          default:
  
        }
      });
  });

  $(document).on(" change keyup", ".num_val",  function(){
    if(this.value.length > 3){
      this.value="";
    }else{
      $sanitize =  $(this).val().replace(/[^0-9]/g, "");
      $(this).val($sanitize);
    }
    
  })
  $(document).on("change keyup", ".grade", function(){
    if(this.value.length > 1){
      this.value="";
    }else {
      $sanitize =  $(this).val().replace(/[^a-fA-F]+$/, "");
      $(this).val($sanitize);
    }
   
  });
  /**this will save the course total result and returns the student average */
 $(document).on("click", "#save_course_total",function(){
  var this_btn = this;
    $class_name =   $(".cotent_hide_classes").val();
    $session =  $(".cotent_hide_sessions").val();
    $user_result = $(".user_result").html(); /**this is the username */
    $student_id = $(".student_id").val();
    $calendar_year_content = $("#calendar_year_content").val();
    $remarks = $("#remarks").val();
    $student_sub_class_name = $(".student_sub_class_name").val();
    if($calendar_year_content==""){
      swal("please be sure that you enter a calendar year for this students result");
    }
    else if($class_name=="" || $session=="" || $user_result=="" || $student_id=="" || $student_sub_class_name=="" ){
      swal("there seems to be a problem please refresh your browser");
    }else{
      swal("please be sure all scores added have been saved as total score and average will be computed with available data for this student during this session and year from the already saved data.", {
        buttons: {
          Yes: {
            text: "yes",
            value: "Yes",
          },
          No: {
            text: "no",
            value: "No",
          },
          cancel: "cancel",
        },
      })
        .then((value) => {
         switch (value) {
           case "Yes":
           this_btn.disabled="true";
           this_btn.innerHTML = "<img  style='width:20px;height:20px;' src='"+global_url+"assets/images_admin/gif.gif'/>";
           var form_data = new FormData();
           form_data.append("class_name", $class_name);
           form_data.append("session", $session);
           form_data.append("username", $user_result);
           form_data.append("student_id", $student_id);
           form_data.append("calendar_year", $calendar_year_content);
           form_data.append("remarks", $remarks);
           form_data.append("sub_class_name",$student_sub_class_name);
           $.ajax({
             type: "POST",
         url: global_url + "admin_student_results/save_final_result",
         data: form_data,
         processData: false,
         contentType: false,
             success: function (res) {
             response = JSON.parse(res);
              //console.log(response);
              this_btn.disabled=false;
              this_btn.innerHTML="save";
              if(response.hasOwnProperty("error")){
                swal(response.error);
              }else if(response.hasOwnProperty("success")){
                swal(response.success);
              }else if(response.hasOwnProperty("override_error")){
                swal(response.override_error, {
                  buttons: {
                    Yes: {
                      text: "yes",
                      value: "Yes",
                    },
                    No: {
                      text: "no",
                      value: "No",
                    },
                    cancel: "cancel",
                  },
                }).then((value)=>{
                   switch (value) {
                     case "Yes":
              /**
               * this function helps update the user final result details
               * this only occurs if result already exist in the db and admin wants to update this result
               */
            var form_data_update = new FormData();
            form_data_update.append("class_name", $class_name);
           form_data_update.append("session", $session);
           form_data_update.append("username", $user_result);
           form_data_update.append("student_id", $student_id);
           form_data_update.append("calendar_year", $calendar_year_content);
           form_data_update.append("remarks", $remarks);
           form_data_update.append("sub_class_name",$student_sub_class_name);
           $.ajax({
             type: "POST",
             url: global_url + "admin_student_results/update_final_result",
             data: form_data_update,
             processData: false,
             contentType: false,
             success: function (res) {
               console.log(res)
              var response = JSON.parse(res);
              if(response.hasOwnProperty("error")){
                swal(response.error);
              }else if(response.hasOwnProperty("success")){
                swal(response.success);
              }else{
                swal("updating student result was not successful");
              }
             }
           });
                       break;
                      
                    case "No":
                  swal("if you want to delete any related final result to this course please use the undo button")
                    break;

                     default:
                       break;
                   }
                })  
              }   
             }
           });          
               break;

          case "No":
          swal("please note that to save final result is dependent on courses added for this session and this user in this class too.");
          break;

           default:
             break;
         }
        
        })
    }
 });
 //this function is to add results for students using the fab icon button
$(document).on("click","#add_new_student_result",function(){
  var this_btn = this;
  $classes_area_content = $("#student_class_to_attach").val();
   $student_session_to_attach = $("#student_session_to_attach").val();
   $student_result_to_attach = $("#student_result_to_attach").val();
   $student_result_file = document.querySelector("#student_result_to_attach").files[0];
   $student_calendar_year_attach = $("#student_calendar_year_attach").val();
   $student_remark_attach = $("#student_remark_attach").val();
   $student_sub_class_name = $(".student_sub_class_name").val();
   $user_result = $(".user_result").html(); /**this is the username */
   $student_id = $(".student_id").val();
   if($student_calendar_year_attach==""){
     swal("please be sure that you enter a calendar year for this students result");
   }
   else if($classes_area_content=="" || $student_session_to_attach=="" || $student_result_to_attach=="" ||    
      $student_sub_class_name=="" ||  $user_result=="" || $student_id=="" ){
     swal("there seems to be a problem please refresh your browser");
   }else{
          this_btn.disabled="true";
          this_btn.innerHTML = "<img  style='width:20px;height:20px;' src='"+global_url+"assets/images_admin/gif.gif'/>";
          var form_data = new FormData();
          form_data.append("class_name", $classes_area_content);
          form_data.append("session", $student_session_to_attach);
          form_data.append("result_file",$student_result_file);
          form_data.append("calendar_year", $student_calendar_year_attach);
          form_data.append("sub_class_name",$student_sub_class_name);
          form_data.append("username", $user_result);
          form_data.append("student_id", $student_id);
          form_data.append("remarks", $student_remark_attach);
          form_data.append("sub_class_name",$student_sub_class_name);
          $.ajax({
            type: "POST",
        url: global_url + "admin_student_results/save_final_result_with_file",
        data: form_data,
        processData: false,
        contentType: false,
        cache:false,
            success: function (res) {
              console.log(res)
            response = JSON.parse(res);
             this_btn.disabled=false;
             this_btn.innerHTML="save";
             if(response.hasOwnProperty("error")){
               swal(response.error);
             }else if(response.hasOwnProperty("success")){
               swal(response.success);
             }else if(response.hasOwnProperty("override_error")){
               swal(response.override_error, {
                 buttons: {
                   Yes: {
                     text: "yes",
                     value: "Yes",
                   },
                   No: {
                     text: "no",
                     value: "No",
                   },
                   cancel: "cancel",
                 },
               }).then((value)=>{
                  switch (value) {
                    case "Yes":
             /**
              * this function helps update the user final result details with file
              * this only occurs if result already exist in the db and admin wants to update this result
              */
           var form_data_update = new FormData();
           form_data_update.append("class_name", $classes_area_content);
           form_data_update.append("session", $student_session_to_attach);
           form_data_update.append("result_file",$student_result_file);
           form_data_update.append("calendar_year", $student_calendar_year_attach);
           form_data_update.append("sub_class_name",$student_sub_class_name);
           form_data_update.append("username", $user_result);
           form_data_update.append("student_id", $student_id);
           form_data_update.append("remarks", $student_remark_attach);
           form_data_update.append("sub_class_name",$student_sub_class_name); 
          $.ajax({
            type: "POST",
            url: global_url + "admin_student_results/update_final_result_with_file",
            data: form_data_update,
            processData: false,
            contentType: false,
            cache:false,
            success: function (res) {
             var response = JSON.parse(res);
             if(response.hasOwnProperty("error")){
               swal(response.error);
             }else if(response.hasOwnProperty("success")){
               swal(response.success);
             }else{
               swal("updating student result was not successful");
             }
            }
          });
                      break;
                     
                   case "No":
                 swal("if you want to delete any related final result to this course please use the undo button")
                   break;

                    default:
                      break;
                  }
               })  
             }   
            }
          });                   
   }
});
//this function changes the tooltip data toggle to a modal once the page loads
window.addEventListener("load",changeDataToggleToModal);
function changeDataToggleToModal(e)
{
e.preventDefault();
$(".load_student_result").attr("data-toggle","modal");
}
//this function is load student result view so it can be seen
$(document).on("click",".load_student_result",function(e){
e.preventDefault();
$student_id = $(this).attr("data-student-id");
$class_name = this.parentNode.nextElementSibling.value;
$session = this.parentNode.nextElementSibling.nextElementSibling.value;
$sub_class_name = this.parentNode.nextElementSibling.nextElementSibling.nextElementSibling.value;
$calendar_year = this.parentNode.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling.value;
//return console.log("student_id=>"+$student_id+"class_name=>"+$class_name+"session=>"+$session+"sub_class=>"+$sub_class_name+"calendar_year=>"+$calendar_year);
if($student_id=="" || $class_name=="" || $sub_class_name=="" || $session=="" || $calendar_year==""){
  swal("there seems to be a problem please refresh your browser");
}else {
  $(".animation-ajax-loader").show();
  $.ajax({
    type: "GET",
    url: global_url+"admin_student_results/show_full_result_details?student_id="+$student_id+"&class_name="+$class_name+"&session="+$session+"&sub_class_name="+$sub_class_name+"&calendar_year="+$calendar_year,
    success: function (response) {
      console.log(response)
      res = JSON.parse(response);
      if(res.hasOwnProperty("error")){ //if response has an error message
        $("#content_result").html(res.error);
      }else if(res.hasOwnProperty("file_name")){ //if this is a file
        console.log(res.file_name)
        var res_extension =  res.file_name.substr(res.file_name.lastIndexOf(".")+1);
 if ($.inArray(res_extension, ["pdf"]) == -1) { //if the file is not a pdf file therefore show docx file
  $content = "<object data='"+global_url+"assets/student_results/"+res.file_name+"' style='width:100%;height:500px;' type='application/vnd.openxmlformats-officedocument.wordprocessingml.document'></object>";
  $("#content_result").html($content)
 }else if($.inArray(res_extension, ["docx"]) == -1){ //then its a docx file therefore show pdf
  $content = "<object data='"+global_url+"assets/student_results/"+res.file_name+"' style='width:100%;height:500px;' type='application/pdf'></object>";
  $("#content_result").html($content)
 }
      }else{ //if this is not a file but a row of data in the db

      }
      $(".animation-ajax-loader").hide();
    }
  }); 
}
});
