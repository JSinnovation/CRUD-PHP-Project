<?php include("../config/db.php"); ?>


<?php
    global $connection, $count;
    global $firstname, $lastname, $email, $gender, $intro, $user_image, $quote;

    $query_select = "SELECT * FROM profile WHERE user_id = {$_SESSION['id']} ";
    $query = mysqli_query($connection, $query_select);
    $count = mysqli_num_rows($query);

    while($row = mysqli_fetch_array($query)){
        $user_id = $row['user_id'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $email = $row['email'];
        $gender = $row['gender'];
        $intro = $row['intro'];
        $quote = $row['quote'];
        $user_image = $row['image'];
    }

    function profile_image(){
        global $count, $user_image;
        
        if($count <= 0){
            echo "<img src='http://placehold.it/250x250' style='margin-left: 40px;>";
        }else{
            echo "
            <div class='thumbnail' style='border:none; padding-top:5px;'>
                <a href'#'>
                    <img src='../images/$user_image' style='margin-left: 40px;'>
                </a>
            </div>";
            
        }
    }

    function profile_data(){
        global $count, $firstname, $lastname, $email, $intro, $gender;
        
        if($count <= 0){
            echo "<div class='alert alert-info email_alert text-center' style='margin: 0px 10px 20px 0px;'>
                FIRSTNAME HAS NOT BEEN UPDATED
                </div>";
            
            echo "<div class='alert alert-info email_alert text-center' style='margin: 0px 10px 20px 0px;'>
                LASTNAME HAS NOT BEEN UPDATED
                </div>";
            
            echo "<div class='alert alert-info email_alert text-center' style='margin: 0px 10px 20px 0px;'>
                EMAIL HAS NOT BEEN UPDATED
                </div>";
            
            echo "<div class='alert alert-info email_alert text-center' style='margin: 0px 10px 20px 0px;'>
                GENDER HAS NOT BEEN UPDATED
                </div>";
            
            echo "<div class='alert alert-info email_alert text-center' style='margin: 0px 10px 20px 0px;'>
                DESCRIPTION HAS NOT BEEN UPDATED
                </div>";
        }else{
            echo "<label class='control-label col-sm-3'>Firstname:</label>
                <div class='col-sm-9'>$firstname</div><br><br>";
            
            echo "<label class='control-label col-sm-3'>Lastname:</label>
                    <div class='col-sm-9'>$lastname</div><br><br>";
            
            echo "<label class='control-label col-sm-3'>Email:</label>
                    <div class='col-sm-9'>$email</div><br><br>";
            
            echo "<label class='control-label col-sm-3'>Gender:</label>
                    <div class='col-sm-9'>$gender</div><br><br>";
            
            echo "<label class='control-label col-sm-3'>About Me:</label>
                    <div class='col-sm-9'>$intro</div><br><br>";
            
        }
        
    }

?>