<?php include("../config/db.php"); ?>


<?php
//This is the logic that allows the user to update his data in the database

    global $connection;
    global $user_email, $user_firstname, $user_lastname, $user_gender, $user_intro, $user_img, $user_quote;
    global $error, $count;

    $query_select = "SELECT * FROM profile WHERE user_id = {$_SESSION['id']} ";
    $send_query = mysqli_query($connection, $query_select);
    $count = mysqli_num_rows($send_query);

    if(!$send_query){
        die("QUERY FAILED " . mysqli_error($connection));
    }

    while($row = mysqli_fetch_array($send_query)){
        $user_id = $row['user_id'];
        $user_email = $row['email'];
        $user_firstname = $row['firstname'];
        $user_lastname = $row['lastname'];
        $user_gender = $row['gender'];
        $user_quote = $row['quote'];
        $user_intro = $row['intro'];
        $user_img = $row['image'];
        $date = $row['date_time'];
    }

    if(isset($_POST['update'])){
        
        $user_email = mysqli_real_escape_string($connection, $_POST['email']);
        $user_firstname = mysqli_real_escape_string($connection, $_POST['firstname']);
        $user_lastname = mysqli_real_escape_string($connection, $_POST['lastname']);
        $user_gender = mysqli_real_escape_string($connection, $_POST['gender']);
        $user_quote = mysqli_real_escape_string($connection, $_POST['quote']);
        $user_intro = mysqli_real_escape_string($connection, $_POST['intro']);
        
        $user_img = $_FILES['image']['name'];
        $user_temp_image = $_FILES['image']['tmp_name'];
        
        move_uploaded_file($user_temp_image, "../images/$user_img");
        
        if(empty($user_img)){
            $query = mysqli_query($connection, "SELECT * FROM profile WHERE user_id = {$_SESSION['id']}");
            
            while($row = mysqli_fetch_array($query)){
                $user_img = $row['image'];
            }
        }
        
        if($count <= 0){
            $error = "<div class='alert alert-danger email_alert text-center'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a>Please complete your profile before your can update.</div>"; 
        }else{
            $update = "UPDATE profile SET ";
            $update .= "firstname = '{$user_firstname}', ";
            $update .= "lastname = '{$user_lastname}', ";
            $update .= "email = '{$user_email}', ";
            $update .= "gender = '{$user_gender}', ";
            $update .= "quote = '{$user_quote}', ";
            $update .= "intro = '{$user_intro}', ";
            $update .= "image = '{$user_img}', ";
            $update .= "date_time = now() ";
            $update .= "WHERE user_id = {$_SESSION['id']}";
            
            $update_query = mysqli_query($connection, $update);
            
            if(!$update_query){
                die("UPDATE WAS NOT SUCCESSFUL " . mysqli_error($connection));
            }
            
            header("Location: ../users/profile.php?fisrtname={$user_firstname}");
        }
        
    }

?>