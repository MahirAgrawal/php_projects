<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alien's Abducted Report</title>
</head>
<body>
  Thanks for valuable time to submit report!!<br/><br/>
  <?php
    //fetching data from form which was submitted
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $when_it_happened = $_POST['when_it_happened'];
    $what_happened = $_POST['what_happened'];
    $how_long = $_POST['how_long'];
    $email = $_POST['email'];
    $seen = $_POST['seen'];
    //echo gives output to browser
    echo 'You were abducted by aliens on ' . $when_it_happened . '<br/><br/>';
    echo 'You were kept by aliens for ' . $how_long . '<br/><br/>';
    echo 'What had happened to you: ' . $what_happened . '<br/><br/>';
    echo 'My dog was spotted: ' . $seen . '<br/><br/>';

    //for mailing purposes
    $to = "mahirwebdevelopment@gmail.com";
    $sub = "Alien Abduction Report";
    $name = $firstname . ' ' . $lastname;
    // '/n' is only understood by email and not browser so when we try to echo the mssg '/n'
    //will not be translated into newline
    $mssg = "I am $name\n" . 
    "$name was abducted on $when_it_happened for $how_long\n" .
    "What happened to $name : $what_happened\n" .
    "Did $name saw my dog: $seen";
    
    //for storing in the database on server
    $dbc = mysqli_connect("localhost","root","Mahir3.141326","aliendatabase")
    or die('Could not connect to database' . mysqli_connect_error());
    $query = "INSERT INTO aliens_abduction(firstname,lastname" .
    ",when_it_happened,how_long,what_happened,seen,email) VALUES" .
    "('$firstname','$lastname','$when_it_happened','$how_long','$what_happened'" .
    ",'$seen','$email');";
    // echo $query;
    $result = mysqli_query($dbc,$query);
    // echo 'Result of insertion' . $result;
  ?>
</body>
</html>