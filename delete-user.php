<?php session_start();?>
<?Php require_once('inc/connection.php');?>
<?Php require_once('inc/functions.php');?>




<?php


    if(!isset($_SESSION['user_id']))
    {
            header('Location:index.php?redirect from delete-user');
    }
    
    else
    {
        if(isset($_GET['user_id'])){
            //getting the usre information
            $user_id = mysqli_real_escape_string($connection,$_GET['user_id']);
            if($user_id == $_SESSION['user_id'])
            {
                //should not delete current user
                header('Location:Users.php?err=cannot_delete_current_user');
            }
            else
            {
                //delete the user
                //$query = "UPDATE user set is_deleted=1 where id ={$user_id} LIMIT 1";
                $query = "UPDATE user SET is_deleted = 1 WHERE id = {$user_id} LIMIT 1";
                $reult = mysqli_query($connection,$query);
                if($reult)
                {
                    //user deleted
                    header('Location:Users.php?err=user_deleted');
                }
                else
                {
                    header('Location:Users.php?err=delete_faild');
                }
            }
           
        }
        else
        {
            header('Location:Users.php?err=user id missing');
        }
    }
    
   


    
?>


