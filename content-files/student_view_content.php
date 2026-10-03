

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
          >
          <h2 class="text-primary"><b>Student Data View</b></h2>
          <h5 class="text-muted">Welcome to Student View Page 👋</h5>
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
            
            <button id="loadBtn" class="btn btn-primary">Load Persons</button>
            <button id="unloadBtn" class="btn btn-light"> Unload Persons </button>
            <button id="resetBtn" class="btn btn-primary">Reset Button</button>
           
          </div>
          
        </div>

        <div class="col-md-4">
          <div class="btn-group " style="padding-left: 65px;">
            <a href="add-student-form.php" class="btn btn-primary">
              Add Student
            </a>
          </div>
        </div>
      </div>

      <br>
      <!-- Search Student -->
        <div class="search-card">

        <div class="row align-items-center">
        <div class="col-md-2">

        <h5 class="mb-0 text-primary">
        Search Student
        </h5>
        </div>

        <div class="col-md-4">
       <div class="input-group position-relative">

        <input 
        type="text"
        id="searchStudent"
        class="form-control"
        placeholder="Search Student Name...">

        <div id="suggestions"></div>

        </div>
        </div>

        </div>

      <br />

      <!-- Main Content-->
      <div class="row">
        <!--Left List-->
        <div class="col-md-8">
          <div class="card">
            <h4>Student List</h4>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th width="220"> Action </th>
                    </tr>
                </thead>
                <tbody id="studentsTable"></tbody>
            </table>
          </div>
          
        </div>
      
      <!-- Right Details-->

      <div class="col-md-4">
        <div class="card">
            <h4><b>Student Details</b></h4>
            <div id="details" class="text-muted text-center">Select a student to view details</div>
           
      </div>
       

      </div>
        
      </div>
    </div>
    <script>
      $(document).ready(function () {

      //Load Button 
        $("#loadBtn").click(function () {
           $("#studentsTable").html(""); 

          $.ajax({
            type: "GET",
            url: "Model/students_data.php",
            dataType: "json",
            success: function (data) {
              $.each(data, function (index, students) {
                //console.log(this.id + this.name);
                var id = this.id;
                var name = this.name;
                

                var content =
                "<tr>" +
                    "<td>" + students.name + "</td>" +

                    "<td class='text-end'>" +

                        "<button class='btn btn-info btn-sm me-2' onclick='loadDetails(" + students.id + ")'>" +
                            "<i class='fa fa-eye'></i> View" +
                        "</button>" +

                        "<button class='btn btn-danger btn-sm' onclick='deleteDetails(" + students.id + ")'>" +
                            "<i class='fa fa-trash'></i> Delete" +
                        "</button>" +

                    "</td>" +
                "</tr>";
                $("#studentsTable").append(content);
              });
            },
            error: function () {
              console.log("Error loading the XML file");
            },
          });
        });

        $("#unloadBtn").click(function () {
          $("#studentsTable").html("");
        });

        $("#resetBtn").click(function () {
          $("#details , #studentsTable").html("");
        });



// Auto Complete Search

          $("#searchStudent").keyup(function(){
          var search = $(this).val().trim().toLowerCase();
          if(search.length <= 3){
          $("#suggestions").html("");
          return;
          }

          $.ajax({

          type:"GET",

          url:"Model/student_autocomplete.php",

          data:{
          search:search
          },

          dataType:"json",
          success:function(data){

    
          $("#suggestions").html("");

          $.each(data,function(index,student){
          
          var content = "<div class='suggestion-item' data-id='"+student.id+"'>"+ student.name+ "</div>";
          $("#suggestions").append(content);

          });
          }

          });

          });

          $(document).on("click",".suggestion-item",function(){

            var studentId = $(this).data("id");

            var studentName = $(this).text();


            // input me name show karo
            $("#searchStudent").val(studentName);


            // suggestion hide
            $("#suggestions").html("");


            // table load
            loadStudentSearch(studentId);


            function loadStudentSearch(id){


            $.ajax({

            type:"GET",
            url:"Model/student_search_by_id.php",
            data:{
            id:id
            },

            dataType:"json",

            success:function(student){


            $("#studentsTable").html("");


            var content =

            "<tr>"+
            "<td>"+student.name+"</td>"+
            "<td>"+

            "<button class='btn btn-info btn-sm' onclick='loadDetails("+student.id+")'>View</button>"+

            "<button class='btn btn-danger btn-sm ' onclick='deleteDetails("+student.id+")'>Delete</button>"+

            "</td>"+
            "</tr>";


            $("#studentsTable").append(content);


            },


            error:function(){

            console.log("Student Load Error");

            }

            });

            }
         
        });



      });

