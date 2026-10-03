 <?php

        include('../db-connection.php');

        $id = $_POST['id'];
        $name = $_POST['name'];
        $subject = $_POST['subject'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        $sql = "

        UPDATE teachers SET
        name='$name',
        subject='$subject',
        email='$email',
        phone='$phone',
        updated_at=NOW()

        WHERE id='$id'";

        if($conn->query($sql)){

        echo "success";

        }
        else{
        echo "error";

        }

        ?>