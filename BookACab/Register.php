<?php
/* @author Hemanth Yagnapu
   @studenID: 100039130 
   Provides registration form for the user to register his/her details*/
?>
<html>
<head>
<h2>Register to CabsOnline</h2>
</head>
<body>

<form action='Register.php' method="POST">
<table>
<tr>
<td>Name<b style="color:red;">*</b>:</td> <td><input type="text" name="Name" required></td>
</tr>
<tr>
<td>Password<b style="color:red;">*</b>:</td> <td><input type="Password" name="Password" required></td>
</tr>
<tr>
<td>Confirm Password<b style="color:red;">*</b>:</td> <td><input type="Password" name="ConfirmPassword" required></td>
</tr>
<tr>
<td>Email<b style="color:red;">*</b>:</td> <td><input type="email" name="Email" required></td>
</tr>
<tr>
<td>Phone Number<b style="color:red;">*</b>:</td> <td><input type="text" name="PhoneNumber" required></td>
</tr>

</table>
<br/>
<input type="Submit" value="Register">
<br/>
<br>
Already a Member? <a href="Login.php"> Login Now </a>

</form>



<?php 



	if(!empty($_POST['Name']) && !empty($_POST['Password']) && !empty($_POST['ConfirmPassword']) && !empty($_POST['Email']) && !empty($_POST['PhoneNumber']))

{


$name=$_POST['Name'];
$password=$_POST['Password'];
$confirmPassword=$_POST['ConfirmPassword'];
$email=$_POST['Email'];
$phoneNumber=$_POST['PhoneNumber'];

if($password==$confirmPassword)
{
session_start();
$_SESSION["emailid"] = $email;

$DBConnect = @mysqli_connect("mysql.ict.swin.edu.au", "s100039130","070390", "s100039130_db")
		Or die ("<p>Unable to connect to the database server.</p>". "<p>Error code ". mysqli_connect_errno().": ". mysqli_connect_error()). "</p>";


$SQLstring = "INSERT INTO `s100039130_db`.`Customer` (`Name`, `Password`, `EmailID`, `PhoneNo`) VALUES ('$name', '$password', '$email', '$phoneNumber');"; //sql query inserting all the details of the user
$queryResult = @mysqli_query($DBConnect, $SQLstring)
		Or die ("<p>Email ID already exist.</p>"."<p>Error code ". mysqli_errno($DBConnect). ": ".mysqli_error($DBConnect)). "</p>"; 


header("Location:Booking.php");



	mysqli_close($DBConnect);
}
else
{
echo '<h4 style="color:red;"> Please enter the same password </h4>';

}


}
?>


</body>
</html>