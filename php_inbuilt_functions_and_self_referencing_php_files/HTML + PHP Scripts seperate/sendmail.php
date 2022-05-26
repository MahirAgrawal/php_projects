<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SendMail</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <?php 
    $subject = $_POST['subject'];
    $email_text = $_POST['email_text'];


    //validation of email to check if the body and subject of email are not empty
    ///empty checks for the variable passed in the argument is set and if empty or not
    //hence no need to check for isset() seperately
    //empty() is preferred mostly to check if the variable is set or not
    //because for variable is empty or not can be checked by using variable itself because of php converting
    //data to boolean values in conditional and loops statement

    if($subject && $email_text){
      echo 'Email Validated Successfully. Intializing sending emails to users.<br/>';
    }
    else{
      if(!$subject){
        echo 'Subject empty!!<br/>';
      }
      //use of empty() function
      if(empty($email_text)){
        echo 'Body of email empty!!<br/>';
      }
      die('Cannot send email with empty fields. Please try again.<br/>');
    }

    try{
      //establishing connection with the database server
      $dbc = mysqli_connect("localhost","root","Mahir3.141326","elvis_store");
    }catch(Exception $e){
      die("Cannot connect to the servers. Please try again!!");
    }
    //preparing query in the form of string
    $query = "SELECT first_name,last_name,email FROM email_list;";

    //querying the database with the connection and query given
    try{
      $result = mysqli_query($dbc,$query);
      }catch(Exception $e){
        die('<h2>Failed to Fetch Email List.</h2>');
      }
    
    //row is considered true until it becomes empty or null i.e.
    //it will loop while there is row left to be fetched from result resource id memory
    while($row = mysqli_fetch_row($result)){
      echo "$row[0] $row[1] - $row[2]<br/>";
    }
    
    //closing connection with the database server
    mysqli_close($dbc);
  ?>
</body>
</html>