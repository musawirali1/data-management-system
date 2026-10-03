<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <div class="dms-header py-3 mb-3 border-bottom">
            <div class="d-flex align-items-center gap-3">
              
              <div>
                <h3 class="dms-title mb-0">Data Management System</h3>
                <hr>
            
                <p class="text-muted mb-0">Admin Dashboard — Manage students, teachers, and fee records</p>
              </div>
            </div>
          </div>
          
             <?php
             // ========================================== 
             // Get General Settings from Database 
             // ==========================================

             $general_setting =[];

             // setting table sy genral setting ke row get karna.
             $sql = "SELECT setting_value
             FROM settings 
             WHERE setting_name = 'genral_setting' 
             LIMIT 1";

             $result = $conn->query($sql);

             if ($result && $result->num_rows > 0) {
              $row = $result ->fetch_assoc();

              //Serialized data ko wapas associative array main convert 
              $general_setting = unserialize($row['setting_value']);
             };

             // Aagar data available  ho to values get karain 

             $school_name = $general_setting['school_name'];
             $school_email = $general_setting['school_email'];
             $phone = $general_setting['phone'];
             $website = $general_setting['website'];
             $address = $general_setting['address'];

            ?>


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
    </style>

 

    
    <div class="container">
      <!-- Heading-->
      <div class="row">
        <div class="col-md-12">
          
          <p class="text-muted">AJAX based dynamic loading.</p>


          <div class="row mb-4">

              <!-- Students -->
              <div class="col-md-3">
                <div class="card bg-primary text-white">
                  <h6>Total Students</h6>
                  <h3>
                    <?php
                    $res = $conn->query("SELECT COUNT(*) as total FROM students");
                    $row = $res->fetch_assoc();
                    echo $row['total'];
                    ?>
                  </h3>
                </div>
              </div>

              <!-- Teachers -->
              <div class="col-md-3">
                <div class="card bg-success text-white">
                  <h6>Total Teachers</h6>
                  <h3>
                    <?php
                    $res = $conn->query("SELECT COUNT(*) as total FROM teachers");
                    $row = $res->fetch_assoc();
                    echo $row['total'];
                    ?>
                  </h3>
                </div>
              </div>

              <!-- Users -->
              <div class="col-md-3">
                <div class="card bg-warning text-dark">
                  <h6>Total Users</h6>
                  <h3>
                    <?php
                    $res = $conn->query("SELECT COUNT(*) as total FROM users");
                    $row = $res->fetch_assoc();
                    echo $row['total'];
                    ?>
                  </h3>
                </div>
              </div>

            

            </div>

          
          <hr />
          
        </div>
      </div>

   
      <div class="row">
        <div class="col-md-12">
          <p class="text-muted">
          Welcome back, Admin 👋 <br> <br>  
          This dashboard provides a quick overview of your system. You can manage students, teachers, and other records efficiently.
          </p>

          </div>
        </div>
      </div>

      <hr> 

    <!-- ==========================================
                     General Settings Card*
          ========================================== -->
        <div class="row mb-4">
          <div class="col-md-12">
            <div class="card border-1 shadow-sm rounded-4">

              <!-- Card Header -->
              <div class="card-header bg-white border-1 rounded-top-4 d-flex align-items-center gap-3 py-4 px-4">
                <div class="d-flex align-items-center justify-content-center rounded-3 bg-primary text-white"
                    style="width:48px;height:48px;">
                  <i class="fas fa-school"></i>
                </div>
                <div>
                  <h5 class="mb-0 fw-semibold">
                    <?php echo htmlspecialchars($school_name); ?>
                  </h5>
                  <small class="text-muted">General Information</small>
                </div>
              </div>

              <!-- Card Body -->
              <div class="card-body px-4 pb-4 pt-2">
                <div class="row g-3">

                  <!-- Email -->
                  <div class="col-md-6">
                    <div class="d-flex align-items-start gap-3 p-3 rounded-3 bg-light border h-100">
                      <div class="d-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary"
                          style="width:38px;height:38px;">
                        <i class="fas fa-envelope"></i>
                      </div>
                      <div>
                        <small class="text-muted d-block">Email</small>
                        <p class="mb-0 fw-medium"><?php echo htmlspecialchars($school_email); ?></p>
                      </div>
                    </div>
                  </div>

                  <!-- Phone -->
                  <div class="col-md-6">
                    <div class="d-flex align-items-start gap-3 p-3 rounded-3 bg-light border h-100">
                      <div class="d-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary"
                          style="width:38px;height:38px;">
                        <i class="fas fa-phone"></i>
                      </div>
                      <div>
                        <small class="text-muted d-block">Phone</small>
                        <p class="mb-0 fw-medium"><?php echo htmlspecialchars($phone); ?></p>
                      </div>
                    </div>
                  </div>

                  <!-- Website -->
                  <div class="col-md-6">
                    <div class="d-flex align-items-start gap-3 p-3 rounded-3 bg-light border h-100">
                      <div class="d-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary"
                          style="width:38px;height:38px;">
                        <i class="fas fa-globe"></i>
                      </div>
                      <div>
                        <small class="text-muted d-block">Website</small>
                        <p class="mb-0 fw-medium"><?php echo htmlspecialchars($website); ?></p>
                      </div>
                    </div>
                  </div>

                  <!-- Address -->
                  <div class="col-md-6">
                    <div class="d-flex align-items-start gap-3 p-3 rounded-3 bg-light border h-100">
                      <div class="d-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary"
                          style="width:38px;height:38px;">
                        <i class="fas fa-location-dot"></i>
                      </div>
                      <div>
                        <small class="text-muted d-block">Address</small>
                        <p class="mb-0 fw-medium"><?php echo htmlspecialchars($address); ?></p>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>