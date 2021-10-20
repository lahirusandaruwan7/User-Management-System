<?Php require_once('inc/connection.php');?>
<?Php require_once('inc/functions.php');?>
<?php session_start() ?>



<?php

    if(!isset($_SESSION['user_id']))
    {
            header('Location:index.php?redirect from add-user');
    }

    $errors = array();


    if(isset($_POST['submit']))
    {  
        $first_name = $_POST['first_name'];
        $last_name =$_POST['last_name'] ;
        $email =$_POST['email'] ;

        $pass = $_POST['password'];
        $showpass = $_POST['cpassword'];

        $user_id = mysqli_real_escape_string($connection,$_POST['user_id']);
        /*$query = "SELECT * FROM user WHERE id = '{$user_id}'LIMIT 1";

        $result_set = mysqli_query($connection,$query);

        if($result_set){
            if(mysqli_num_rows($result_set) == 1)
            {

                $data = mysqli_fetch_assoc($result_set);

                $first_name = $data['first_name'];
                $last_name =$data['last_name'] ;
                $email =$data['email'] ;
        
            }
            else
            {
                header('Location:users.php?err=user_not_found');
            }
        }
        else
        {
            header('Location:users.php?err=query_failed');
        }*/
        
        
        $req_fields = array('password' => 40);
        
        foreach($req_fields as $field => $max_len){

            if(empty(trim($_POST[$field]))){

                $errors[] = $field . ' is required';
                $pass = '';
                $showpass = '';

            } 
            if(strlen(trim($_POST[$field])) > $max_len)
            {
                 $errors[] = $field .' must be less than ' . $max_len .' characters';
            }         

        }
        
  
    
        if(empty($errors))
        {
            if(!($_POST['password'] == $_POST['cpassword'])){
                $errors[] = 'password not match';
            }
            else{
                $password = mysqli_real_escape_string($connection,$_POST['password']);
                $hash_pass = sha1($password);
        
                $query ="UPDATE user SET ";
                $query .= "password = '{$hash_pass}' ";
                $query .= "WHERE id = {$user_id} LIMIT 1 ";

                $result = mysqli_query($connection,$query);
                if($result)
                { 
                    header("Location:users.php?user_modified=true");
                }
                else
                {
                    $errors[]="Failed to Update the record.";
                }
            }
            
        }     
    }
    
    
    

    
   
   

    if(isset($_GET['user_id'])){

        $user_id = mysqli_real_escape_string($connection,$_GET['user_id']);
        $query = "SELECT * FROM user WHERE id = '{$user_id}'LIMIT 1";

        $result_set = mysqli_query($connection,$query);

        if($result_set){
            if(mysqli_num_rows($result_set) == 1){

                $data = mysqli_fetch_assoc($result_set);

                $first_name = $data['first_name'];
                $last_name =$data['last_name'] ;
                $email =$data['email'] ;
                $pass = '';
                $showpass = '';
            
            }
            else{
                header('Location:users.php?err=user_not_found');
            }
        }
        else{
            
            header('Location:users.php?err=query_failed');
        }
    }

    elseif(empty($user_id))
    {
        header('Location:users.php? empty'); 
    }
    

    
  
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>

<header>
        
        <div class="appname"> User Management System </div>
        <div class="loggedin">
             Welcome <?php echo $_SESSION['first_name']; ?> <a href="logout.php">Log Out </a> 
        </div>
     
</header>
<main>
    <h1>Change Password <span> <a href = "users.php"> < back to User List </a> </span></h1>
   <?php if(!empty($errors))
   {
             /* echo "<div class='errmsg'> <b> There were error(s) on your form.</b> <br><br>";
                foreach($errors as $error){
                    echo $error.'<br>';

                }
                echo '</div>';*/
        display_errors($errors);
      
    
    }
   
    ?>
    <?php echo '<br>' ?>
    <form action="change-password.php" method="POST" class="userform">
    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
    
    <?php
       /* <input type="hidden" name="first_name" value="<?php echo $first_name; ?>">
        <input type="hidden" name="last_name" value="<?php echo $last_name; ?>">
        <input type="hidden" name="email" value="<?php echo $email; ?>">*/
    ?>
    <p>
        <label for="">First Name :</label>
        <input type="text" name="first_name" <?php echo  'value ="' . $first_name . '" '?> readonly>
    </p>

    <p>
        <label for="">Last Name :</label>
        <input type="text" name="last_name" <?php echo  'value ="' . $last_name . '" '?> readonly>
    </p>

    <p>
        <label for="">Email Address :</label>
        <input type="email" name="email" <?php echo 'value ="' . $email . '"'?> readonly>
    </p>

    <p>
        <label for="">New Password :</label>
        <input type="password" name="password" id="pass" <?php echo 'value ="' . $pass . '"'?> >
    </p>

    <p>
        <label for="">Confirm Password :</label>
        <input type="password" name="cpassword" id="confirmpass" <?php echo 'value ="' . $showpass. '"'?> >
    </p>
    <p>
        <label for="">Show Password :</label>
        <input type="checkbox" name="showpass" id="showpass" style="width:25px;height:25px">
    </p>

    <p>
        <label for="">&nbsp;</label>
        <button type="submit" name="submit">Update Password</button>
    </p>
    <p>
        <a href="Users.php?cancel">Cancel</a>
    </p>


</form>
</main>
<script src="js/jquery.js"></script>
<script>
    $(document).ready(function()
    {
        $('#showpass').click(function(){
            if ($('#showpass').is(':checked'))
            {
                $('#pass').attr('type','text');
                $('#confirmpass').attr('type','text');
            }
            else
            {
                $('#pass').attr('type','password');
                $('#confirmpass').attr('type','password');
            }
        });
    });
</script>



</body>
</html>
<?php mysqli_close($connection) ?>