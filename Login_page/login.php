<?php

session_start();

// Login Process
require_once "../Auth/login_process.php";

// Remember Me Cookie
$email = "";

if (isset($_COOKIE['remember_email'])) {
    $email = $_COOKIE['remember_email'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-5 col-md-7">

            <div class="card shadow-lg border-0 rounded-4 p-4">

                <h3 class="text-center mb-4">
                    Welcome Back
                </h3>

                <!-- Login Error -->

                <?php if(isset($error)){ ?>

                    <div class="alert alert-danger">
                        <?php echo $error; ?>
                    </div>

                <?php } ?>

                <div class="text-center mb-4">

                    <button class="btn btn-light social-btn">
                        <i class="fab fa-google"></i>
                    </button>

                </div>

                <p class="text-center text-muted mb-4">
                    Sign in with your Email
                </p>

                <form action="" method="POST">

                    <!-- Email -->

                    <div class="mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="Enter Email"
                            value="<?php echo htmlspecialchars($email); ?>"
                            required>

                    </div>

                    <!-- Password -->

                    <div class="mb-3">

                        <label class="form-label">
                            Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Enter Password"
                            required>

                    </div>

                    <!-- Remember Me -->

                    <div class="d-flex justify-content-between mb-4">

                        <div class="form-check">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="remember_me"
                                id="remember">

                            <label
                                class="form-check-label"
                                for="remember">

                                Remember Me

                            </label>

                        </div>

                        <a href="#">
                            Forgot Password?
                        </a>

                    </div>

                    <!-- Login Button -->

                    <button
                        type="submit"
                        name="login"
                        class="btn btn-primary w-100">

                        Login

                    </button>

                </form>

                <hr>

                <div class="text-center">

                    Don't have an account?

                    <a href="register.php">
                        Create Account
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>