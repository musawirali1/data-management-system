<?php

session_start();

require_once "../Auth/register_process.php";

// ================================
// Default Variables
// Agar page pehli baar open ho to empty rahen
// ================================

$full_name = $full_name ?? "";
$email     = $email ?? "";
$user_type = $user_type ?? "";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

         <!-- Google reCaptcha -->
     <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container py-5">  
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">

            <div class="card shadow-lg border-0 rounded-4 p-4">

                <h3 class="text-center mb-4">
                    Create Account
                </h3>

                <!-- Error Message -->
                <?php if(isset($register_error)){ ?>

                    <div class="alert alert-danger">
                        <?php echo $register_error; ?>
                    </div>

                <?php } ?>

                <!-- Success Message -->
                <?php if(isset($register_success)){ ?>

                    <div class="alert alert-success">
                        <?php echo $register_success; ?>
                    </div>
                    <!-- Login Link -->
                <div class="text-center mt-3">
                    Already have an account?
                    <a href="login.php">Login</a>
                </div>

                <?php } else { ?>

                <div class="text-center mb-4">
                    <button class="btn btn-light social-btn">
                        <i class="fab fa-google"></i>
                    </button>
                </div>

                <p class="text-center text-muted mb-4">
                    Register with your email
                </p>

                <form action="" method="POST">

                    <!-- Full Name -->
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input
                            type="text"
                            name="full_name"
                            class="form-control"
                            placeholder="Enter Full Name"
                            value="<?php echo htmlspecialchars($full_name); ?>"

                            required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="Enter Email"
                            value="<?php echo htmlspecialchars($email); ?>"
                            required>
                    </div>

                    <!-- User Type -->
                    <div class="mb-3">
                        <label class="form-label">User Type</label>

                        <select
                            name="user_type"
                            class="form-select"
                            required>

                            <option value="">Select User Type</option>

                            <option value="Student" <?php if($user_type=="Student") echo "selected"; ?>>Student</option>

                            <option value="Teacher" <?php if($user_type=="Teacher") echo "selected"; ?>>Teacher</option>

                        </select>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Enter Password"
                            required>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input
                            type="password"
                            name="confirm_password"
                            class="form-control"
                            placeholder="Confirm Password"
                            required>
                    </div>

                    <!-- reCAPTCHA -->
                    <div class="mb-4 recaptcha-wrap">
                        <div class="g-recaptcha" data-sitekey="6LeWSdUtAAAAAMiSmenU0OND3RoE3hnpj1wsLg5H"></div>
                    </div>

                    <!-- Terms -->
                    <div class="form-check mb-4">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="agree"
                            id="agree"
                            required>

                        <label class="form-check-label" for="agree">
                            I agree to Terms & Conditions
                        </label>
                    </div>

                    <!-- Register Button -->
                    <button
                        type="submit"
                        name="register"
                        class="btn btn-primary w-100">
                        Register
                    </button>

                </form>

                <!-- Login Link -->
                <div class="text-center mt-3">
                    Already have an account?
                    <a href="login.php">Login</a>
                </div>

                <?php } ?>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>