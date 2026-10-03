<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  <h2 class="text-primary"><b>Fee Record Management</b></h2>
  <p class="text-muted">Add New Fee Record 💰</p>
</div>

        <?php
        include('function.php');
        include('db-connection.php');

        // Default values
        $amount = $_GET['amount'] ?? "";
        $date = $_GET['date'] ?? "";
        $student_id = $_GET['student_id'] ?? "";

        if(!empty($_GET)){
        ?>

        <div class="container mt-4">
        <div class="row justify-content-center">
        <div class="col-md-6">
        <div class="card p-4 shadow-sm">

        <?php

        // Validation
        if(empty($amount)){
          echo "<p class='text-danger text-center'>Amount is required.</p>";
        }

        if(empty($date)){
          echo "<p class='text-danger text-center'>Date is required.</p>";
        }

        if(empty($student_id)){
          echo "<p class='text-danger text-center'>Student selection is required.</p>";
        }

        // Insert
        if(!empty($amount) && !empty($date) && !empty($student_id)){

          $sql = "INSERT INTO fees (student_id, amount, fee_date, created_at)
                  VALUES ('$student_id','$amount','$date',NOW())";

          if($conn->query($sql) === TRUE){

            echo "<p class='text-success text-center'>Fee Record Saved Successfully!</p>";

            echo "<h5 class='text-center text-success'>Fee Details</h5><hr>";

            echo "<p><b>Amount:</b> $amount</p>";
            echo "<p><b>Date:</b> $date</p>";
            echo "<p><b>Student ID:</b> $student_id</p>";

            echo "<p class='text-muted'>
              <b>Created:</b> ".custom_time_convert(date('Y-m-d H:i:s'))."
              </p>";

            $record_success = 1;
          }
        }
        ?>

        </div>
        </div>
        </div>
        </div>

        <?php } ?>

        <?php
        if(!isset($record_success)){
          $record_success = 0;
        }

        if($record_success != 1){
        ?>

        <div class="container mt-4">
        <div class="row justify-content-center">
        <div class="col-md-6">
        <div class="card p-4 shadow-sm">

        <h4 class="text-center mb-4">Add Fee Record</h4>

        <form method="GET">

        <!-- Amount -->
        <div class="mb-3">
        <label class="form-label">Amount</label>
        <input type="number" name="amount"
        value="<?php echo $amount; ?>"
        class="form-control"
        placeholder="Enter Fee Amount">
        </div>

        <!-- Date -->
        <div class="mb-3">
        <label class="form-label">Date</label>
        <input type="date" name="date"
        value="<?php echo $date; ?>"
        class="form-control">
        </div>

        <!-- Student Dropdown -->
        <div class="mb-3">
        <label class="form-label">Select Student</label>
        <select name="student_id" class="form-control">
          <option value="">- Select Student  -</option>

          <?php
          $res = $conn->query("SELECT id, name FROM students");

          while($row = $res->fetch_assoc()){
            $selected = ($student_id == $row['id']) ? "selected" : "";
            echo "<option value='".$row['id']."' $selected>".$row['name']." (ID: ".$row['id'].")</option>";
          }
          ?>

        </select>
        </div>

        <!-- Buttons -->
        <button type="submit" class="btn btn-primary w-100">
          Save Fee
        </button>

        <div class="mt-2">
        <a href="dashboard.php?page=add-fee" class="btn btn-secondary w-100">
          Reset
        </a>
        </div>

        </form>

        </div>
        </div>
        </div>
        </div>

        <?php } ?>

</main>