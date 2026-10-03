    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Add User Record</h1>
    </div>

    <?php
    include('db-connection.php');

   $User_Name = "";

    // User ki Reference ID (Student ya Teacher ki ID)
    if(!empty($_POST['Reference_ID'])){
        $Reference_ID = $_POST['Reference_ID'];
    }else{
        $Reference_ID = "";
    }

    if(!empty($_POST['User_Email'])){
      $User_Email = $_POST['User_Email'];
    }else{
      $User_Email = "";
    }

    if(!empty($_POST['User_Password'])){
      $User_Password = $_POST['User_Password'];
    }else{
      $User_Password = "";
    }
    if(!empty($_POST['User_Type'])){
      $User_Type = $_POST['User_Type'];
    }else{
      $User_Type = "";
    }



    if(isset($_POST['add_user'])){

    ?>

    <div class="container mt-5">
    <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
    <div class="card p-4">

    <?php

      if(empty($Reference_ID)){
    echo "<p class='text-danger'>Reference is required.</p>";
}

    if(empty($User_Email)){
    echo "<p class='text-danger text-center'>Email is required.</p>";
    }


    if(empty($User_Password)){
    echo "<p class='text-danger text-center'>Password is required.</p>";
    }

    if(empty($User_Type)){
    echo "<p class='text-danger text-center'>Type is required.</p>";
    }

    if(!empty($Reference_ID) && !empty($User_Email) && !empty($User_Password) && !empty($User_Type)){



    if($User_Type=="Student"){

    $sql_name="SELECT name FROM students WHERE id='$Reference_ID'";

      }else{

          $sql_name="SELECT name FROM teachers WHERE id='$Reference_ID'";

      }

      $result_name=$conn->query($sql_name);

      $row_name=$result_name->fetch_assoc();

      $User_Name=$row_name['name'];
      // Password ko SHA1 me Encrypt karo
     $User_Password = sha1($User_Password);

      $sql = "INSERT INTO users (  User_Name,
                                              User_Email,
                                              User_Password,
                                              User_Type,
                                              Reference_ID,
                                              User_Status,
                                              created_at)
                                    VALUES
                                            (
                                                '$User_Name',
                                                '$User_Email',
                                                '$User_Password',
                                                '$User_Type',
                                                '$Reference_ID',
                                                'Active',
                                                NOW()
                                            )";

    if($conn->query($sql) === TRUE){
    echo "<p class='text-success text-center'>User Record Added Successfully!</p>";
    $record_success = 1;
    }

    echo "<h5 class='text-center text-success'>User Details</h5>";
    echo "<hr>";

    echo "<div class='row mb-2'>
    <div class='col-5 fw-bold'>User Name:</div>
    <div class='col-7'>$User_Name</div>
    </div>

    <div class='row mb-2'>
    <div class='col-5 fw-bold'>User Email:</div>
    <div class='col-7'>$User_Email</div>
    </div>

    <div class='row mb-2'>
    <div class='col-5 fw-bold'>User Type:</div>
    <div class='col-7'>$User_Type</div>
    </div>";

    $conn->close();

    }

    ?>

    </div>
    </div>
    </div>
    </div>

    <?php
    }

    $record_success = 0;

    if(!isset($record_success)){
  
    }

    if($record_success != 1){
    ?>

    <div class="container mt-5">
    <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
    <div class="card p-4">

    <h3 class="text-center mb-4">User Form</h3>

 <form method="POST" autocomplete="off">

    <!-- =========================
         User Type Dropdown
    ========================== -->
    <div class="mb-3">
        <label class="form-label">User Type:</label>

        <select name="User_Type" class="form-select" onchange="this.form.submit()">
            <option value="">Select User Type</option>

               <option value="Admin" <?php if($User_Type=="admin") echo "selected"; ?>>
                Admin
            </option>

            <option value="Student" <?php if($User_Type=="Student") echo "selected"; ?>>
                Student
            </option>

            <option value="Teacher" <?php if($User_Type=="Teacher") echo "selected"; ?>>
                Teacher
            </option>
        </select>
    </div>


    <!-- =========================
         Select Student / Teacher
    ========================== -->

    <div class="mb-3">
        <label class="form-label">Select User:</label>

        <select name="Reference_ID" class="form-select">

            <option value="">Select User</option>

            <?php

            // Agar Student select hua hai
            if($User_Type == "Student"){
                $sql = "SELECT id,name FROM students ORDER BY name";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()){

                $selected = "";

                if($Reference_ID == $row['id']){
                    $selected = "selected";
                }

                ?>

                <option value="<?php echo $row['id']; ?>" <?php echo $selected; ?>>
                    <?php echo $row['name']; ?>
                </option>

                <?php
            }
                        }

            // Agar Teacher select hua hai
            elseif($User_Type == "Teacher"){

                $sql = "SELECT id,name FROM teachers ORDER BY name";
                $result = $conn->query($sql);

                while($row = $result->fetch_assoc()){

                  $selected = "";

                  if($Reference_ID == $row['id']){
                      $selected = "selected";
                  }

                  ?>

                  <option value="<?php echo $row['id']; ?>" <?php echo $selected; ?>>
                      <?php echo $row['name']; ?>
                  </option>

                  <?php
              }

            }

            ?>

        </select>
    </div>


    <!-- =========================
         Email
    ========================== -->

    <div class="mb-3">
        <label class="form-label">User Email:</label>

        <input type="email"
               name="User_Email"
               value=""
               class="form-control"
               placeholder="Enter Email">
    </div>


    <!-- =========================
         Password
    ========================== -->

    <div class="mb-3">
        <label class="form-label">Password:</label>

        <input type="password"
               name="User_Password"
               value=""
               autocomplete="new-password"
               class="form-control"
               placeholder="Enter Password">
    </div>


    <!-- =========================
         Submit Button
    ========================== -->

    <button type="submit"  name="add_user"  class="btn btn-primary w-100">
        Add User
    </button>

    <div class="mt-3">
        <button type="reset" class="btn btn-secondary w-100">
            Reset
        </button>
    </div>

</form>

    </div>
    </div>
    </div>
    </div>

    <?php } ?>

    </main>