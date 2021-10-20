<?php session_start() ?>

<?Php require_once('inc/connection.php');?>

<?php if(!isset($_SESSION['user_id'])){
    header('Location: index.php?redirect from Users');
} 
    $user_list ="";
    $search = "";    
    
    //getting the list of users
    if(isset($_GET['search']))
    {
        $search = mysqli_real_escape_string($connection,$_GET['search']);
        $query = "SELECT * FROM user WHERE (first_name LIKE '%$search%' or last_name Like '%$search%' or email LIKE '%$search%') AND is_deleted = 0 ORDER BY  id ";
    }
    else
    {
        $query ="SELECT * FROM user WHERE is_deleted = 0 ORDER BY  id ";
    }

    
    $users = mysqli_query($connection,$query);


    if($users)
    {
        while($user = mysqli_fetch_assoc($users)){
            $user_list .= "<tr> <td> {$user['first_name']} </td> <td>{$user['last_name']  }</td> <td>{$user['last_login'] }</td> <td> <a href='modify-user.php?user_id={$user['id']}'>Edit</a></td> <td><a href='delete-user.php?user_id={$user['id']}'>Delete</a></td> </tr>";
           // echo "<pre>".print_r($user)."</pre>";
        }
        
    }
    else{
        echo "Databse Query faild.";
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    
    <title>Log In-User Management System</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <header>
        
    <div class="appname"> User Management System </div>
        <div class="loggedin"> Welcome <?php echo $_SESSION['first_name']; ?> <a href="logout.php">Log OUt </a> </div>
 
    </header>
    <main>
        <h1>Users <span><a href="add-user.php"> + Add New</a> | <a href="Users.php">Refresh</a></h1>

        <div class="search">
            <form action="Users.php" method="GET">
               <p>
                    <input type="text" name="search" id="" placeholder="Type First Name , Last Name , or Email Address and Press Enter" value="<?php echo $search ?>" required>
               </p> 
            </form>
            
        </div>
        
        <table class="masterlist">
            <tr>
             <th>First Name</th>
             <th>Last Name </th>
             <th>Last login</th>
             <th>Edite</th>
             <th>Delete</th>
            </tr>
           <?php echo $user_list;?>
        </table>
    </main>

    
</html>
<?php mysqli_close($connection) ?>