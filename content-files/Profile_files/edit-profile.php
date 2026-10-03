<?php

include_once(__DIR__ . "/../../db-connection.php");


// CHECK LOGIN
if (!isset($_SESSION['user_id'])) {

    header("Location: ../Auth/login.php");
    exit;
}


// GET LOGGED-IN USER ID
$user_id = $_SESSION['user_id'];

// GET CURRENT USER DATA
$stmt = $conn->prepare("
                    SELECT
                        id, 
                        User_Name,
                        User_Email
                        FROM users
                        WHERE id = ?
                        LIMIT 1
                        ");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

?>


<!--PAGE -->

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <!-- PAGE HEADER-->

    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">

        <div>

            <h5 class="fw-semibold text-dark mb-0">
                <i class="fas fa-user-edit text-primary me-2"></i>
                Edit Profile
            </h5>

            <p class="text-muted small mb-0">
                Manage your personal account information
            </p>

        </div>

    </div>


    <!--SUCCESS MESSAGE -->

    <?php if (isset($_SESSION['success_message'])): ?>

        <div class="alert alert-success alert-dismissible fade show py-2 small border-0"
             role="alert">

            <i class="fas fa-check-circle me-2"></i>
            <?= htmlspecialchars($_SESSION['success_message']); ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>
        <?php unset($_SESSION['success_message']); ?>

    <?php endif; ?>


    <!--ERROR MESSAGE -->

    <?php if (isset($_SESSION['error_message'])): ?>

        <div class="alert alert-danger alert-dismissible fade show py-2 small border-0"
             role="alert">

            <i class="fas fa-exclamation-circle me-2"></i>

            <?= htmlspecialchars($_SESSION['error_message']); ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

        <?php unset($_SESSION['error_message']); ?>

    <?php endif; ?>


    <!-- PROFILE CARD-->

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4" style="max-width: 50%;">
        

        <!-- Card Header -->

        <div class="bg-primary text-white p-3">

            <div class="d-flex align-items-center">

              <img  src="<?= getGravator($user['User_Email']); ?>"
                    class="rounded-circle me-3"
                    style="width: 46px; height: 46px; object-fit: cover;"
                    alt="Profile Picture">
                </div>

                <div>

                    <h6 class="fw-semibold mb-0">
                        <?= htmlspecialchars($user['User_Name']); ?>
                    </h6>

                    <p class="mb-0 small opacity-75">
                        <?= htmlspecialchars($user['User_Email']); ?>
                    </p>

                </div>

            </div>

        </div>


        <!-- Card Body -->

        <div class="card-body p-3 p-lg-4">

            <form
                action="content-files/Profile_files/update-profile.php"
                method="POST"
            >

                <input
                    type="hidden"
                    name="user_id"
                    value="<?= htmlspecialchars($user['id']); ?>"
                >


                <!-- NAME -->

                <div class="mb-3">

                    <label
                        for="user_name"
                        class="form-label small fw-semibold mb-1"
                    >
                        Full Name
                    </label>

                    <div class="input-group input-group-sm">

                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-user text-muted"></i>
                        </span>

                        <input
                            type="text"
                            id="user_name"
                            name="user_name"
                            class="form-control border-start-0"
                            value="<?= htmlspecialchars($user['User_Name']); ?>"
                            required
                        >

                    </div>

                </div>


                <!-- EMAIL -->

                <div class="mb-3">

                    <label
                        for="user_email"
                        class="form-label small fw-semibold mb-1"
                    >
                        Email Address
                    </label>

                    <div class="input-group input-group-sm">

                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-envelope text-muted"></i>
                        </span>

                        <input
                            type="email"
                            id="user_email"
                            name="user_email"
                            class="form-control border-start-0"
                            value="<?= htmlspecialchars($user['User_Email']); ?>"
                            required
                        >

                    </div>

                </div>


                <!-- PASSWORD -->

                <div class="mb-1">

                    <label
                        for="user_password"
                        class="form-label small fw-semibold mb-1"
                    >
                        New Password
                    </label>

                    <div class="input-group input-group-sm">

                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-lock text-muted"></i>
                        </span>

                        <input
                            type="password"
                            id="user_password"
                            name="user_password"
                            class="form-control border-start-0"
                            placeholder="Leave blank to keep current password"
                            minlength="6"
                        >

                    </div>

                    <div class="form-text small">
                        Enter new password if you want to change.
                    </div>

                </div>


                <!-- BUTTONS -->

                <div class="d-flex justify-content-end gap-2 border-top pt-3 mt-4">

                    <button
                        type="submit"
                        class="btn btn-primary btn-sm px-3"
                    >
                        <i class="fas fa-save me-1"></i>
                        Save Changes
                    </button>

                </div>

            </form>

        </div>

    </div>

</main>