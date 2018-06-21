<!--<?php include("../config/db.php"); ?>-->


<?php

    global $connection;

    if(isset($_POST['submit'])){
        $search = $_POST['search'];

        if(!empty($search)){
            $query = "SELECT * FROM profile WHERE firstname LIKE '%$search%' OR lastname LIKE '%$search%' OR email LIKE '%$search%' ";
            $send_query = mysqli_query($connection, $query);
            $count = mysqli_num_rows($send_query);

            if(!$send_query){
                die("SEARCH NOT FOUND " . mysqli_error($coonection));
            }

            if($count <= 0){
                echo "<div class='alert alert-danger email_alert'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a>
                    Sorry, no search result was found.</div>";
            }else{
while($row = mysqli_fetch_array($send_query)){
        $user_id = $row['user_id'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $email = $row['email'];
        $gender = $row['gender'];
        $intro = $row['intro'];
        $img = $row['image'];

$search_result = <<<DELIMETER
    <div class="col-sm-4 col-md-4 col-lg-4" style="">
        <div class="thumbnail">

            <a href="../users/user.php?id=$user_id&&$firstname&&$lastname">
                <img class="img-responsive" src="../images/$img">
            </a>

            <div class="caption">
                <center>
                    <a href="../users/user.php?id=$user_id&&$firstname&&$lastname">
                        <h4>{$firstname} {$lastname}</h4>
                    </a>
                </center>
            </div>

        </div>
    </div>

DELIMETER;
echo $search_result;
    }
            }


        }else{
            echo "<div class='alert alert-danger email_alert'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a>
                    No Result Found</div>";
        }
    }

?>