// lOAD Details Function
      function loadDetails(id) {
       
        $.ajax({
          type: "GET",
          url: "Model/students_details.php",
          dataType: "json",
          success: function (data) {
            if (data[id]) {
              var roll = data[id].roll;
              var name = data[id].name;
              var father = data[id].father;
              var address = data[id].address;
              var created = data[id].created_at;
              var updated = data[id].updated_at;

              var content =
              "<p><b>Name:</b> " + name + "</p>" +

              "<p><b>Roll No:</b> " + roll + "</p>" +

              "<p><b>Father:</b> " + father + "</p>" +

              "<p><b>Address:</b> " + address + "</p>" +

              "<hr>"+

              "<p class='text-muted'>"+
              "<small><b>Created:</b> "+created+"</small>"+
              "</p>"+

              "<p class='text-muted'>"+
              "<small><b>Last Updated:</b> "+
              (updated ? updated : "No Update Yet")
              +"</small>"+
              "</p>"+

              "<button class='btn btn-primary btn-sm mt-2' onclick='editStudent("+id+")'>Edit</button>";
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

 // Edit Details Function 
      function editStudent(id){


          $.ajax({

          type:"GET",

          url:"Model/students_details.php",

          dataType:"json",


          success:function(data){


          var student = data[id];


          var content =

          "<input type='hidden' id='edit_id' value='"+id+"'>"+


          "<p><b>Name:</b></p>"+
          "<input class='form-control' id='edit_name' value='"+student.name+"'>"+


          "<p><b>Roll No:</b></p>"+
          "<input class='form-control' id='edit_roll' value='"+student.roll+"'>"+


          "<p><b>Father:</b></p>"+
          "<input class='form-control' id='edit_father' value='"+student.father+"'>"+


          "<p><b>Address:</b></p>"+
          "<input class='form-control' id='edit_address' value='"+student.address+"'>"+


          "<button class='btn btn-success mt-3' onclick='updateStudent()'>Save Update</button>";



          $("#details").html(content);



          }


          });


          }




 // Update Details Function 
          function updateStudent(){

            var id = $("#edit_id").val();

            var name = $("#edit_name").val();

            var roll = $("#edit_roll").val();

            var father = $("#edit_father").val();

            var address = $("#edit_address").val();


            $.ajax({
            type:"POST",
            url:"Model/student_update.php",
            data:{
            id:id,
            name:name,
            roll:roll,
            father:father,
            address:address
            },

            success:function(response){

            alert("Student Updated Successfully");

            // dobara details load

            loadDetails(id);
            },


            error:function(){

            alert("Update Failed");

            }

            });
            }



 // Delete Details Function 
       function deleteDetails(id) {

          if(confirm("Are you sure you want to delete?")){

            $.ajax({
              type: "GET",
              url: "Model/student_delete_file.php?id=" + id,

              success: function () {
                $("#studentsTable").html("");
                $("#loadBtn").click();

                // clear right panel
                $("#details").html("<p style='color:red;'>Student Deleted</p>");
              },

              error: function(){
                console.log("Delete failed");
              }

            });

          }
        }
          $(document).on("click", "#setting_link", function(e){
         e.preventDefault();
        $("#dynamic_content").load("content-files/add-setting-content.php");
        });

    </script>
 

  
