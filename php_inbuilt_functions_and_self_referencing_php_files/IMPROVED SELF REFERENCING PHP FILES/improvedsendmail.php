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
    //notice how the function's statements are written outside php tags
    //we can do this with any php snippet whether it is function, if...else statements. BUT NOT FOR LOOPS
    //primarily we do this to avoid using echo for writing html form code
    function showForm(){
  ?>
    <!-- $_SERVER['PHP_SELF'] will give us name of file in which this code is written-->
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
      <label for Subject>Subject: </label>
      <!-- here below i have not used $subject and $email_text because these variables are declared after this
      script so no way we can reference them before they are created hence we global array POST to refer them-->
      <input type="text" name="subject" id="subject" value="<?php if(isset($_POST['submit'])){echo $_POST['subject'];}?>"><br/><br/>
      <label for email_text>Message body: <br/><br/></label>
      <textarea name="email_text" id="email_text"><?php if(isset($_POST['submit'])){echo $_POST['email_text'];}?></textarea><br/><br/>
      <input type="submit" name="submit" value="Submit" id="submit">
    </form>
  <?php 
    }
  ?>

  <?php

    //isset checks for variable is created or not
    //submit will be created when the form is submitted and doesn't exists when the script run for first time
    //if this 'if' is true then form is requested for the first time 
    if(!isset($_POST['submit'])){
      showForm();
    }
    
    else{
      $subject = $_POST['subject'];
      $email_text = $_POST['email_text'];
      //Self referencing script which will be represented to the user for the first time
      //and also will be checking for fields if empty or not. If empty then again generate the form
      //and display appropriate message and also retrieve already added field values
      //If not empty then the script will run and fetch all email addresses of users and send them mail.

      //This is improved version in which elvis don't have to go back and re-enter subject and email body
      //if he has missed one of those fields and got invalid email validation

      //Concepts used in this forms
      //1) Multiple php opening and closing to avoid writing html form(which is regenerated in case of invalidation)
      //in php script by using echo. Instead directly writing as html code.
      //validation of email to check if the body and subject of email are not empty
      //2) Using flags to determine if the html form has to be regenerated or not.
      //3) Self referencing PHP script because now this script will produce the html form with action doc equals to itself.
      //That is it will run this PHP script again if the form is submitted.
      //4) Sticky Form: The new Form will have the data entered previously which was not empty so that the user
      //have to just fill the data which was left empty.   

      //to show html form again with error
      $flag = false;
      if($subject && $email_text){
        echo '<h2>Email Validated Successfully. Intializing sending emails to users.</h2><br/><br/>';
      }
      else{
        $flag = true;
        if(!$subject){
          echo '<h2>Subject empty!!</h2><br/><br/>';
        }
        //use of empty() function
        if(empty($email_text)){
          echo '<h2>Body of email empty!!</h2><br/><br/>';
        }
      }
      //notice the next php script has closing braces of if(flag)
      //so that the below is generated only for the if statement and not for all conditions
      if($flag){
        showForm();
      }

      //if flag is false then the email is correct and we can initiate the request to
      //send emails to users
      else{
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
          echo "<h3>$row[0] $row[1] - $row[2]</h3>";
        }
        
        //closing connection with the database server
        mysqli_close($dbc);
      }
    }
  ?>
</body>
</html>