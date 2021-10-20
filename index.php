<?php session_start() ?>
<?Php require_once('inc/connection.php');?>
<?Php require_once('inc/functions.php');?>

<?php
    //check for form submission
    //check if Username and password has been entered
    //check if there are any errors in the form
        //save username and password into variable
        //prepare database Query
        //check if the user is valid
        //redirect to users.php
        //if not,dispaly the error
?>
<?php

    

    $errors=array();

    if(isset($_POST['submit']))
    {
        
        if(!isset($_POST['email']) || strlen(trim($_POST['email'])) < 1 ){

            $errors[] = 'Username Is Misssing';
        }
        if(!isset($_POST['password']) || strlen(trim($_POST['password'])) < 1 ){

            $errors[] = 'password Is Misssing/Invalid';
        }

        if(empty($errors))
        {
            $email = mysqli_real_escape_string($connection,$_POST['email']);
            $password = mysqli_real_escape_string($connection,$_POST['password']);
            $hash_pass = sha1($password);

            $query = "  SELECT * FROM user
                        WHERE email='{$email}'
                        AND password = '{$hash_pass}'
                        AND is_deleted = 0
                        LIMIT 1";

            $result = mysqli_query($connection,$query);

            if($result){
                if(mysqli_num_rows($result) == 1){

                    $user = mysqli_fetch_assoc($result);
                
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['first_name'] =$user['first_name'];

                    //updating last login
                    $query ="UPDATE user SET last_login = NOW() ";
                    $query .= "WHERE id = {$_SESSION['user_id']} LIMIT 1";
                    $result_set = mysqli_query($connection,$query);
                   
                  verify_query($result_set);
                   
                    /* if(!$result_set){
                        die("Dtabse Query failed.");
                    }*/
                    
                    header('Location:users.php');
                }
                else{
                    echo "user not found";
                }
            }
            else{
                echo "qurey failed";
            }
       
        }
        else{
            echo "<pre>";
                echo print_r($errors);
          echo  "</pre>";
        }
    }
   

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In-User Management System</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    
    <div class="login">
        <form action="index.php" method="POST">
            <fieldset>
               <?Php if(isset($errors) && !empty($errors)){
                   
                   echo '<p class="error"> Invalid Username / Password </p>';
               } ?>
                <legend><h1>Log In</h1></legend>
                <p>
                    <label for="">Username:</label>
                    <input type="text" name="email" id="" placeholder="Email Address" >
                </p>
                <p>
                    <label for="">password:</label>
                    <input type="password" name="password" id="" placeholder="password">
                </p>
                <p>
                    <button type="submit" name="submit">Log In</button>
                </p>
            </fieldset>
        </form>
    </div>
</body>
</html>
<?php mysqli_close($connection) ?>