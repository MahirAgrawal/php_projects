<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Unsubscribe</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <?php 
    function makeselectionBox($email){
      // email[] is written as with [] below to indicate that multiple values can go
      // with it and in $_POST array also the key:value pair will contain the name(here email) as key
      // and all the values associated with it as members of values' array
      //key=>value looks like email=>{0,1,2,3,...}  
      ?>
    <input type="checkbox" name="email[]" value="<?php echo $email;?>" id="selectionbox">
    <label for="selectionbox"><?php echo $email;?></label>
    <br/>
  <?php
    }
  ?>

  <h1>Please select your email to unsubscribe from mailing list</h1><br/><br/>
  <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
    <?php
      if(isset($_POST['submit'])){
        if(isset($_POST['email'])){
          //selected emails should be deleted from database
          //so connection is made with the database
          try{
            $dbc = mysqli_connect('localhost','root','Mahir3.141326','elvis_store');
          }catch(Exception $e){
            die('<h2>Could not connect to the database Try again later</h2>');
          }                
          foreach($_POST['email'] as $email){
            $query = "DELETE FROM email_list WHERE email='$email';";
            try{
            $result = mysqli_query($dbc,$query);
            }catch(Exception $e){
              die('<h2>Could not connect to the database Try again later</h2>');
            }
            // echo $query . '<br>';
          }
          //closing the connection with database
          echo '<h2>Selected email(s) were successfully unsubscribed from our email list.</h2>';
          mysqli_close($dbc);
        }
        else{
          echo '<h2>You have not selected any emails</h2>';
        }
      }

      //display remaining emails
      try{
        $dbc = mysqli_connect('localhost','root','Mahir3.141326','elvis_store');
      }catch(Exception $e){
        die('<h2>Could not connect to the database Try again later</h2>');
      }

      $query = "SELECT email FROM email_list;";
      try{
      $result = mysqli_query($dbc,$query);
      }catch(Exception $e){
        die('<h2>Could not connect to the database Try again later</h2>');
      }
      while($var = mysqli_fetch_row($result)){
        makeselectionBox($var[0]);
      }
      mysqli_close($dbc);
    ?>
    <br/>
    <input type="submit" name ="submit" value="Unsubscribe" id="submit">
  </form>
</body>
</html>