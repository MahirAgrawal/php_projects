<?php 
$dbc = mysqli_connect('localhost','root','Mahir3.141326')
or die('Could not connect ' . mysqli_connect_error());
mysqli_select_db($dbc,'aliendatabase');
$query = "SELECT firstname,lastname,email FROM aliens_abduction WHERE seen='yes';";
$result = mysqli_query($dbc,$query);
while($row = mysqli_fetch_row($result)){
  echo "Name: $row[0] $row[1] <br/>" .
  "Email: $row[2]<br/><br/>";
}
mysqli_close($dbc);
?>