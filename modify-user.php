<?Php require_once('inc/connection.php');?>
<?Php require_once('inc/functions.php');?>
<?php session_start() ?>

<?php
        //$user_id = "";
       
        if(!isset($_SESSION['user_id']))
        {
            header('Location:index.php?redirect from modify');
        }

       
        $errors = array();

    
    if(isset($_POST['submit']))
    {  
        $user_id = $_POST['user_id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];

        //if(empty(trim($_POST['user_id']))){
          //  echo "userid wme";
            //we can redirect
        //}
        if(empty (trim ($_POST['first_name']) )){
            $first_name = "";
        }if(empty (trim ($_POST['last_name']) ))
        {
            $last_name = "";
        }
    
        

        $req_fields = array('first_name' => 50,'last_name' => 100);
       
       foreach($req_fields as $field => $max_len){

           if(empty(trim($_POST[$field]))){

               $errors[] = $field . ' is required';
            } 
            if(strlen(trim($_POST[$field])) > $max_len)
                 {
                     $errors[] = $field .' must be less than ' . $max_len .' characters';
                 }         
    
        }
      
       

        if(!is_email($_POST['email'])){
            $errors[] = 'Email address is Invalid';
        }
        else
        {
            if(strlen(trim($_POST['email'])) > 100)
            {
                $errors[] = 'Email must be less than 100 characters';
            }
        }

        //checking if mail address already exists
        $email = mysqli_real_escape_string($connection,$_POST['email']);
        $query = "SELECT * FROM user WHERE email = '{$email}' AND id != {$user_id} LIMIT 1";

        $result_set = mysqli_query($connection,$query);
        if($result_set){
            if(mysqli_num_rows($result_set) == 1)
            {
                
                $errors[] = "Email address already exists";
            }
        }
        
        if(empty($errors))
        {
            $first_name = mysqli_real_escape_string($connection,$_POST['first_name']);
            $last_name = mysqli_real_escape_string($connection,$_POST['last_name']);
            
            $query ="UPDATE user SET ";
            $query .= "first_name = '{$first_name}', ";
            $query .= "last_name = '{$last_name}', ";
            $query .= "email = '{$email}' ";
            $query .= "WHERE id = {$user_id} LIMIT 1 ";

            $result = mysqli_query($connection,$query);
            if($result)
            { 
               header("Location:users.php?user_modified=true");
            }
            else
            {
                $errors[]="Failed to modify the record.";
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
    <h1>View / Modify User <span> <a href = "users.php"> < back to User List </a> </span></h1>
    <?php
         if(!empty($errors))
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
    <form action="modify-user.php" method="POST" class="userform">
    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
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
        <label for="">Password :</label>
        <span class='sp'>*********</span> | <a href ="change-password.php?user_id=<?php echo $user_id;?>" style="font-size:20px;">Change Password</a>
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