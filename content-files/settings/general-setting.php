        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">


            <?php

            include_once(__DIR__ . "/../../db-connection.php");


            /* ==========================================
            DEFAULT VALUES
            ========================================== */

            $school_name = "";
            $school_email = "";
            $phone = "";
            $address = "";
            $website = "";

            $record_success = 0;


            /* ==========================================
            GET EXISTING GENERAL SETTINGS
            ========================================== */

            /*
                Pehle database se check karte hain:

                Kya 'genral_setting' already exist hai?

                Agar exist hai to uski value unserialize()
                karke form mein show karenge.
            */

            $check_existing = $conn->prepare("
                SELECT id, setting_value
                FROM settings
                WHERE setting_name = 'genral_setting'
                LIMIT 1");

            $check_existing->execute();

            $existing_result = $check_existing->get_result();


            if ($existing_result->num_rows > 0) {

                $existing_row = $existing_result->fetch_assoc();

                /*
                    Database mein serialized string hai.

                    unserialize()
                    String ko PHP associative array mein
                    convert karta hai.
                */

                $existing_settings = unserialize(
                    $existing_row['setting_value']
                );


                if (is_array($existing_settings)) {


                    $school_name = $existing_settings['school_name'] ?? "";
                    $school_email = $existing_settings['school_email'] ?? "";
                    $phone = $existing_settings['phone'] ?? "";
                    $website = $existing_settings['website'] ?? "";
                    $address = $existing_settings['address'] ?? "";
                }
            }


            /* ==========================================
            FORM SUBMIT
            ========================================== */

            if (isset($_POST['save_general'])) {


                /* ----------------------------------------
                GET FORM DATA
                ---------------------------------------- */

                $school_name = trim($_POST['school_name'] ?? "");
                $school_email = trim($_POST['school_email'] ?? "");
                $phone = trim($_POST['phone'] ?? "");
                $address = trim($_POST['address'] ?? "");
                $website = trim($_POST['website'] ?? "");


                /* ==========================================
                VALIDATION
                ========================================== */

                if (empty($school_name)) {

                    echo "
                    <div class='alert alert-danger'>
                        School Name is required.
                    </div>
                    ";

                }

                elseif (empty($school_email)) {

                    echo "
                    <div class='alert alert-danger'>
                        School Email is required.
                    </div>
                    ";

                }

                else {


                    /* ==========================================
                    CREATE ASSOCIATIVE ARRAY
                    ========================================== */

                    /*
                        Yahan hum General Settings ka
                        associative array bana rahe hain.
                    */

                    $genral_setting_arr = array(
                        "school_name"  => $school_name,
                        "school_email" => $school_email,
                        "phone"        => $phone,
                        "website"      => $website,
                        "address"      => $address );


                    /* ==========================================
                    SERIALIZE ARRAY
                    ========================================== */

                    /*
                        PHP Array
                            ↓
                        serialize()
                            ↓
                        String
                            ↓
                        Database
                    */

                    $genral_setting_str = serialize($genral_setting_arr);


                    /* ==========================================
                    CHECK IF GENERAL SETTING EXISTS
                    ========================================== */

                    $check = $conn->prepare("
                        SELECT id
                        FROM settings
                        WHERE setting_name = 'genral_setting'
                        LIMIT 1
                    ");

                    $check->execute();

                    $check_result = $check->get_result();


                    /* ==========================================
                    IF EXISTS → UPDATE
                    ========================================== */

                    if ($check_result->num_rows > 0) {


                        /*
                            Existing row ki ID le rahe hain.
                        */

                        $row = $check_result->fetch_assoc();

                        $id = $row['id'];


                        /*
                            Purani row ko update karenge.

                            NEW ROW nahi banegi.
                        */

                        $stmt = $conn->prepare("
                            UPDATE settings
                            SET setting_value = ?
                            WHERE id = ?
                        ");


                        $stmt->bind_param(
                            "si",
                            $genral_setting_str,
                            $id
                        );


                    }


                    /* ==========================================
                    IF NOT EXISTS → INSERT
                    ========================================== */

                    else {


                        /*
                            Agar pehli baar General Settings save
                            ho rahi hain to new row create hogi.
                        */

                        $setting_name = "genral_setting";


                        $stmt = $conn->prepare("
                            INSERT INTO settings
                            (
                                setting_name,
                                setting_value
                            )
                            VALUES
                            (
                                ?,
                                ?
                            )
                        ");


                        $stmt->bind_param(
                            "ss",
                            $setting_name,
                            $genral_setting_str
                        );
                    }


                    /* ==========================================
                    EXECUTE QUERY
                    ========================================== */

                    if ($stmt->execute()) {


                        $record_success = 1;


                        echo "
                        <div class='alert alert-success border-0 shadow-sm d-flex align-items-center'>

                            <i class='fas fa-circle-check fs-3 me-3'></i>

                            <div>

                                <strong>Success!</strong><br>

                                General Settings Saved Successfully.

                            </div>

                        </div>
                        ";


                        /*
                            Save ke baad fields empty nahi karenge.

                            Latest saved data screen par hi rahega.
                        */
                    }

                    else {

                        echo "
                        <div class='alert alert-danger'>

                            <strong>Error!</strong><br>

                            "
                            . htmlspecialchars($stmt->error)
                            . "

                        </div>
                        ";
                    }
                }
            }

            ?>



        <style>

        .settings-card{
            border-radius:18px;
            overflow:hidden;
        }

        .settings-header{
            background:linear-gradient(135deg,#0d6efd,#3d8bfd);
            
        }

        .settings-header h4{
            margin:0;
            font-weight:600;
        }

        .card-body{
            padding:35px;
        }

        .section-title{
            font-size:14px;
            color:#6c757d;
            text-transform:uppercase;
            letter-spacing:1px;
            font-weight:600;
        }

        .form-label{
            font-weight:600;
            color:#495057;
        }

        .form-control{
            border-radius:10px;
            padding:12px;
            transition:.3s;
        }

        .form-control:focus{
            border-color:#0d6efd;
            box-shadow:0 0 0 .2rem rgba(13,110,253,.15);
        }

        .input-group-text{
            border-radius:10px 0 0 10px;
            background:#f8f9fa;
        }

        .btn-save{
            border-radius:10px;
            padding:12px;
            font-size:17px;
            font-weight:600;
            transition:.3s;
        }

        .btn-save:hover{
            transform:translateY(-2px);
            box-shadow:0 8px 20px rgba(13,110,253,.25);
        }

        </style>


        <div class="container py-4">

        <div class="row justify-content-center">

        <div class="col-lg-9">

        <div class="card shadow-sm border-1 settings-card">

        <div class="card-header settings-header text-white">

        <h4>

        <i class="fas fa-gears me-2"></i>

        General Settings

        </h4>

        </div>

        <div class="card-body">

        <p class="section-title">

        Configure Your School Information

        </p>

        <form id="generalForm" method="POST">

        <div class="row">

        <div class="col-md-6 mb-4">

        <label class="form-label">

        School Name

        </label>

        <div class="input-group">


        <input

        type="text"

        name="school_name"

        class="form-control"

        placeholder="Enter School Name"

        required

        value=" <?php echo $school_name; ?> ">

        </div>

        </div>


        <div class="col-md-6 mb-4">

        <label class="form-label">

        School Email

        </label>

        <div class="input-group">



        <input

        type="email"

        name="school_email"

        class="form-control"

        placeholder="Enter School Email"

        required

        value=" <?php echo $school_email; ?> ">

        </div>

        </div>

        </div>



        <div class="row">

        <div class="col-md-6 mb-4">

        <label class="form-label">

        Phone

        </label>

        <div class="input-group">



        <input

        type="text"

        name="phone"

        class="form-control"

        placeholder="Enter Phone Number"

        value=" <?php echo $phone; ?> ">

        </div>

        </div>



        <div class="col-md-6 mb-4">

        <label class="form-label">

        Website

        </label>

        <div class="input-group">



        <input

        type="text"

        name="website"

        class="form-control"

        placeholder="https://example.com"

        value=" <?php echo $website; ?> ">

        </div>

        </div>

        </div>



        <div class="mb-4">

        <label class="form-label">

        Address

        </label>

        <textarea
        name="address"

        rows="4"

        class="form-control"

        placeholder="Enter Complete School Address"> <?php echo $address; ?> </textarea>

        </div>

        <hr>

        <div class="d-grid mt-3">

        <button

        type="submit"

        name="save_general"

        value="1"

        class="btn btn-primary btn-lg btn-save">

        <i class="fas fa-floppy-disk me-2"></i>

        Save General Settings

        </button>

        </div>

        </form>

        </div>

        </div>

        </div>

        </div>

        </div>

        </main>