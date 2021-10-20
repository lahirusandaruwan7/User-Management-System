<?Php require_once('inc/connection.php');?>
<?php
$query = "UPDATE user SET email = 'Admin@gmail.com'   WHERE id = 1";

$result_set = mysqli_query($connection, $query);

//mysqli_affected_rows() = returns number of rows affected
if($result_set){
    echo mysqli_affected_rows($connection) . " Records Updated";
}
else{
    echo "Database query failed.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Query</title>
</head>
<body>
    <h1>Connect to Database</h1>
</body>
</html>
<?php mysqli_close($connection) ?>