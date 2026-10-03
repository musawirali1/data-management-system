<?php

include_once(__DIR__ . "/../../function.php");
include_once(__DIR__ . "/../../db-connection.php");

// ==========================================
// START SESSION
// ==========================================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ==========================================
// GET ROLES
// ==========================================

    // Roles ko store karne ke liye empty array. 
    $roles = [];

    $role_setting_id = null;
    $result = $conn->query("
        SELECT id, setting_value
        FROM settings
        WHERE setting_name = 'role_names'
        LIMIT 1
    ");


if ($result && $result->num_rows > 0) {

    // Database ki row ko associative array mein convert karte hain.
    $row = $result->fetch_assoc();

    $role_setting_id = $row['id'];

    $decoded_roles = @unserialize($row['setting_value']);

    if (is_array($decoded_roles)) {

        // Database se aaye roles ko $roles mein rakh dete hain.
        $roles = $decoded_roles;
    }
}


foreach ($roles as $key => $role) {

    if (is_string($role)) {

        $roles[$key] = array(
            'name' => $role,
            'is_admin' => false
        );
    }
}
unset($role);

// ==========================================
// MESSAGE
// ==========================================
$message = '';

// ==========================================
// ADD ROLE

// Check karta hai ke Add Role form submit hua hai ya nahi.
if (isset($_POST['add_role'])) {
    $new_role = trim($_POST['new_role_name'] ?? '');
    // Checkbox checked hai to true milega.
    // Checkbox unchecked hai to false milega.
    $is_main_role = isset($_POST['is_main_role']);

    // --------------------------------------
    // Empty Role
    // --------------------------------------
    if ($new_role === '') {

        $message = "
        <div class='alert alert-warning mt-3'>
            Please enter a role name.
        </div>
        ";

    }

    // --------------------------------------
    // Duplicate Role
    // --------------------------------------

    // Pehle assume karte hain ke role exist nahi karta.
    $role_exists = false;

    // Duplicate role rokna — important logic
    foreach ($roles as $role) {

        // Existing role ka name new role ke saath compare karte hain.
        // strtolower() ki wajah se Admin aur admin ko same maana jayega.
        if (strtolower($role['name']) === strtolower($new_role)) {
            $role_exists = true;
            break;
        }
    }

    // Agar role already exist karta hai.
    if ($role_exists) {

        $message = "
        <div class='alert alert-warning mt-3'>
            This role already exists.
        </div>
        ";
    }

    // --------------------------------------
    // Add New Role
    // --------------------------------------
    else {

        // Add role to array
        $roles[] = array(
            'name' => $new_role,
            'is_admin' => $is_main_role
        );

        // Convert array to string
        $roles_string = serialize($roles);

        // ----------------------------------
        // Update Existing role_names
        // ----------------------------------
        if ($role_setting_id !== null) {

            $stmt = $conn->prepare("
                UPDATE settings
                SET setting_value = ?
                WHERE id = ?
            ");

            $stmt->bind_param(
                "si",
                $roles_string,
                $role_setting_id
            );

            $stmt->execute();

        }

        // ----------------------------------
        // Insert role_names if not exists
        // ----------------------------------
        else {

            $setting_name = "role_names";

            $stmt = $conn->prepare("
                INSERT INTO settings
                (setting_name, setting_value)
                VALUES (?, ?)
            ");

            $stmt->bind_param(
                "ss",
                $setting_name,
                $roles_string
            );

            $stmt->execute();

            $role_setting_id = $conn->insert_id;
        }

    

        // ----------------------------------
        // SUCCESS MESSAGE 
        // ----------------------------------
        $message = "
        <div class='alert alert-success alert-dismissible fade show mt-3' role='alert'>
            " . htmlspecialchars($new_role) . " role added successfully.
            <button type='button'
                    class='btn-close'
                    data-bs-dismiss='alert'
                    aria-label='Close'>
            </button>
        </div>
        ";
    }
}

// ==========================================
// DELETE ROLE
// ==========================================
if (isset($_POST['delete_role'])) {

    $role_to_delete = trim($_POST['delete_role']);

    // --------------------------------------
    // Don't Delete Last Role
    // --------------------------------------
    if (count($roles) <= 1) {

        $message = "
        <div class='alert alert-warning mt-3'>
            At least one role must remain.
        </div>
        ";

    }

    // --------------------------------------
    // Delete Role
    // --------------------------------------

    else {

        $roles = array_values(
            array_filter(
                $roles,

                // Har role ko check karte hain
                function ($role) use ($role_to_delete) {

                    // Role ke 'name' ko delete wale name se compare karte hain.
                    // Agar same hai:
                    // false return hoga = role remove hoga.
                    //
                    // Agar different hai:
                    // true return hoga = role keep hoga.
                    return strtolower($role['name'])
                        !== strtolower($role_to_delete);
                }
            )
        );

   
        $roles_string = serialize($roles);

        
        // ----------------------------------
        // Update role_names
        // ----------------------------------
        if ($role_setting_id !== null) {

            $stmt = $conn->prepare("
                UPDATE settings
                SET setting_value = ?
                WHERE id = ?
            ");

            $stmt->bind_param(
                "si",
                $roles_string,
                $role_setting_id
            );

            $stmt->execute();
        }

       
        // ----------------------------------
        // SUCCESS MESSAGE (dikhaya jayega inline,
        // koi redirect nahi hoga)
        // ----------------------------------
        $message = "
        <div class='alert alert-success alert-dismissible fade show mt-3' role='alert'>
            " . htmlspecialchars($role_to_delete) . " role deleted successfully.
            <button type='button'
                    class='btn-close'
                    data-bs-dismiss='alert'
                    aria-label='Close'>
            </button>
        </div>
        ";
    }
}

?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <!-- =====================================
         PAGE HEADER
    ====================================== -->

    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">

        <div>

            <h4 class="mb-1">
                User Setting
            </h4>

            <small class="text-muted">
                Manage system user roles
            </small>

        </div>

    </div>


    <!-- =====================================
         MESSAGE
    ====================================== -->

    <!--
        $message mein PHP ka success/warning message hota hai.
        Isko yahan display kar rahe hain.
    -->

    <?php echo $message; ?>


    <!-- =====================================
         ROLES CARD
    ====================================== -->

    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body p-4">


            <!-- Card Header -->

            <div class="d-flex justify-content-between align-items-center mb-3">

                <div>

                    <h5 class="mb-1">
                        User Roles
                    </h5>

                    <small class="text-muted">
                        Add or remove user roles.
                    </small>

                </div>

            </div>


            <!-- =====================================
                 ROLE TABLE
            ====================================== -->

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">


                    <!-- Table Header -->

                    <thead class="table-light">

                        <tr>

                            <th>
                                #
                            </th>

                            <th>
                                Role Name
                            </th>

                            <th>
                                Admin Role
                            </th>

                            <th class="text-end">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <!-- Table Body -->

                    <tbody>

                        <?php if (!empty($roles)): ?>


                            <!--
                                $roles ke andar jitne roles hain
                                unko ek ek karke $role mein la rahe hain.

                                $index = role ka array number.
                                $role  = current role ka complete array.
                            -->

                            <?php foreach ($roles as $index => $role): ?>

                                <tr>


                                    <!-- =====================================
                                         NUMBER
                                    ====================================== -->

                                    <td>
                                        <?= $index + 1; ?>
                                    </td>


                                    <!-- =====================================
                                         ROLE NAME
                                    ====================================== -->

                                    <td>

                                        <strong>
                                            <?= htmlspecialchars($role['name']); ?>
                                        </strong>

                                    </td>


                                    <!-- =====================================
                                         ADMIN ROLE
                                    ====================================== -->

                                    <td>

                                        <!--
                                            Check kar rahe hain ke current
                                            role ka is_admin true hai ya nahi.

                                            true  = Admin Role
                                            false = Normal Role
                                        -->

                                        <?php if (!empty($role['is_admin'])): ?>

                                            <span class="badge bg-success rounded-pill">
                                                Admin Role
                                            </span>

                                        <?php else: ?>

                                            <span class="text-muted">
                                                -
                                            </span>

                                        <?php endif; ?>

                                    </td>


                                    <!-- =====================================
                                         DELETE ACTION
                                    ====================================== -->

                                    <td class="text-end">


                                        <!--
                                            action="" ka matlab form
                                            isi page par submit hoga.
                                        -->

                                        <form
                                            method="POST"
                                            action=""
                                            class="d-inline"
                                            onsubmit="return confirm('Delete this role?');"
                                        >


                                            <!--
                                                Delete hone wale role ka
                                                name POST mein bhej rahe hain.
                                            -->

                                            <input
                                                type="hidden"
                                                name="delete_role"
                                                value="<?= htmlspecialchars($role['name']); ?>"
                                            >


                                            <!-- Delete Button -->

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger rounded-3"
                                            >
                                                Delete
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            <?php endforeach; ?>


                        <?php else: ?>


                            <!-- =====================================
                                 NO ROLES
                            ====================================== -->

                            <tr>

                                <td
                                    colspan="4"
                                    class="text-center text-muted py-4"
                                >
                                    No roles found.
                                </td>

                            </tr>


                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    <!-- =====================================
         ADD ROLE CARD
    ====================================== -->

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">


            <h5 class="mb-1">
                Add New Role
            </h5>

            <small class="text-muted d-block mb-4">
                Create a new role for your system.
            </small>


            <!-- =====================================
                 ADD ROLE FORM
            ====================================== -->

            <!--
                Form isi page par POST hoga.
                PHP ka add_role wala code is data ko receive karega.
            -->

            <form
                method="POST"
                action=""
                class="row g-3 align-items-end"
            >


                <!-- =====================================
                     ROLE NAME
                ====================================== -->

                <div class="col-md-6">

                    <label class="form-label fw-semibold">
                        Role Name
                    </label>

                    <input
                        type="text"
                        name="new_role_name"
                        class="form-control"
                        placeholder="Enter role name"
                        required
                    >

                </div>


                <!-- =====================================
                     ADMIN ROLE
                ====================================== -->

                <div class="col-md-3">

                    <div class="form-check mb-2">

                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="is_main_role"
                            value="1"
                            id="is_main_role"
                        >

                        <label
                            class="form-check-label"
                            for="is_main_role"
                        >
                            Set as Admin Role
                        </label>

                    </div>

                </div>


                <!-- =====================================
                     ADD BUTTON
                ====================================== -->

                <div class="col-md-3">

                    <button
                        type="submit"
                        name="add_role"
                        value="1"
                        class="btn btn-primary rounded-3 px-4 w-100"
                    >
                        Add Role
                    </button>

                </div>

            </form>

        </div>

    </div>

</main>