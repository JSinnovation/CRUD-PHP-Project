<?php
    global $connection; //We set this global $connection variable which is gotten from the db.php file in the config folder

    //We set the alert variables to global so they can be used outside this script
    global $update_good, $good_update, $error;

    //We check that the key in the url is not empty
    //If it is not empty, the we set it equal to a variable $key
    //We use the $_GET[''] to obtain values from the url
    if(!empty($_GET['key'])){
        $key = $_GET['key'];
    }else{
        $key = "";
    }

    //If the key in the browser is not empty
    if($key != ''){
        //We select the data from the signup table where the activation_key of the user in the database is equal to the key that was obtained from the url
        //Then the mysqli_num_rows() is used to count the number of rows that meet that sql select statement
        $sql = mysqli_query($connection, "SELECT * FROM signup WHERE activation_key = '$key' ");
        $count = mysqli_num_rows($sql);

        //A check is performed. If the returned value is equal to 1, i.e. rows exist in the DB
        //Then we loop through the table using the mysqli_fetch_array() to get the value we need and in this case its the is_active value of theuser
        if($count == 1){
            while($row = mysqli_fetch_array($sql)){
                $is_active = $row['is_active'];

                if($is_active == 0){
                    //If the is_active value of the user is 0 then update to 1 with this update query
                    $update_sql = "UPDATE signup SET is_active = '1' WHERE activation_key = '$key' ";
                    $update_query = mysqli_query($connection, $update_sql);

                    //Show this alert message if the update query is successful
                    if($update_query){
                        $update_good = "<div class='alert alert-info email_alert'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a>
                        Your Email Has Been Verified Successfully.</div>";
                    }
                }else{
                    //If is_active is already 1 meaning that the user has activated his account, then display this message
                    $good_update = "<div class='alert alert-info email_alert'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a>
                        Your Email Has Already Been verified.</div>";
                }
            }
        }else{
            $error = "<div class='alert alert-danger email_alert'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a>
                        Error Occured</div>";
        }

    }

?>
