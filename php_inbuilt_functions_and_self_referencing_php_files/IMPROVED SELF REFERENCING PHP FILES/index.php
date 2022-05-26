<!DOCTYPE html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>
      MakeMeElvis
    </title>
  </head>
  <body>
    <?php 
      function showForm(){
    ?>

        <!-- the if(isset()) checks if the variables are set and if true then print the values (sticky form) -->
        <h1>Enter your details for receiving great offers from ELVIS STORE!</h1>
        <form name="email_list" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
        <label for first_name>First Name: </label>
        <input type="text" name="first_name" id="first_name" value="<?php if(isset($_POST['first_name']))echo $_POST['first_name'];?>"><br/><br/>
        <label for last_name>Last Name: </label>
        <input type="text" name="last_name" id="last_name" value="<?php if(isset($_POST['last_name']))echo $_POST['last_name'];?>"><br/><br/>
        <label for email>Email: </label>
        <input type="email" name="email" id="email" value="<?php if(isset($_POST['email']))echo $_POST['email'];?>"><br/><br/>
        <input type="submit" name="submit" id="submit" value="Submit">
        <input type="reset" name="reset" id="submit" value="reset">
        </form>
    <?php 
      }
      //if isset is false i.e the 'if' condition gets true that means the form is requested for the first time
      if(!isset($_POST['submit'])){
        showForm();
      }
      //form is submitted
      else{
        //this flag is used to decide whether to regenerate form(due to empty fields) 
        //or approve it and add it to database
        $flag = false;
        
        //to store the variables which are empty(if any)
        $mssg = array();
        //checking if any of the fields is empty
        foreach($_POST as $key => $value){
          $flag |= empty($value); 
          if(empty($value)){
            //this formatting to hide the key name of data from end-user
            $mssg[] = str_replace('_',' ',strtoupper($key));
          }
        }
        //if any of the field is empty then regenerate the form
        //and with partially filled values retained i.e. sticky form
        if($flag){
          //show which fields are empty
          foreach($mssg as $var){
            echo "<h3> $var can't be empty</h3>";
          }
          showForm();
        }

        //all fields are filled so process the request of adding the email to database
        else{
          try{
            $dbc = mysqli_connect('localhost','root','Mahir3.141326','elvis_store');
          }catch(Exception $e){
            die('<h2>Could not connect to the database Try again later</h2>');
          }
          $first_name = $_POST['first_name'];
          $last_name = $_POST['last_name'];
          $email = $_POST['email'];
          $query = "INSERT INTO email_list(first_name,last_name,email) VALUES('$first_name','$last_name','$email');";
          
          // echo $query;
          try{
            $result = mysqli_query($dbc,$query);
            // echo $result;
          }catch(Exception $e){
            //duplicate key error
            if(mysqli_errno($dbc) == 1062)
              die('<h2>Email Already Added.</h2>');
            else      
              die('<h2>Could not connect to the database Try again later</h2>');
          }
          echo "<h2>Thank you $first_name $last_name<br/> Your email: $email has been added.</h2>";
          mysqli_close($dbc);
        }
      }
    ?>
  </body>
</html>
