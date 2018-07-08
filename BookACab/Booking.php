<?php
/* @author: Hemanth Yagnapu 
   @studenID: 100039130 
   This page handles the booking details of the cab provided by the user*/

session_start(); //Start the session
?>
<html>
<head>
<h2>Booking a Cab</h2>
</head>
<body>

<form action='Booking.php' method="POST">
Please fill the fields below to book a taxi
<table>
<tr>
<td>Passenger Name <b style="color:red;">*</b>:</td> <td><input type="text" name="PassengerName" required></td>
</tr>
<tr>
<td>Phone Number<b style="color:red;">*</b>:</td> <td><input type="text" name="PhoneNumber" required=""></td>
</tr>
<tr>
<td>PickUp Address: </td> <td>Unit Number:</td> <td><input type="text" name="UnitNumber"></td>
			<tr> <td></td><td>Street Number<b style="color:red;">*</b>:</td> <td><input type="text" name="StreetNumber" required=""></td></tr>
			<tr><td></td> <td>Street Name<b style="color:red;">*</b>:</td> <td><input type="text" name="StreetName" required=""></td> </tr>
			<tr> <td></td><td>Suburb<b style="color:red;">*</b>:</td> <td><input type="text" name="Suburb" required=""></td> </tr>

</tr>
<tr>
<td>Destination Suburb<b style="color:red;">*</b>:</td> <td><input type="text" name="DestinationSuburb" required=""></td>
</tr>
<tr>
<td>Pickup Date<b style="color:red;">*</b>:</td> <td><input type="date" name="PickupDate" required=""></td> 
<td style="color:blue;"> Please use the format yyyy-mm-dd </td> 
</tr>
<tr>
<td>Pickup Time<b style="color:red;">*</b>:</td> <td><input type="time" name="PickupTime" required=""></td> 
<td style="color:blue;"> Please use the format hh:mm:ss </td>
</tr>



</table>
<br/>
<input type="Submit" value="Book">
<br>
<br>
<i>Fields with asterisk (*) are mandatory</i>



</form>


<?php 


if(!empty($_POST['PassengerName']) && !empty($_POST['PhoneNumber']) && !empty($_POST['StreetNumber']) && !empty($_POST['StreetName']) && !empty($_POST['Suburb']) && !empty($_POST['DestinationSuburb']) && !empty($_POST['PickupDate']) && !empty($_POST['PickupTime']))



{



$email=$_SESSION["emailid"];
$passengerName=$_POST['PassengerName'];
$phoneNo=$_POST['PhoneNumber'];
$unitNo=$_POST['UnitNumber'];
$streetNo=$_POST['StreetNumber'];
$streetName=$_POST['StreetName'];
$suburb=$_POST['Suburb'];
$destSuburb=$_POST['DestinationSuburb'];
$pickupDate=date('Y-m-d', strtotime($_POST['PickupDate']));
$pickupTime=date('H:i:s', strtotime($_POST['PickupTime']));


$pickupDateTime=date('Y-m-d H:i:s', strtotime("$pickupDate $pickupTime"));
$bookingDateTime=date('Y-m-d H:i:s');

$to_time = strtotime("$pickupDateTime");
$from_time = strtotime("$bookingDateTime");
if(round(abs($to_time - $from_time) / 60,2)>60 && $to_time>$from_time)
{
	$DBConnect = @mysqli_connect("mysql.ict.swin.edu.au", "s100039130","070390", "s100039130_db")
		Or die ("<p>Unable to connect to the database server.</p>". "<p>Error code ". mysqli_connect_errno().": ". mysqli_connect_error()). "</p>";

$SQLstring = "INSERT INTO `s100039130_db`.`Booking` (`RefID`, `PassengerName`, `PhoneNo`, `UnitNumber`, `StreetNumber`, `StreetName`, `Suburb`, `DestSuburb`, `PickupDateTime`, `BookingDateTime`, `EmailID`, `Status`) VALUES (NULL, '$passengerName', '$phoneNo', '$unitNo', '$streetNo', '$streetName', '$suburb', '$destSuburb', '$pickupDateTime', '$bookingDateTime', '$email', 'unassigned');"; 
$queryResult = @mysqli_query($DBConnect, $SQLstring)
		Or die ("<p>Please check the values entered.</p>"."<p>Error code ". mysqli_errno($DBConnect). ": ".mysqli_error($DBConnect)). "</p>";

		$values = "select MAX(RefID) from Booking"; //retrieving the latest reference id of the customer via sql query
		$result=@mysqli_query($DBConnect, $values);
		$row=mysqli_fetch_row($result);
		$refID=$row[0];


echo "<p>Dear $passengerName. Thanks for booking with CabsOnline! Your booking reference number is $refID. We will pick up the passengers in front of your provided address at $pickupTime on $pickupDate.</p>";

$to= $email;
$subject= "Your booking request with CabsOnline!";
$message= "Dear $passengerName , 
			  	Thanks for booking with CabsOnline! Your booking reference number is $refID. We will pick up the passengers in front of your provided address at $pickupTime on $pickupDate.";
$headers= "From booking@cabsonline.com.au";

mail($to, $subject, $message, $headers, "-r 100039130@student.swin.edu.au"); //Mail function to send the email directly from Apache server


	mysqli_close($DBConnect);

	}
	else
	{
		echo "Please book the cab after 1 hour from now";

	}


}



?>


</body>
</html>