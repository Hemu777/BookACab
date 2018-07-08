<?php
/* @author Hemanth Yagnapu
   @studenID: 100039130
   This page deals with assigning cabs to the users. Handled by the admin, no user allowed */
?>

<html>
<head>
<h2>Admin Page of CabsOnline</h2>
</head>
<body>
<form action='Admin.php' method="POST">
<p>1. Click the button below to search for all the unassigned booking requestswith a pick up time with in 2 hours</p>
<br/>
<input type="Submit" name= "submit" value="List all">
<br/>
<br>
</form>



<?php 

$DBConnect = @mysqli_connect("mysql.ict.swin.edu.au", "s100039130","070390", "s100039130_db")
		Or die ("<p>Unable to connect to the database server.</p>". "<p>Error code ". mysqli_connect_errno().": ". mysqli_connect_error()). "</p>";
if (isset($_POST['submit']))
{


$SQLstring = "select * from Booking WHERE PickupDateTime>now() and TIMEDIFF(PickupDateTime , NOW( ) )<'02:00:00' and Status='unassigned'"; //sql query to select the bookings only for the next 2 hours

$queryResult = @mysqli_query($DBConnect, $SQLstring)
		Or die ("<p>Unable to query the Booking table.</p>"."<p>Error code ". mysqli_errno($DBConnect). ": ".mysqli_error($DBConnect)). "</p>";





	$row = mysqli_fetch_row($queryResult);

	

	if($row>0)
{
	echo "<table width='100%' border='1'>";
	echo "<th>Reference ID</th><th>Customer Name</th><th>Passenger Name</th><th>Phone Number</th><th>Pick Up Address</th><th>Destination Address</th><th>Pick Up Time</th>";
	while ($row) {
		$SQLstringName="select Name from Customer WHERE EmailID='$row[10]'";
	$result=@mysqli_query($DBConnect, $SQLstringName)
		Or die ("<p>Unable to query the Booking table.</p>"."<p>Error code ". mysqli_errno($DBConnect). ": ".mysqli_error($DBConnect)). "</p>";
		$r = mysqli_fetch_row($result);
		$customerName=$r[0];
		echo "<tr><td>{$row[0]}</td>";
		echo "<td>$customerName </td>";
		echo "<td>{$row[1]}</td>";
		echo "<td>{$row[2]}</td>";
		
			if($row[3]!="")
			{
			echo "<td>".$row[3]."/". $row[4]." ". $row[5]."," .$row[6]."</td>";
			}
		else 
		{
			echo "<td>".$row[4]." ". $row[5]."," .$row[6]."</td>";
				
		}
		echo "<td>{$row[7]}</td>";
		echo "<td>{$row[8]}</td></tr>";
		$row = mysqli_fetch_row($queryResult);
	}
		echo "</table>";
}
else
{
	echo "No data available";
}
	
}



?>
<form>
<p>2. Input the reference number below and click 'update' button to assign a taxi to that request </p>

Reference Number: <input type="text" name="ReferenceNumber" required="">
<input type="Submit" name="submit" value="Update">
</form>

<?php


if(isset($_GET['ReferenceNumber']))
{
	
	$refnum=$_GET['ReferenceNumber'];
	
	$sql= "UPDATE Booking SET Status='assigned' WHERE RefID='$refnum'";
	$sqlresult=@mysqli_query($DBConnect, $sql)
		Or die ("<p>Invalid Referece Number.</p>"."<p>Error code ". mysqli_errno($DBConnect). ": ".mysqli_error($DBConnect)). "</p>";
		$numofRows=mysqli_affected_rows($DBConnect);
		if($numofRows>0)
		{
			echo '<i style="color:blue;"> Cab is assigned</i>';

		}
		else
		{
			echo '<i style="color:red;">Unable to assign a cab. Please check the Reference Number</i>';
		}
	

}
mysqli_close($DBConnect);
?>




</body>
</html>