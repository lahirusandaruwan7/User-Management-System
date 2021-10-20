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
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];

        if(empty (trim ($_POST['first_name']) )){
            $first_name = "";
        }if(empty (trim ($_POST['last_name']) ))
        {
            $last_name = "";
        }
    
        

        $req_fields = array('first_name' => 50,'last_name' => 100,'password' => 40);
       
       foreach($req_fields as $field => $max_len){

           if(empty(trim($_POST[$field]))){

               $errors[] = $field . ' is required';
               
              /* if($field == 'first_name'){
                $first_name ='';
              }
              elseif($field == 'last_name'){
                $last_name = '';
              }
              elseif($field == 'email'){
                $email = '';
              }*/
            }          
    
        }
       
        /* if(empty(trim($_POST['first_name'])))
        {
            $errors[] = 'First Name is required';
        }
        elseif(empty(trim($_POST['last_name'])))
        {
            $errors[] = 'Last Name is required';
        }
        elseif(empty(trim($_POST['email'])))
        {
            $errors[] = 'Email is required';
        }
        elseif(empty(trim($_POST['password'])))
        {
            $errors[] = 'Password is required';
        }
        elseif(empty(trim($_POST['cpassword'])))
        {
            $errors[] = 'Confirm Password  is required';
        }
        */

        if(!($_POST['password'] == $_POST['cpassword']))
        {
                $errors[] = 'password does note Match';
       }
    
       
           
        foreach($req_fields as $field => $max_len){
    
    
                 if(strlen(trim($_POST[$field])) > $max_len)
                 {
                     $errors[] = $field .' must be less than ' . $max_len .' characters';
                }
    
        }
        if(!is_email($_POST['email'])){
            $errors[] = 'Email address is Invalid';
        }
        else{
            if(strlen(trim($_POST['email'])) > 100)
            {
                $errors[] = 'Email must be less than 100 characters';
           }
        }
        //checking if mail address already exists
        $email = mysqli_real_escape_string($connection,$_POST['email']);
        $query = "SELECT * FROM user WHERE email = '{$email}'LIMIT 1";

        $result_set = mysqli_query($connection,$query);
        if($result_set){
            if(mysqli_num_rows($result_set) == 1){
                $errors[] = "Email address already exists";
            }
        }
        
        if(empty($errors))
        {
            $first_name = mysqli_real_escape_string($connection,$_POST['first_name']);
            $last_name = mysqli_real_escape_string($connection,$_POST['last_name']);
            $email = mysqli_real_escape_string($connection,$_POST['email']);
            $password = mysqli_real_escape_string($connection,$_POST['password']);
            $hash_pass = sha1($password);

            $query = "INSERT INTO user(first_name,last_name,email,password,is_deleted)
                       VALUE('{$first_name}','{$last_name}','{$email}','{$hash_pass}',0)";

            $result = mysqli_query($connection,$query);
            if($result)
            {
                header('Location:users.php?user_added=true');
            }
            else
            {
                $errors[]="Failed to add the new record.";
            }
                
        }
        

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
    <h1>Add New User <span> <a href = "users.php"> < back to User List </a> </span></h1>
   <?php if(!empty($errors))
   {
             /* echo "<div class='errmsg'> <b> There were error(s) on your form.</b> <br><br>";
                foreach($errors as $error){
                    echo $error.'<br>';

                }
                echo '</div>';*/
        display_errors($errors);
      
    
    }
    else{

        $first_name = '';
        $last_name = '';
        $email = '';
        
    }
    ?>
    <?php echo '<br>' ?>
    <form action="add-user.php" method="POST" class="userform">

    <p>
        <label for="">First Name :</label>
        <input type="text" name="first_name" <?php echo  'value ="' . $first_name . '" '?> >
    </p>

    <p>
        <label for="">Last Name :</label>
        <input type="text" name="last_name" <?php echo  'value ="' . $last_name . '" '?> >
    </p>

    <p>
        <label for="">Email Address :</label>
        <input type="email" name="email" <?php echo 'value ="' . $email . '"'?>  >
    </p>

    <p>
        <label for="">New Password :</label>
        <input type="password" name="password" id="">
    </p>

    <p>
        <label for="">Confirm Password :</label>
        <input type="password" name="cpassword" id="">
    </p>

    <p>
        <label for="">&nbsp;</label>
        <button type="submit" name="submit">Save</button>
    </p>
    <p>
        <a href="Users.php?cancel">Cancel</a>
    </p>


</form>
</main>



</body>
</html>
<?php mysqli_close($connection) ?>