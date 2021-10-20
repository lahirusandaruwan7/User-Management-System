<?Php require_once('inc/connection.php');?>

<?php
   /*
        INSERT INTO table_name(
          column1, column2,etc
        ) VALUES(
            value1, value2,etc
        )
   */
    $first_name = 'Nuwan';
    $last_name  = 'Pradeep';
    $email      =  'Nuwan@gmail.com';
    $password   =  '1234';
    $is_deleted =  0;

    $hashed_password = sha1($password);

    $query ="INSERT INTO user(first_name,last_name,email,password,is_deleted)
    VALUES('{$first_name}','{$last_name}','{$email}','{$hashed_password}',{$is_deleted}) ";

   
    $result = mysqli_query($connection,$query);

    if($result){
        echo "1 Record added";
    }
    else{
        echo "Database Query Failed.";
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Query</title>
</head>
<body>
    <h1>Connect to Database</h1>
</body>
</html>
<?php mysqli_close($connection) ?>