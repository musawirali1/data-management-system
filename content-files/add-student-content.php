<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
          >
            <h1 class="h2">Add Student Record</h1>
          </div>

          
     <!-- PHP CODE -->
        <?php
        
            if (!empty($_GET['name'])){ 
                $name = $_GET['name'];
            }   
            else{
                $name = "";
            } 
             if (!empty($_GET['roll_no'])){ 
                $roll_no = $_GET['roll_no'];
            }   
            else{
                $roll_no = "";
            } 
             if (!empty($_GET['father_name'])){ 
                $father_name = $_GET['father_name'];
            }   
            else{
                $father_name = "";
            } 
             if (!empty($_GET['address'])){ 
                $address = $_GET['address'];
            }   
            else{
                $address = "";
            } 
            
            if (!empty($_GET)) {

                // FORM sy value GET .
                $name = $_GET['name'];
                $roll_no = $_GET['roll_no'];
                $father_name = $_GET['father_name'];
                $address = $_GET['address'];
              
                    ?>
                     <div class="container mt-5">
                        <div class="row justify-content-center">
                         <div class="col-md-6 col-lg-5">
                          <div class="card p-4">
                    <?php  
                    if (empty($name)) {
                        echo "<p class='text-danger text-center'>Name is required.</p>";
                    }
                    if (empty($roll_no)) {
                        echo "<p class='text-danger text-center'>Roll Number is required.</p>";
                    }
                    if (empty($father_name)) {
                        echo "<p class='text-danger text-center'>Father Name is required.</p>";
                    }
                    if (empty($address)){
                        echo "<P class='text-danger text-center'>Address is required.</p>";
                    }

                    // Step 4: All fields filled — show success
                    if (!empty($name) && !empty($roll_no) && !empty($father_name) && !empty($address)) {
                      
                        include('db-connection.php');
                         // Insert data into database
                        $sql="INSERT INTO students(name,roll_no,father_name,address,created_at)
                              VALUES('$name','$roll_no','$father_name','$address',NOW())";

                        // Execute SQL query
                        if ($conn->query($sql) === TRUE) {
                            echo "New record created successfully";
                        } else {
                            // Log error
                            error_log("Error: " . $sql . "\n" . $conn->error);
                            
                            // Output error message
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }

                        // Close database connection
                        $conn->close();

                        
                            echo "New records created successfully";
                            $record_succes = 1;

                          
                        echo "<p class='text-success text-center'>Data received successfully!</p>";
                        echo "<h5 class='text-center mb-3 text-success'>Student Details</h5>";
                        echo "<hr>";
                        echo "  <div class='row mb-2'>
                                <div class='col-5 fw-bold'>Name:</div>
                                <div class='col-7'>$name</div>
                                </div>

                                <div class='row mb-2'>
                                <div class='col-5 fw-bold'>Roll No:</div>
                                <div class='col-7'>$roll_no</div>
                                </div>

                                <div class='row mb-2'>
                                <div class='col-5 fw-bold'>Father Name:</div>
                                <div class='col-7'>$father_name</div>
                                </div>

                                <div class='row'>
                                <div class='col-5 fw-bold'>Address:</div>
                                <div class='col-7'>$address</div>
                                </div>
                                ";
                    }

                    ?>                  
                          </div>
                         </div>
                        </div>
                     </div>  

                       <?php 
                }
               
              
        ?>
        <?php
        if(!isset($record_succes)) {
          $record_succes = 0;
        }

        if ( $record_succes != 1 ) { 
        ?>

        
      <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
          <div class="card p-4">
            <h3 class="text-center mb-4">Student Registration Form</h3>

            <form action="" method="GET">
              <div class="mb-3">
                <label for="name" class="form-label">Student Name: </label>
                <input
                  type="text"
                  name="name"
                  value="<?php echo $name; ?>"
                  class="form-control"
                  placeholder="Enter your name"
                 
                />
              </div>

              <div class="mb-3">
                <label for="roll_no" class="form-label">Roll No:</label>
                <input type="text" name="roll_no" value="<?php echo $roll_no; ?>" class="form-control" placeholder="Enter your Roll no"
                 
                />
              </div>

              <div class="mb-3">
                <label for="father_name" class="form-label">Father Name:</label>
                <input type="text" name="father_name"  value="<?php echo $father_name; ?>" class="form-control" placeholder="Enter your Father name"
                 
                />
              </div>

              <div class="mb-3">
                <label for="address"> Address: </label>
                <textarea name="address" class="form-control" rows="2"><?php echo $address; ?></textarea>
              </div>
              <button type="submit" name="submit" class="btn btn-primary w-100">
                Add Student
              </button>
             <div class="mt-3">
              <a href="Student_Form.php" class="btn btn-secondary w-100">Reset</a>
             </div>
             
              
            </form>
          </div>
        </div>
      </div>
    </div>
         <?php } ?>
        </main>