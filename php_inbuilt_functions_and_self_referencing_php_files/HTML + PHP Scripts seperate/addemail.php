<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Subscribe</title>
</head>
<body>
  <?php 
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  if(($first_name == NULL) || $last_name == NULL){
    die("<h2>Names should not be empty!!<br/>Try again!!</h2>");
  }
  //inserting data into email_list database
  //trying if connection is available or not
  try{
  $dbc = mysqli_connect('localhost','root','Mahir3.141326','elvis_store');
  }catch(Exception $e){
    die('<h2>It seems like servers are down. Please try again later.</h2>');
  }

  //query is made if the connection to the database server is made
  $query = "INSERT INTO email_list(first_name,last_name,email)" .
  "VALUES('$first_name','$last_name','$email');"; 
  //exception handling in database
  try{
  $result = mysqli_query($dbc,$query);
  }catch(Exception $e){
    if(mysqli_errno($dbc) == 1062)
      die('<h2>Email Already Added.</h2>');
    else
      die('<h2>Failed to Add Email. Please Try Again.</h2>');
  }

  //display message to user's browser if all works fine and exception is not thrown
  echo '<h2>Thank you for your valuable time ' . $first_name
  . ' ' . $last_name . '</h2><br/>';
  echo '<h2>You will recieve offers on Email: ' . $email . '</h2><br/>';

  mysqli_close($dbc);
  ?> 
</body>
</html>