    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Add Teacher Record</h1>
    </div>

    <?php
    

    if(!empty($_GET['name'])){
      $name = $_GET['name'];
    }else{
      $name = "";
    }

    if(!empty($_GET['subject'])){
      $subject = $_GET['subject'];
    }else{
      $subject = "";
    }

    if(!empty($_GET['email'])){
      $email = $_GET['email'];
    }else{
      $email = "";
    }
    if(!empty($_GET['phone'])){
      $phone = $_GET['phone'];
    }else{
      $phone = "";
    }



    if(!empty($_GET)){

    ?>

    <div class="container mt-5">
    <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
    <div class="card p-4">

    <?php

    if(empty($name)){
    echo "<p class='text-danger text-center'>Teacher Name is required.</p>";
    }

    if(empty($subject)){
    echo "<p class='text-danger text-center'>Subject is required.</p>";
    }


    if(empty($email)){
    echo "<p class='text-danger text-center'>Teacher Email is required.</p>";
    }

    if(empty($phone)){
    echo "<p class='text-danger text-center'>Phone is required.</p>";
    }

    if(!empty($name) && !empty($subject) && !empty($email)  && !empty($phone)){

    include('db-connection.php');

      $sql=" INSERT INTO teachers (name,subject,email,phone,created_at)
            VALUES ('$name','$subject','$email','$phone',NOW())";

    if($conn->query($sql) === TRUE){
    echo "<p class='text-success text-center'>Teacher Record Added Successfully!</p>";
    $record_success = 1;
    }

    echo "<h5 class='text-center text-success'>Teacher Details</h5>";
    echo "<hr>";

    echo "<div class='row mb-2'>
    <div class='col-5 fw-bold'>Teacher Name:</div>
    <div class='col-7'>$name</div>
    </div>

    <div class='row mb-2'>
    <div class='col-5 fw-bold'>Teacher Email:</div>
    <div class='col-7'>$email</div>
    </div>

    <div class='row mb-2'>
    <div class='col-5 fw-bold'>Subject:</div>
    <div class='col-7'>$subject</div>
    </div>

    <div class='row mb-2'>
    <div class='col-5 fw-bold'>Address:</div>
    <div class='col-7'>$phone</div>
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

    if(!isset($record_success)){
    $record_success = 0;
    }

    if($record_success != 1){
    ?>

    <div class="container mt-5">
    <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
    <div class="card p-4">

    <h3 class="text-center mb-4">Teacher Registration Form</h3>

    <form method="GET">

    <div class="mb-3">
    <label class="form-label">Teacher Name:</label>
    <input type="text" name="name"
    value="<?php echo $name; ?>"
    class="form-control" placeholder="Enter your Name">
    </div>

    <div class="mb-3">
    <label class="form-label">Teacher Email:</label>
    <input type="email" name="email"
    value="<?php echo $email; ?>"
    class="form-control " placeholder="Enter your mail">


    </div>

    <div class="mb-3">
    <label class="form-label">Subject:</label>
    <input type="text" name="subject"
    value="<?php echo $subject; ?>"
    class="form-control"
    placeholder="Enter your Subject">
    </div>

    <div class="mb-3">
    <label class="form-label">Phone:</label>
    <input type="number" name="phone"
    value="<?php echo $phone; ?>"
    class="form-control"
    placeholder="Enter your phone">
    </div>



    <button type="submit" class="btn btn-primary w-100">
    Add Teacher
    </button>

    <div class="mt-3">
    <a href="Teacher_Form.php" class="btn btn-secondary w-100">Reset</a>
    </div>

    </form>

    </div>
    </div>
    </div>
    </div>

    <?php } ?>

    </main>