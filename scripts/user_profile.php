<?php include("../config/db.php"); ?>


<?php
    global $connection;
    global $id, $user_email, $user_firstname, $user_lastname, $msg;

    $query_select = "SELECT * FROM signup WHERE id = {$_SESSION['id']} ";
    $select_query = mysqli_query($connection, $query_select);

    if(!$select_query){
        die("QUERY FAILED . " . mysqli_error($connection));
    }

    while($row = mysqli_fetch_array($select_query)){
        $id = $row['id'];
        $user_email = $row['email'];
        $user_firstname = $row['firstname'];
        $user_lastname = $row['lastname'];
    }

    if(isset($_POST['submit'])){
        $user_email = mysqli_real_escape_string($connection, $_POST['email']);
        $user_firstname = mysqli_real_escape_string($connection, $_POST['firstname']);
        $user_lastname = mysqli_real_escape_string($connection, $_POST['lastname']);
        $gender = mysqli_real_escape_string($connection, $_POST['gender']);
        $intro = mysqli_real_escape_string($connection, $_POST['intro']);
        $quote = mysqli_real_escape_string($connection, $_POST['quote']);
        
        $user_image = $_FILES['image']['name'];
        $user_temp_image = $_FILES['image']['tmp_name'];
        
        move_uploaded_file($user_temp_image, "../images/$user_image");
        
        if(!empty($user_firstname) && !empty($user_lastname) && !empty($user_email) && !empty($gender) && !empty($intro) && !empty($user_image) && !empty($quote)){
            $query_send = "INSERT INTO profile(user_id, firstname, lastname, email, gender, quote, intro, image, date_time) VALUES('{$id}', '{$user_firstname}', '{$user_lastname}', '{$user_email}', '{$gender}', '{$quote}', '{$intro}', '{$user_image}', now()) ";
            
            $send = mysqli_query($connection, $query_send);
            
            if(!$send){
                die("DATA WAS NOT INSERTED INTO DATABASE " . mysqli_error($connection));
            }
            header("Location: ../users/profile.php");
            
        }else{
            $msg = "<div class='alert alert-danger email_alert'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a>
                    Fields Cannot Be Empty</div>";
        }
    }

?>