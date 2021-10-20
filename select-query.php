<?Php require_once('inc/connection.php');?>

<?php
 
 $query = "SELECT * From user";

 $result_set = mysqli_query($connection,$query);

 if($result_set){
     //Checking How Many records return from the query
     echo mysqli_num_rows($result_set) . " Recods found . <hr>";

     $table = '<table>';
     $table .= '<tr> <th>ID</th> <th>First Name</th> <th>Last Name</th> <th>Email</th> </tr>';
     while ($record = mysqli_fetch_assoc($result_set)){
         $table .= '<tr>';
         $table .= '<td>' . $record['id'] .'</td>';
         $table .= '<td>' . $record['first_name'] .'</td>';
         $table .= '<td>' . $record['last_name'] .'</td>';
         $table .= '<td>' . $record['email'] .'</td>';
        }
        $table .='</table>';
    
    
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Query</title>
    <style>
        table{border-collapse:collapse;}
        td,th{border:1px solid black;padding:10px}
    </style>
</head>
<body>
    <h1>Connect to Database</h1>
    <?php echo $table; ?>
</body>
</html>
<?php mysqli_close($connection) ?>