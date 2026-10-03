<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
          >
          <h2 class="text-primary"><b>Fees Data View</b></h2>
          <h5 class="text-muted">Welcome to Fees View Page 👋</h5>
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
            
            <button id="loadBtn" class="btn btn-primary">Load Fees Record</button>
            <button id="unloadBtn" class="btn btn-light"> Unload  </button>
            <button id="resetBtn" class="btn btn-primary">Reset Button</button>
          </div>
        </div>

        <div class="col-md-4">
          <div class="btn-group " style="padding-left: 65px;">
            
            <a href="add-fees-form.php" class="btn btn-primary">
              Add Fees
            </a>
          </div>
        </div>
      </div>

      <br /><br />

      <!-- Search Fee -->
        <div class="search-card">
          
        <div class="row align-items-center">
        <div class="col-md-2">

        <h5 class="mb-0 text-primary">
        Search Fee
        </h5>
        </div>

        <div class="col-md-4">
       <div class="input-group position-relative">

        <input 
        type="text"
        id="searchFee"
        class="form-control"
        placeholder="Search Student Name...">

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
            <h4>Fees List</h4>
            <table class="table table-hover">
                <thead>
                    <tr>

                  <th>Name</th>
                  <th>Amount</th>
                  <th>Date</th>
                  <th>Action</th>

                  </tr>
                </thead>
                <tbody id="feeTable"></tbody>
            </table>
          </div>
          
        </div>
      
      
      <!-- Right Details-->

      <div class="col-md-4">
        <div class="card">
            <h4><b>Fees Details</b></h4>
            <div id="details" class="text-muted text-center">Select a User to view details</div>
        </div>
      </div>

      </div>
        
      </div>
    </div>
   <script>

        $(document).ready(function () {

            // LOAD ALL FEES
            $("#loadBtn").click(function () {

                $("#feeTable").html("");

                $.ajax({
                    type: "GET",
                    url: "Model/fees_data.php",
                    dataType: "json",

                    success: function (data) {

                        $.each(data, function (index, user) {

                            var content =
                            "<tr>" +
                            "<td>" + user.name + "</td>" +
                            "<td>Rs. " + user.amount + "</td>" +
                            "<td>" + user.fee_date + "</td>" +
                            "<td>" +
                            "<button class='btn btn-info btn-sm' onclick='loadDetails(" + user.id + ")'>View</button> " +
                            "<button class='btn btn-danger btn-sm' onclick='deleteDetails(" + user.id + ")'>Delete</button>" +
                            "</td>" +
                            "</tr>";

                            $("#feeTable").append(content);
                        });

                    },

                    error: function () {
                        console.log("Error loading fee records");
                    }
                });

            });

            // UNLOAD
            $("#unloadBtn").click(function () {
                $("#feeTable").html("");
            });

            // RESET
            $("#resetBtn").click(function () {

                $("#feeTable").html("");
                $("#details").html("Select a User to view details");
                $("#searchFee").val("");
                $("#suggestions").html("");

            });

            // AUTO COMPLETE SEARCH
            $("#searchFee").keyup(function () {
                var search = $(this).val().trim();

                if (search.length == 0) {

                    $("#suggestions").html("");
                    return;
                }

                $.ajax({

                    type: "GET",
                    url: "Model/fee_autocomplete.php",

                    data: {
                        search: search
                    },

                    dataType: "json",
                    success: function (data) {

                        $("#suggestions").html("");

                        if (data.length == 0) {

                            $("#suggestions").html(
                                "<div class='suggestion-item'>No Student Found</div>"
                            );
                            return;
                        }

                        $.each(data, function (index, student) {

                            var content =
                            "<div class='suggestion-item' data-id='" + student.id + "'>" +
                            student.name +
                            "</div>";

                            $("#suggestions").append(content);

                        });

                    },

                    error: function () {
                        console.log("Autocomplete Error");
                    }

                });

            });

            // SELECT STUDENT
            $(document).on("click", ".suggestion-item", function () {

                var studentId = $(this).data("id");
                var studentName = $(this).text();

                $("#searchFee").val(studentName);
                $("#suggestions").html("");

                loadFee(studentId);

            });

        });


        // SEARCHED STUDENT FEES
        function loadFee(studentId) {

            $.ajax({

                type: "GET",

                url: "Model/get_student_fee.php",

                data: {
                    student_id: studentId
                },

                dataType: "json",

                success: function (data) {

                    $("#feeTable").html("");

                    if (data.length == 0) {

                        $("#feeTable").html(
                            "<tr><td colspan='4' class='text-center text-danger'>No Fee Record Found</td></tr>"
                        );

                        return;
                    }

                    $.each(data, function (index, user) {

                        var row =
                        "<tr>" +
                        "<td>" + user.name + "</td>" +
                        "<td>Rs. " + user.amount + "</td>" +
                        "<td>" + user.fee_date + "</td>" +
                        "<td>" +
                        "<button class='btn btn-info btn-sm' onclick='loadDetails(" + user.id + ")'>View</button> " +
                        "<button class='btn btn-danger btn-sm' onclick='deleteDetails(" + user.id + ")'>Delete</button>" +
                        "</td>" +
                        "</tr>";

                        $("#feeTable").append(row);

                    });

                },

               

            });

        }


        // VIEW DETAILS
        function loadDetails(id) {

            $.ajax({

                type: "GET",
                url: "Model/fees_details.php",
                dataType: "json",

                success: function (data) {

                    if (data[id]) {

                        var fee = data[id];

                        var content =
                        "<h5>Fees Details</h5>" +
                        "<p><b>Name:</b> " + fee.name + "</p>" +
                        "<p><b>Amount:</b> Rs. " + fee.amount + "</p>" +
                        "<p><b>Date:</b> " + fee.fee_date + "</p>" +

                        "<hr>" +

                          "<p class='text-muted'><small><b>Created At:</b> " 
                          + fee.created_at +"</small>"+"</p>" +

                          "<p class='text-muted'><small><b>Updated At:</b> " 
                          + (fee.updated_at ? fee.updated_at : "Not Updated") 
                          +"</small>"+ "</p>" +

                        "<button class='btn btn-primary btn-sm mt-2' onclick='editFee("+id+")'>Edit</button>";
                    } else {

                        var content =
                        "<p class='text-danger'>No record found!</p>";

                    }

                    $("#details").html(content);

                },

                error: function () {

                    console.log("Error loading details");

                }

            });

        }


        // DELETE
        function deleteDetails(id) {

            if (confirm("Are you sure you want to delete?")) {

                $.ajax({

                    type: "GET",
                    url: "Model/fees_delete_file.php?id=" + id,

                    success: function () {

                        $("#feeTable").html("");

                        $("#loadBtn").click();

                        $("#details").html(
                            "<p style='color:red;'>Fees Record Deleted</p>"
                        );

                    },

                    error: function () {

                        console.log("Delete failed");

                    }

                });

            }

        }


        function editFee(id){


          $.ajax({

          type:"GET",

          url:"Model/fees_details.php",

          dataType:"json",

          success:function(data){


          var fee=data[id];


          var content =

          "<input type='hidden' id='edit_id' value='"+id+"'>"+


          "<label>Amount</label>"+
          "<input type='number' id='edit_amount' class='form-control' value='"+fee.amount+"'>"+


          "<br>"+


          "<label>Fee Date</label>"+
          "<input type='date' id='edit_date' class='form-control' value='"+fee.fee_date+"'>"+


          "<br>"+


          "<button class='btn btn-success btn-sm' onclick='updateFee()'>Save Update</button>";


          $("#details").html(content);


          }


          });


          }

        function updateFee(){


        var id=$("#edit_id").val();

        var amount=$("#edit_amount").val();

        var date=$("#edit_date").val();



        $.ajax({

        type:"POST",

        url:"Model/fees_update.php",

        data:{
        id:id,
        amount:amount,
        date:date
        },


        success:function(){

        alert("Fee Updated Successfully");

        loadDetails(id);

        }


        });


        }


      // SETTINGS PAGE
      $(document).on("click", "#setting_link", function (e) {

          e.preventDefault();

          $("#dynamic_content").load(
              "content-files/add-setting-content.php"
          );

      });

</script>

  
