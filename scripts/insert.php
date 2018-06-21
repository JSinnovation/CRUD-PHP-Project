<?php include("./lib/swift_required.php"); ?>

<?php
    global $connection;
    global $error1, $error2, $error3, $error4, $error5;
    global $info, $fail;

$f_name = $l_name = $email = $password = "";

//$_POST super global
if(isset($_POST['submit'])){
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $pass_word = $_POST['password'];

    $sql_query = mysqli_query($connection, "SELECT email FROM signup WHERE email = '{$email}' ");
    $count = mysqli_num_rows($sql_query); //looking if email already exists based on the condition

    if(!empty($firstname) && !empty($lastname) && !empty($email) && !empty($pass_word)){

        if($count > 0) {
            $error1 = "<div class='alert alert-danger'>
                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                  User With Email Already Exists.
                </div>";
        }else{
                $f_name = ucwords(mysqli_real_escape_string($connection, $firstname));
                $l_name = ucwords(mysqli_real_escape_string($connection, $lastname));
                $email = mysqli_real_escape_string($connection, $email);
                $password = mysqli_real_escape_string($connection, $pass_word);
              

          if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $error2 = "<div class='alert alert-danger'>
                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Email is Invalid.</div>";
          }
          if(!preg_match("/^[a-zA-Z ]*$/",$f_name)){
              $error3 = "<div class='alert alert-danger'>
                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a>
                  Only Letters are allowed for Firstname</div>";
          }
        if(!preg_match("/^[a-zA-Z]*$/",$l_name)){
              $error4 = "<div class='alert alert-danger'>
                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a>
                  Only Letters are allowed for Lastname</div>";
          }
        if(!preg_match('/^\S*(?=\S{{7,15}) (?=\S*[a-z])(?=\S*[A-Z])(?=S*[\d])\S*$/', $pass_word)){
             $error5 = "<div class='alert alert-danger'>
                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a>
                  Password must be between 7 and 15 chars and must contain at least one lowercase letter, one uppercase letter and one numeric digit.</div>";
          }

          if((preg_match("/^[a-zA-Z ]*$/", $f_name)) && (preg_match("/^[a-zA-Z ]*$/", $l_name)) &&
          (filter_var($email, FILTER_VALIDATE_EMAIL)) && (preg_match('/^\S*(?=\S{7,15})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/', $pass_word))){
                

  					$user_activation_key = md5(rand().time());
                    
					$sql = "INSERT INTO signup(email, firstname, lastname, password, activation_key, is_active, date_time) VALUES('{$email}', '{$f_name}', '{$l_name}', '{$password}', '{$user_activation_key}', '0', now())";    
					$query = mysqli_query($connection, $sql);



                    if(!$query){
                        die("QUERY FAILED " . mysqli_error($connection));
                    }
              
              if($query){
                  
                  $msg = "Please activate your account using this link <a
                  href='http://localhost/crud/user/user_activation.php?
                  key=".$user_activation_key."'>http://localhost/crud/user/user_activation.php?
                  key=".$user_activation_key."</a>";
                  
                  
                  //Create the Transport that calls setUsername() and setPassword()
                  //$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
                   $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
                   
                        ->setUsername('kettlebell4power@gmail.com')
                        ->setPassword('Jumpstart613');
                  $mailer = new Swift_Mailer($transport);
                  //$mailer = (new Swift_Mailer($transport));
                  //$mailer = Swift_Mailer::newInstance($transport); old version code *important
                    // Create the message
                    //$message = Swift_Message::newInstance('Test')
                    /*$message = (new Swift_Message('Test'))
                    // Give the message a subject
                    ->setSubject('Verify Your Email Address')
                    // Set the From address with an associative array
                  ->setFrom(array('kettlebell4power@gmail.com' => 'Lous Test'))
                  //Set the To addresses with an associative array
                  ->setTo(array($email))
                    // Give it a body
                    ->setBody('Body Message')
                    // And optionally an alternative body
                    ->addPart($msg, 'text/html');
                    // Optionally add any attachments
                    $result = $mailer->send($message);
                          */
                  
                  $msg = "This is a test message";
                  // Create a message
                  $message = (new Swift_Message($msg))
                    ->setSubject('Verify Your Email Address')
                    ->setFrom(['kettlebell4power@gmail.com' => 'Louis Test'])
                    ->setTo(['llieberman@ritehite.com' => 'Louis Alert'])
                    ->setBody('Here is the message itself')
                    ->addPart($msg, 'text/html');
                // Send the message
                  $result = $mailer->send($message);
                      
                  if(!$result){
                   $fail = "<div class='alert alert-danger email_alert'>
                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a>
                  Failed to send verification email.</div>";
                  }else{
                      
                    $info = "<div class='alert alert-info email_alert'>
                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a>
                  A verification email has been sent.</div>";
          }
                  }
          }   
                      
                  
        }
                          
        

    }else{

    if (empty($firstname)){
        $error3 = "<div class='alert alert-danger'>
                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                  Firstname Field Cannot Be Empty.</div>";
          }

        if (empty($lastname)){
        $error4 = "<div class='alert alert-danger'>
                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a>
                  Lastname Field Cannot Be Empty.</div>";
          }

        if (empty($email)){
        $error2 = "<div class='alert alert-danger'>
                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a>
                  Email Field Cannot Be Empty.</div>";
          }

        if (empty($pass_word)){
        $error5 = "<div class='alert alert-danger'>
                  <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times</a>
                  Password Field Cannot Be Empty.</div>";

        }
    }
}

?>
