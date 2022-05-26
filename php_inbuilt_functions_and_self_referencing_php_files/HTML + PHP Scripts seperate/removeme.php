<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Unsubscirbe</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <?php 
    $email = $_POST['email'];
    $reason = $_POST['email_text'];
    try{
      //establishing connection with the database server
      $dbc = mysqli_connect("localhost","root","Mahir3.141326","elvis_store");
    }catch(Exception $e){
      die("Cannot connect to the servers. Please try again!!");
    }
    //preparing query in the form of string
    $query = "DELETE FROM email_list WHERE email='$email';";

    echo $email . '<br/>' . $reason . '<br/>';

    //querying the database with the connection and query given
    try{
      $result = mysqli_query($dbc,$query);
      }catch(Exception $e){
        die('<h2>Failed to unsubscirbe. Please Try Again.</h2>');
      }
    
    echo '<h2>You will not recieve any future offers via emails from us!</h2>';
    
    //closing connection with the database server
    mysqli_close($dbc);
  ?>
</body>
</html>