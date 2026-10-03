<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
          >
          <h2 class="text-primary"><b>User Data View</b></h2>
          <h5 class="text-muted">Welcome to User View Page 👋</h5>
          </div>
          
    <style>
     
      .card {
        padding: 15px;
        border-radius: 6px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 20px;
      }
     
      #details p {
        margin-bottom: 6px;
      }

      .search-card{
        padding:15px;
        border-radius:8px;
        box-shadow:0 2px 8px rgba(0,0,0,0.08);
      }

      .input-group{
         position:relative;
        
        }
        #suggestions{
            background:white;
            border:1px solid gray;
            position:absolute;
            top:100%;
            left:0;
            width:100%;
            z-index:1000;
            border-radius:5px;
            color:black;
            margin-top:5px;

        }
        .suggestion-item{

             padding:10px;
              cursor:pointer;
              border-bottom:1px solid #eee;

        }
        .suggestion-item:hover{

             background:#f1f1f1;

        }

    </style>

    <div class="container">
      <!-- Heading-->
   
      <!--Button-->
      <div class="row">
        <div class="col-md-8">
          <div class="btn-group ">
            
            <button id="loadBtn" class="btn btn-primary">Load User List</button>
            <button id="unloadBtn" class="btn btn-light"> Unload  </button>
            <button id="resetBtn" class="btn btn-primary">Reset Button</button>
          </div>
        </div>

        <div class="col-md-4">
          <div class="btn-group " style="padding-left: 65px;">
            
            <a href="add-user-form.php" class="btn btn-primary">
              Add User
            </a>
          </div>
        </div>
      </div>

      <br /><br />

      <!-- Search User -->
        <div class="search-card">
          
        <div class="row align-items-center">
        <div class="col-md-2">

        <h5 class="mb-0 text-primary">
        Search User
        </h5>
        </div>

        <div class="col-md-4">
        <div class="input-group position-relative">

        <input 
        type="text"
        id="searchUser"
        name="user-search"
        autocomplete="off"
        class="form-control"
        placeholder="Search User Name...">

        <div id="suggestions"></div>

        </div>
        </div>

        </div>

      <br />

      <!-- Main Content-->
      <div class="row">
        <!--Left Person List-->
        <div class="col-md-8">
          <div class="card">
            <h4>User List</h4>
            <table class="table table-hover">
                <thead>
                    <tr>
                         <th>Name</th>

                        <th>User Type</th>

                        <th>Status</th>

                        <th class="text-center" width="230">
                            Action
                        </th>
                                            
                    </tr>
                </thead>
                <tbody id="userTable"></tbody>
            </table>
          </div>
          
        </div>
      
      
      <!-- Right Details-->

      <div class="col-md-4">
        <div class="card">
            <h4><b>User Details</b></h4>
            <div id="details" class="text-muted text-center">Select a User to view details</div>
        </div>
      </div>

      </div>
        
      </div>
    </div>

  
    <script>
   
      $(document).ready(function () {
      // ==========================================
      // Load User List
      // Purpose:
      // Load all users from the database and
      // display them inside the User List table.
      // ==========================================

      $("#loadBtn").click(function () {

          // Clear old records before loading new data
          $("#userTable").html("");

          // Request user list from the server
          $.ajax({

              type: "GET",
              url: "Model/user_data.php",
              dataType: "json",
              cache: false,

              // Run when data is received successfully
              success: function (data) {

                  // Loop through every user
                  $.each(data, function (index, user) {

                      // --------------------------
                      // Create User Status Badge
                      // --------------------------

                      var statusBadge = "";

                        var status = Number(user.status);

                        if (status === 1) {

                            statusBadge =
                                "<span class='badge bg-success'>Active</span>";

                        } else if (status === 2) {

                            statusBadge =
                                "<span class='badge bg-warning text-dark'>Pending</span>";

                        } else {

                            statusBadge =
                                "<span class='badge bg-secondary'>Inactive</span>";
                        }
                      // --------------------------
                      // Create Table Row
                      // --------------------------

                      var content =

                          "<tr>" +

                              // User Name
                              "<td>" + user.name + "</td>" +

                              // User Type
                              "<td>" + user.type + "</td>" +

                              // User Status
                              "<td>" + statusBadge + "</td>" +

                              // Action Buttons
                              "<td class='text-center'>" +

                                  // View Button
                                  "<button class='btn btn-info btn-sm me-2' onclick='loadDetails(" + user.id + ")'>" +
                                      "<i class='fa fa-eye'></i> View" +
                                  "</button>" +

                                  // Delete Button
                                  "<button class='btn btn-danger btn-sm' onclick='deleteDetails(" + user.id + ")'>" +
                                      "<i class='fa fa-trash'></i> Delete" +
                                  "</button>" +

                              "</td>" +

                          "</tr>";

                      // Add the row into the table
                      $("#userTable").append(content);

                  });

              },

              // Run if request fails
              error: function () {

                  alert("Unable to load user list.");

              }

          });

      });

        $("#unloadBtn").click(function () {
          $("#userTable").html("");
        });

        $("#resetBtn").click(function () {
          $("#details , #userTable").html("");
        });

        
         // Auto Complete Search

          $("#searchUser").keyup(function(){
          var search = $(this).val().trim().toLowerCase();
          if(search.length == 0){
          $("#suggestions").html("");
          return;
          }

          $.ajax({

          type:"GET",
          url:"Model/user_autocomplete.php",
          data:{
          search:search
          },

          dataType:"json",
          success:function(data){

          $("#suggestions").html("");

          $.each(data,function(index,user){
          
          var content = "<div class='suggestion-item' data-id='"+user.id+"'>"+ user.User_Name+ "</div>";
          $("#suggestions").append(content);

          });
          }

          });

          });

          $(document).on("click",".suggestion-item",function(){
            
          var userId = $(this).data("id");
            var userName = $(this).text();

            // input me name show karo
            $("#searchUser").val(userName);

            // suggestion hide
            $("#suggestions").html("");

            // table load
            loadUserSearch(userId);

         
        });

        
      });

        // =========================================
      // Load All Users
      // Purpose:
      // Database se tamam users AJAX ke zariye
      // la kar table me display karna.
      // =========================================
      function loadUsers() {

          // Pehle purani table clear kar do
          $("#userTable").html("");

          // AJAX Request
          $.ajax({

              // GET Request
              type: "GET",

              // PHP File jo JSON data return karti hai
              url: "Model/user_data.php",

              // Expected Data Format
              dataType: "json",
              cache: false,

              // Agar request successful ho
              success: function (data) {

                  // Har user ka record loop me uthao
                  $.each(data, function (index, user) {

                      // ==========================
                      // User Status Badge
                      // ==========================
                    var statusBadge = "";

                    var status = Number(user.status);

                    if (status === 1) {

                        statusBadge =
                            "<span class='badge bg-success'>Active</span>";

                    } else if (status === 2) {

                        statusBadge =
                            "<span class='badge bg-warning text-dark'>Pending</span>";

                    } else {

                        statusBadge =
                            "<span class='badge bg-secondary'>Inactive</span>";
                    }

                      // ==========================
                      // Create Table Row
                      // ==========================
                      var content =

                          "<tr>" +

                              // User Name
                              "<td>" + user.name + "</td>" +

                              // User Type
                              "<td>" + user.type + "</td>" +

                              // User Status
                              "<td>" + statusBadge + "</td>" +

                              // Action Buttons
                              "<td class='text-center'>" +

                                  // View Button
                                  "<button class='btn btn-info btn-sm me-2' onclick='loadDetails(" + user.id + ")'>" +
                                      "<i class='fa fa-eye'></i> View" +
                                  "</button>" +

                                  // Delete Button
                                  "<button class='btn btn-danger btn-sm' onclick='deleteDetails(" + user.id + ")'>" +
                                      "<i class='fa fa-trash'></i> Delete" +
                                  "</button>" +

                              "</td>" +

                          "</tr>";

                      // Table ke andar row add kar do
                      $("#userTable").append(content);

                  });

              },

                    // Agar AJAX fail ho jaye
                    error: function () {

                        console.log("Error loading users.");

                    }

                });

            }

            // Load the selected user into the table after an autocomplete selection.
            function loadUserSearch(id) {

                $.ajax({

                    type: "GET",
                    url: "Model/user_search_by_id.php",
                    data: { id: id },
                    dataType: "json",

                    success: function (user) {

                        $("#userTable").html("");

                        if (!user || !user.id) {
                            $("#userTable").html("<tr><td colspan='4' class='text-center'>No User Found.</td></tr>");
                            return;
                        }

                        var status = Number(user.User_Status);
                        var statusBadge = status === 1
                            ? "<span class='badge bg-success'>Active</span>"
                            : status === 2
                                ? "<span class='badge bg-warning text-dark'>Pending</span>"
                                : "<span class='badge bg-secondary'>Inactive</span>";

                        var content =
                            "<tr>" +
                                "<td>" + user.User_Name + "</td>" +
                                "<td>" + user.User_Type + "</td>" +
                                "<td>" + statusBadge + "</td>" +
                                "<td class='text-center'>" +
                                    "<button class='btn btn-info btn-sm me-2' onclick='loadDetails(" + user.id + ")'>" +
                                        "<i class='fa fa-eye'></i> View" +
                                    "</button>" +
                                    "<button class='btn btn-danger btn-sm' onclick='deleteDetails(" + user.id + ")'>" +
                                        "<i class='fa fa-trash'></i> Delete" +
                                    "</button>" +
                                "</td>" +
                            "</tr>";

                        $("#userTable").append(content);

                    },

                    error: function () {
                        $("#userTable").html("<tr><td colspan='4' class='text-center text-danger'>Unable to load user.</td></tr>");
                    }

                });
            }


            // =========================================
            // Load User Details
            // Purpose:
            // Selected user ki complete information
            // right side details panel me show karna.
            // =========================================
            function loadDetails(id) {

                // AJAX Request
                $.ajax({

                    // GET Request
                    type: "GET",

                    // PHP File jo user ki details JSON me return karti hai
                    url: "Model/user_details.php",

                    // Expected Response
                    dataType: "json",
                    cache: false,

                    // Agar Request Successful ho
                    success: function (data) {

                        // Check karo selected ID ka record mojood hai ya nahi
                        if (data[id]) {

                            // ==========================
                            // User Information
                            // ==========================

                            var name    = data[id].name;
                            var email   = data[id].email;
                            var type    = data[id].type;
                            var status  = data[id].status;
                            var created = data[id].created_at;
                            var updated = data[id].updated_at;

                            // ==========================
                            // Status Badge & Button
                            // ==========================

                          var statusBadge = "";
                            var statusButton = "";

                                var userStatus = Number(status);
                            // ==========================
                            // Active User
                            // ==========================

                            if (userStatus === 1 ) {

                                statusBadge =
                                    "<span class='badge bg-success'>Active</span>";

                               statusButton =
                                "<button class='btn btn-danger w-100 mt-3 toggle-user-status-btn' " +
                                "data-id='" + id + "' data-status='0'>" +
                                "<i class='fa fa-user-slash'></i> Deactivate User" +
                                "</button>";
                            }

                            // ==========================
                            // Pending User
                            // ==========================

                            else if (userStatus === 2 ) {

                                statusBadge =
                                    "<span class='badge bg-warning text-dark'>Pending</span>";

                              statusButton =
                                "<button class='btn btn-success w-100 mt-3 toggle-user-status-btn' " +
                                "data-id='" + id + "' data-status='1'>" +
                                "<i class='fa fa-user-check'></i> Approve & Activate User" +
                                "</button>";
                            }

                            // ==========================
                            // Inactive User
                            // ==========================

                            else {

                                statusBadge =
                                    "<span class='badge bg-secondary'>Inactive</span>";

                                statusButton =
                                "<button class='btn btn-success w-100 mt-3 toggle-user-status-btn' " +
                                "data-id='" + id + "' data-status='1'>" +
                                "<i class='fa fa-user-check'></i> Activate User" +
                                "</button>";
                                                        }

                            // ==========================
                            // Create User Details Card
                            // ==========================

                            var content =

                                "<h5 class='mb-3'><b>User Details</b></h5>" +

                                "<table class='table table-bordered table-striped align-middle'>" +

                                    "<tr>" +
                                        "<th width='35%'>Name</th>" +
                                        "<td>" + name + "</td>" +
                                    "</tr>" +

                                    "<tr>" +
                                        "<th>Email</th>" +
                                        "<td>" + email + "</td>" +
                                    "</tr>" +

                                    "<tr>" +
                                        "<th>User Type</th>" +
                                        "<td><span class='badge bg-primary'>" + type + "</span></td>" +
                                    "</tr>" +

                                    "<tr>" +
                                        "<th>Status</th>" +
                                        "<td>" + statusBadge + "</td>" +
                                    "</tr>" +

                                    "<tr>" +
                                        "<th>Created</th>" +
                                        "<td>" + created + "</td>" +
                                    "</tr>" +

                                    "<tr>" +
                                        "<th>Last Updated</th>" +
                                        "<td>" + (updated ? updated : "No Update Yet") + "</td>" +
                                    "</tr>" +

                                "</table>" +

                                // ==========================
                                // Action Buttons
                                // ==========================

                                "<div class='d-grid gap-2'>" +

                                    // Edit User
                                    "<button class='btn btn-primary' onclick='editUser(" + id + ")'>" +
                                        "<i class='fa fa-edit'></i> Edit User" +
                                    "</button>" +

                                    // Activate / Deactivate Button
                                    statusButton +

                                "</div>";

                        }
                        // Agar User Record na mile
                        else {

                            var content =

                                "<div class='alert alert-danger text-center'>" +
                                    "<i class='fa fa-exclamation-circle'></i> No User Found." +
                                "</div>";

                        }

                        // Details Panel me Content Show karo
                        $("#details").html(content);

                    },

                    // Agar AJAX Error aaye
                    error: function () {

                        $("#details").html(

                            "<div class='alert alert-danger'>" +
                                "Unable to load user details." +
                            "</div>"

                        );

                    }

                });

            }

          // =========================================
          // Change User Status
          // Purpose:
          // User ko Active ya Inactive karna
          // aur screen ko automatically refresh karna.
          // =========================================
       function changeStatus(id, status) {

            $.ajax({

                type: "POST",

                url: "Model/user_status.php",

                data: {
                    id: id,
                    status: status
                },

                success: function(response) {

                    response = response.trim();

                    if (response === "success") {

                        // User list refresh
                        loadUsers();

                        // User details refresh
                        loadDetails(id);

                    } else {

                        alert(response);

                    }
                },

                error: function(xhr) {

                    alert("Error : " + xhr.responseText);

                }
            });
        }

        $(document).on("click", ".toggle-user-status-btn", function(e) {

                e.preventDefault();

                var userId = $(this).data("id");
                var userStatus = $(this).data("status");

                changeStatus(userId, userStatus);

            });

          // =========================================
          // Open Settings Page
          // Purpose:
          // Settings link par click karne par
          // Settings Content Dynamic Load karna.
          // =========================================
          $(document).on("click", "#setting_link", function (e) {

              // Link ka default action stop karo
              e.preventDefault();

              // Dynamic Content Area me Settings Page Load karo
              $("#dynamic_content").load("content-files/add-setting-content.php");

          });

          // =========================================
          // Function Name : deleteDetails()
          // Description   : Delete selected user
          // Parameters    :
          //      id -> User ID
          // Returns       : None
          // =========================================
          function deleteDetails(id) {

              // Delete Confirmation
              if (confirm("Are you sure you want to delete this user?")) {

                  $.ajax({

                      // Send Request
                      type: "GET",

                      // PHP Delete File
                      url: "Model/user_delete_file.php?id=" + id,

                      // Delete Success
                      success: function (response) {

                          // Refresh User List
                          loadUsers();

                          // Clear Right Panel
                          $("#details").html(

                              "<div class='alert alert-success text-center'>" +
                                  "<i class='fa fa-check-circle'></i> User deleted successfully." +
                              "</div>"

                          );

                      },

                      // Delete Failed
                      error: function () {

                          $("#details").html(

                              "<div class='alert alert-danger text-center'>" +
                                  "<i class='fa fa-times-circle'></i> Unable to delete user." +
                              "</div>"

                          );

                      }

                  });

              }

          }


           // =========================================
          // Function Name : editUser()
          // Description   : Load selected user data
          //                 into editable form.
          // Parameters    :
          //      id -> User ID
          // Returns       : None
          // =========================================
          function editUser(id) {

              $.ajax({

                  // Get User Details
                  type: "GET",

                  url: "Model/user_details.php",

                  dataType: "json",

                  success: function (data) {

                      // Check User Exists
                      if (data[id]) {

                          // User Record
                          var user = data[id];

                          // Edit Form
                          var content =

                          "<h5 class='mb-3'><b>Edit User</b></h5>" +

                          "<input type='hidden' id='edit_id' value='" + id + "'>" +

                          // Name
                          "<div class='mb-3'>" +
                              "<label class='form-label'><b>Name</b></label>" +
                              "<input type='text' class='form-control' id='edit_name' value='" + user.name + "'>" +
                          "</div>" +

                          // Email
                          "<div class='mb-3'>" +
                              "<label class='form-label'><b>Email</b></label>" +
                              "<input type='email' class='form-control' id='edit_email' value='" + user.email + "'>" +
                          "</div>" +

                          // Password
                          "<div class='mb-3'>" +
                              "<label class='form-label'><b>Password</b></label>" +
                              "<input type='password' class='form-control' placeholder='******' autocomplete='new-password' id='edit_password' value=''>" +
                          "</div>" +

                          // User Type
                          "<div class='mb-3'>" +
                              "<label class='form-label'><b>User Type</b></label>" +
                              "<select class='form-select' id='edit_type'>" +
                                  "<option value='Student' " + (user.type === 'Student' ? 'selected' : '') + ">Student</option>" +
                                  "<option value='Teacher' " + (user.type === 'Teacher' ? 'selected' : '') + ">Teacher</option>" +
                                  "<option value='Admin' " + (user.type === 'Admin' ? 'selected' : '') + ">Admin</option>" +
                              "</select>" +
                          "</div>" +

                          // Save Button
                          "<div class='d-grid'>" +

                              "<button class='btn btn-success' onclick='updateUser()'>" +

                                  "<i class='fa fa-save'></i> Save Changes" +

                              "</button>" +

                          "</div>";

                          // Show Form
                          $("#details").html(content);

                      } else {

                          $("#details").html(

                              "<div class='alert alert-danger text-center'>" +
                                  "<i class='fa fa-exclamation-circle'></i> User not found." +
                              "</div>"

                          );

                      }

                  },

                  // AJAX Error
                  error: function () {

                      $("#details").html(

                          "<div class='alert alert-danger text-center'>" +
                              "<i class='fa fa-times-circle'></i> Unable to load user details." +
                          "</div>"

                      );

                  }

              });

          }


          // =========================================
          // Function Name : updateUser()
          // Description   :
          // Save edited user information into database.
          // Parameters    : None
          // Returns       : None
          // =========================================
          function updateUser() {

              // ==========================
              // Get Updated Form Values
              // ==========================

              var id       = $("#edit_id").val();
              var name     = $("#edit_name").val().trim();
              var email    = $("#edit_email").val().trim();
              var password = $("#edit_password").val().trim();
              var type     = $("#edit_type").val();

              // ==========================
              // Basic Validation
              // ==========================

              if (name == "") {
                  alert("Please enter user name.");
                  return;
              }

              if (email == "") {
                  alert("Please enter email.");
                  return;
              }

              // ==========================
              // Send Updated Data to PHP
              // ==========================

              $.ajax({

                  // Request Type
                  type: "POST",

                  // PHP Update File
                  url: "Model/user_update.php",

                  // Send Data
                  data: {

                      id: id,
                      name: name,
                      email: email,
                      password: password,
                      type: type

                  },

                  // ==========================
                  // Update Successful
                  // ==========================

                  success: function (response) {

                      response = response.trim();

                      if (response == "success") {

                          alert("User updated successfully.");

                          // Refresh Right Side Details
                          loadDetails(id);

                          // Refresh Left Side User List
                          loadUsers();

                      } else {

                          alert(response);

                      }

                  },

                  // ==========================
                  // AJAX Error
                  // ==========================

                  error: function (xhr) {

                      alert("Update Failed : " + xhr.responseText);

                  }

              });

          }

          $(document).on("click", "#setting_link", function(e){
         e.preventDefault();
        $("#dynamic_content").load("content-files/add-setting-content.php");
        });

    </script>