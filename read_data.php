<?Php
     require_once('inc/connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
     $sql = "SELECT * FROM user WHERE first_name='lahiru' ";
     $result = mysqli_query($connection, $sql);
     
     $resultCheck = mysqli_num_rows($result);

     if($resultCheck > 0){
         while($row = mysqli_fetch_assoc($result)){
             echo $row['last_name']."<br>";
         }
     }


?>
</body>
</html>