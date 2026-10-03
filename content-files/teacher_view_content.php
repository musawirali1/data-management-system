
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
          >
          <h2 class="text-primary"><b>Teacher Data View</b></h2>
          <h5 class="text-muted">Welcome to Teacher View Page 👋</h5>
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
            
            <button id="loadBtn" class="btn btn-primary">Load Teacher List</button>
            <button id="unloadBtn" class="btn btn-light"> Unload  </button>
            <button id="resetBtn" class="btn btn-primary">Reset Button</button>
          </div>
        </div>

        <div class="col-md-4">
          <div class="btn-group " style="padding-left: 65px;">
            
            <a href="add-teacher-form.php" class="btn btn-primary">
              Add Teacher
            </a>
       
          </div>
        </div>
      </div>

      <br /><br />

  
      <!-- Search Teacher -->
        <div class="search-card">
          
        <div class="row align-items-center">
        <div class="col-md-2">

        <h5 class="mb-0 text-primary">
        Search Teacher
        </h5>
        </div>

        <div class="col-md-4">
       <div class="input-group position-relative">

        <input 
        type="text"
        id="searchTeacher"
        class="form-control"
        placeholder="Search Teacher Name...">

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
            <h4>Teacher List</h4>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th width="220"> Action </th>
                    </tr>
                </thead>
                <tbody id="teacherTable"></tbody>
            </table>
          </div>
          
        </div>
      
      
      <!-- Right Details-->

      <div class="col-md-4">
        <div class="card">
            <h4><b>Teacher Details</b></h4>
            <div id="details" class="text-muted text-center">Select a Teacher to view details</div>
        </div>
      </div>

      </div>
        
      </div>
    </div>
    <script>
      $(document).ready(function () {
        $("#loadBtn").click(function () {
         $("#teacherTable").html(""); 

          $.ajax({
            type: "GET",
            url: "Model/teacher_data.php",
            dataType: "json",
            success: function (data) {
           

              $.each(data, function (index, teachers) {
                //console.log(this.id + this.name);
                var id = this.id;
                var name = this.name;

               var content =
                            "<tr>" +
                                "<td>" + teachers.name + "</td>" +

                                "<td class='text-end text-nowrap'>" +

                                    "<button class='btn btn-info btn-sm me-2' onclick='loadDetails(" + teachers.id + ")'>" +
                                        "<i class='fa fa-eye'></i> View" +
                                    "</button>" +

                                    "<button class='btn btn-danger btn-sm' onclick='deleteDetails(" + teachers.id + ")'>" +
                                        "<i class='fa fa-trash'></i> Delete" +
                                    "</button>" +

                                "</td>" +
                            "</tr>";

                $("#teacherTable").append(content);
              });
            },
            error: function () {
              console.log("Error loading the XML file");
            },
          });
        });

        $("#unloadBtn").click(function () {
          $("#teacherTable").html("");
        });

        $("#resetBtn").click(function () {
          $("#details , #teacherTable").html("");
        });

        // Auto Complete Search

          $("#searchTeacher").keyup(function(){
          var search = $(this).val().trim().toLowerCase();
          if(search.length == 0){
          $("#suggestions").html("");
          return;
          }

          $.ajax({

          type:"GET",

          url:"Model/teacher_autocomplete.php",

          data:{
          search:search
          },

          dataType:"json",
          success:function(data){

    
          $("#suggestions").html("");

          $.each(data,function(index,teacher){
          
          var content = "<div class='suggestion-item' data-id='"+teacher.id+"'>"+ teacher.name+ "</div>";
          $("#suggestions").append(content);

          });
          }

          });

          });

          $(document).on("click",".suggestion-item",function(){


            var teacherId = $(this).data("id");

            var teacherName = $(this).text();


            // input me name show karo
            $("#searchTeacher").val(teacherName);


            // suggestion hide
            $("#suggestions").html("");


            // table load
            loadTeacherSearch(teacherId);


            function loadTeacherSearch(id){


            $.ajax({

            type:"GET",
            url:"Model/teacher_search_by_id.php",
            data:{
            id:id
            },

            dataType:"json",

            success:function(teacher){


            $("#teacherTable").html("");


            var content =

            "<tr>"+
            "<td>"+teacher.name+"</td>"+
            "<td>"+

            "<button class='btn btn-info btn-sm' onclick='loadDetails("+teacher.id+")'>View</button>"+

            "<button class='btn btn-danger btn-sm ' onclick='deleteDetails("+teacher.id+")'>Delete</button>"+

            "</td>"+
            "</tr>";


            $("#teacherTable").append(content);


            },


            error:function(){

            console.log("Teacher Load Error");

            }

            });

            }
         
        });


        

      });

      function loadDetails(id) {
        //$("#details").load("details.php?id=" + id);
        $.ajax({
          type: "GET",
          url: "Model/teacher_details.php",
          dataType: "json",
          success: function (data) {
            if (data[id]) {
              var name = data[id].name;
              var subject = data[id].subject;
              var email = data[id].email;
              var phone = data[id].phone;
              var created = data[id].created_at;
              var updated = data[id].updated_at;


              var content =
              "<p><b>Name:</b> " + name + "</p>" +

              "<p><b>Subject:</b> " + subject + "</p>" +

              "<p><b>Email:</b> " + email + "</p>" +

              "<p><b>Phone:</b> " + phone + "</p>" +

              "<hr>"+

                "<p class='text-muted'>"+
                "<small><b>Created:</b> "+created+"</small>"+
                "</p>"+


                "<p class='text-muted'>"+
                "<small><b>Last Updated:</b> "+
                (updated ? updated : "No Update Yet")
                +"</small>"+
                "</p>" +

              "<button class='btn btn-primary btn-sm mt-2' onclick='editTeacher("+id+")'>Edit</button>";
             
            } else {
              var content = "<p class='text-danger'>No record found!</p>";
            }
            

            $("#details").html(content);
          },
          error: function () {
            console.log("Error loading the XML file");
          },
        });
      }
          $(document).on("click", "#setting_link", function(e){
    e.preventDefault();
    $("#dynamic_content").load("content-files/add-setting-content.php");
});


  function deleteDetails(id) {

          if(confirm("Are you sure you want to delete?")){

            $.ajax({
              type: "GET",
              url: "Model/teacher_delete_file.php?id=" + id,

              success: function () {
                $("#teacherTable").html("");
                $("#loadBtn").click();

                // clear right panel
                $("#details").html("<p style='color:red;'>Teacher Deleted</p>");
              },

              error: function(){
                console.log("Delete failed");
              }

            });

          }
        }




        function editTeacher(id){


          $.ajax({

          type:"GET",

          url:"Model/teacher_details.php",

          dataType:"json",


          success:function(data){


          var teacher = data[id];


          var content =

          "<input type='hidden' id='edit_id' value='"+id+"'>"+


          "<p><b>Name:</b></p>"+
          "<input class='form-control' id='edit_name' value='"+teacher.name+"'>"+


          "<p><b>Subject:</b></p>"+
          "<input class='form-control' id='edit_subject' value='"+teacher.subject+"'>"+


          "<p><b>Email:</b></p>"+
          "<input class='form-control' id='edit_email' value='"+teacher.email+"'>"+


          "<p><b>Phone:</b></p>"+
          "<input class='form-control' id='edit_phone' value='"+teacher.phone+"'>"+


          "<button class='btn btn-success mt-3' onclick='updateTeacher()'>Save Update</button>";



          $("#details").html(content);



          }


          });


          }

          function updateTeacher(){


            var id = $("#edit_id").val();

            var name = $("#edit_name").val();

            var subject = $("#edit_subject").val();

            var email = $("#edit_email").val();

            var phone = $("#edit_phone").val();



            $.ajax({

            type:"POST",

            url:"Model/teacher_update.php",

            data:{


            id:id,

            name:name,

            subject:subject,

            email:email,

            phone:phone


            },


            success:function(response){


            alert("Teacher Updated Successfully");


            // reload details

            loadDetails(id);


            },


            error:function(){

            alert("Update Failed");

            }


            });


            }
          $(document).on("click", "#setting_link", function(e){
         e.preventDefault();
        $("#dynamic_content").load("content-files/add-setting-content.php");
        });
    </script>
 

  
