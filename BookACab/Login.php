<?php
/* @author Hemanth Yagnapu
   @studenID: 100039130
   This is a login page where the user will be able to use his credentials and login to the system */
?>

<html>
<head>
<h2>Login to CabsOnline</h2>
</head>
<body>

<form action='Login.php' method="POST">
<table>
<tr>
<td>Email <b style="color:red;">*</b>: </td> <td><input type="email" name="Email" required="Please enter your email"></td>
</tr>
<tr>
<td>Password<b style="color:red;">*</b> :</td> <td><input type="Password" name="Password" required="Please enter your password"></td>


</table>
<br/>
<input type="Submit" value="Login">
<br/>
<br>
New Member? <a href="Register.php"> Register Now </a>

</form>


<?php 


	if(!empty($_POST['Email']) && !empty($_POST['Password']))

{

$DBConnect = @mysqli_connect("mysql.ict.swin.edu.au", "s100039130","070390", "s100039130_db")
		Or die ("<p>Unable to connect to the database server.</p>". "<p>Error code ". mysqli_connect_errno().": ". mysqli_connect_error()). "</p>";

$email=$_POST['Email'];
$password=$_POST['Password'];

session_start();
$_SESSION["emailid"] = $email;

$SQLstring = "select * from Customer where EmailID='$email' and Password='$password'";
$queryResult = @mysqli_query($DBConnect, $SQLstring)
		Or die ("<p>Unable to query the Customer table.</p>"."<p>Error code ". mysqli_errno($DBConnect). ": ".mysqli_error($DBConnect)). "</p>";

$row=mysqli_fetch_row($queryResult);

if($row<=0)
{

echo '<h4 style="color:red;">Unable to login. Please check your credentials </h4>';

}

else
{

while($row)
{

$row=mysqli_fetch_row($queryResult);
header("Location:Booking.php");


}		
}



	mysqli_close($DBConnect);

}

?>


</body>
</html>