<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['admintoken'])==0)
{	
	header('location:index.php');
}else{


	if(isset($_GET['m']))
	{
		
		$mechanic= mysqli_real_escape_string($dbh,$_GET['m']);
		$BID= mysqli_real_escape_string($dbh,$_GET['BID']);
		
	
		$sql="update bookings set status='2',mechanic='$mechanic' where BID='$BID'";
	
		if($dbh->query($sql) === TRUE)
		{
		
			echo "<script type=\"text/javascript\">".
					"alert('Mechanic Assigned successfully');".
					"window.location.href='bookings.php';".
				"</script>";
		}
		else 
		{
		
			echo "<script type=\"text/javascript\">".
					"alert('Something went wrong. Please try again!');".
					"window.location.href='bookings.php';".
				"</script>"; 
		}
	
	}

	//if assign cost button is clicked
	if(isset($_GET['cost']))
	{
		 //fetch form data
		$cost= mysqli_real_escape_string($dbh,$_GET['cost']);
		$BID= mysqli_real_escape_string($dbh,$_GET['BID']);
		$arr= mysqli_real_escape_string($dbh,$_GET['parts']);

		//split parts data into array
		$parts = explode(',',$arr);

		//loop over parts
		foreach ($parts as $part) {

			//get part name and cost
			$part_cost = explode('@',$part)[1];
			$name = explode('@',$part)[0];
			
			//query to insert each part data
			$sql="INSERT INTO parts(BID, name, cost) VALUES('$BID','$name','$part_cost')";
			$dbh->query($sql);
		}
		
	
		//query to update booking cost and status
		$sql="update bookings set status='3',cost='$cost' where BID='$BID'";
		//execute query
		if($dbh->query($sql) === TRUE)
		{
			echo "<script type=\"text/javascript\">".
					"alert('Cost Assigned successfully');".
					"window.location.href='bookings.php';".
				"</script>";
		}
		else 
		{
			echo "<script type=\"text/javascript\">".
					"alert('Something went wrong. Please try again!');".
					"window.location.href='bookings.php';".
				"</script>"; 
		}
	
	}

?>
<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	
	<title>Admin Dashboard</title>

	<!-- Font awesome -->
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- Sandstone Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Bootstrap Datatables -->
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<!-- Bootstrap social button library -->
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<!-- Bootstrap select -->
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<!-- Bootstrap file input -->
	<link rel="stylesheet" href="css/fileinput.min.css">
	<!-- Awesome Bootstrap checkbox -->
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@dashboardcode/bsmultiselect@1.1.18/dist/css/BsMultiSelect.bs4.min.css">
	

	<!-- Admin Stye -->
	<link rel="stylesheet" href="css/style.css">
	
	<style>
	/*styles for table*/

		table {
			margin: auto;
			font-family: "Lucida Sans Unicode", "Lucida Grande", "Segoe Ui";
			font-size: 12px;
			text-align:left;
		}

		h1 {
			margin: 25px auto 0;
			text-align: center;
			text-transform: uppercase;
			font-size: 17px;
		}

		table td {
			transition: all .5s;
		}
		
		/* Table */
		.data-table {
			border-collapse: collapse;
			font-size: 14px;
			min-width: 537px;
		}

		.data-table th, 
		.data-table td {
			border: 1px solid #e1edff;
			padding: 7px 17px;
		}
		.data-table caption {
			margin: 7px;
		}

		/* Table Header */
		.data-table thead th {
			background-color: #50bb7e;
			color: #bc4a27;
			border-color: block !important;
			text-transform: uppercase;
			
		}

		/* Table Body */
		.data-table tbody td {
			color: #353535;
		}

		.data-table tbody tr:nth-child(odd) td {
			background-color: #c0ce9f;
		}
		.data-table tbody tr:hover td {
			background-color: #ffffb7;
			border-color: #ffff0f;
		}

		/* Table Footer */
		.data-table tfoot th {
			background-color: #e5f5ff;
			text-align: right;
		}
		.data-table tfoot th:first-child {
			text-align: left;
		}
		.data-table tbody td:empty
		{
			background-color: #ffcccc;
		}
		table button,input[type=submit] {
			padding: 10px;
			background-color: green;
			border: 0px;
			border-radius: 4px;
			color: #fff;
		}
		.btn_submit {
			padding: 10px;
			background-color: green;
			border: 0px;
			border-radius: 4px;
			color: #fff;
		}

		.form-check-label {
			padding-left: 20px !important;
		}
	</style>
</head>

<body>
<?php include('includes/header.php');?>

	<div class="ts-main-content">
<?php include('includes/leftbar.php');?>
		<div class="content-wrapper" style="margin-left:160px">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">
						<h3 class="page-title">Bookings</h3>
						 <?php

								$start = "";
								$end = "";

								//if date filter is set
								if (isset($_GET['start']) && isset($_GET['end'])) {
									$start = $_GET['start'];
									$end = $_GET['end'];
								}

								// query to select booking detail.
								$sql = "select user.fname,user.lname,user.email,user.mobile,
								vehicle.type,vehicle.make,vehicle.licence_details,vehicle.engine_type,
								bookings.booking_date,bookings.description,bookings.BID,bookings.timestamp,
								bookings.booking_type,bookings.mechanic,bookings.cost,bookings.status  
								from bookings 
								inner join user on user.UID = bookings.UID 
								inner join vehicle on vehicle.VID = bookings.VID 
								order by timestamp desc";

								//query with filter
								if ($start != "") {
									$sql = "select user.fname,user.lname,user.email,user.mobile,
								vehicle.type,vehicle.make,vehicle.licence_details,vehicle.engine_type,
								bookings.booking_date,bookings.description,bookings.BID,bookings.timestamp,
								bookings.booking_type,bookings.mechanic,bookings.cost,bookings.status  
								from bookings 
								inner join user on user.UID = bookings.UID 
								inner join vehicle on vehicle.VID = bookings.VID 
								where booking_date between '$start' and '$end'  
								order by timestamp desc";
								}
								//execute query
								$query = mysqli_query($dbh, $sql);
								echo '<div id="filter_data" style="margin-left: 40px;height: 21px;"><input id="start_date" value="'.$start.'" type="date" style="height: 35px;width:200px;">&nbsp;&nbsp;To&nbsp;&nbsp;<input id="end_date" value="'.$end.'" type="date" style="height: 35px;width:200px;">&nbsp;&nbsp;<button style="padding: 7px;width: 70px;background-color: green;border: 0px;border-radius: 4px;color: #fff;"  onclick="fetchData()">Search</button></div><br>';
								
								//echo mysql_num_rows($query);
								if (mysqli_num_rows($query)==0) {
									echo '<h2>No Data Available</h2>';
								}else {
									
								echo '<table class="data-table">';
								echo '<caption class="title"></caption>';
								echo '<thead>';
								//table header
									echo '<tr>';
										echo '<th>Booking Id</th>';
										echo '<th>Customer Detail</th>';
										echo '<th>Vehicle Detail</th>';
										echo '<th>Booking Detail</th>';
										echo '<th>Mechanic</th>';
										echo '<th>Cost</th>';
										echo '<th>Status</th>';
										echo '<th>Action</th>';
									echo '</tr>';
									
								echo '</thead>';
								echo '<tbody>';
								
								//fetch rows
								while ($row = mysqli_fetch_array($query))
								{
									//set booking type
									echo "<tr>";
									$BID= $row['BID'];
									$type= $row['booking_type'];
									$booking_type = "";
									if ($type == '1') {
										$booking_type = "Annual Service";
									} else if ($type == '2') {
										$booking_type = "Major Service";
									} else if ($type == '3') {
										$booking_type = "Repair / Fault";
									} else {
										$booking_type = "Major Repair";
									}
									
									echo "<td>".$row['BID']."</td>";
									echo "<td><b>Name: </b>".$row['fname'].' '.$row['lname'].
									"<br><b>Email: </b>".$row['email'].
									"<br><b>Mobile: </b>".$row['mobile']."</td>";
									
									echo "<td><b>Vehicle Type: </b>".$row['type'].
									"<br><b>Vehicle Make: </b>".$row['make'].
									"<br><b>License Details: </b>".$row['license_details'].
									"<br><b>Engine Type: </b>".$row['engine_type']."</td>";

									echo "<td><b>Booking Type: </b>".$booking_type.
									"<br><b>Booking Date: </b>".date('d-m-Y',strtotime($row['booking_date'])).
									"<br><b>Description: </b>".$row['description']."</td>";

									echo "<td>".$row['mechanic']."</td>";
									if ($row['cost'] == '' || $row['cost'] == null) {
										echo "<td></td>";	
									}else {
										echo "<td>€".$row['cost']."</td>";
									}

									//set button according to booking status
									if ($row['status'] == '1') {
										echo "<td>Booked</td>";
										echo "<td><button onclick=\"assignMechanic('$BID')\" >Assign Mechanic</button</td>";
									}else if ($row['status'] == '2') {
										echo "<td>In Service</td>";
										echo "<td><button onclick=\"assignCost('$BID','$type')\" >Assign Cost</button</td>";
									}else if ($row['status'] == '3') {
										echo "<td>Fixed</td>";
										echo "<td><button onclick=\"Print('$BID')\" >Print Invoice</button</td>";
									}
									
											
									echo "</tr>";

								}
								
							echo '</tbody>';
							
							echo '</table>';
								}
								 

							echo '<br />';
							echo '<hr />';
							echo '<hr />';

								 ?>
								 
					

				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="assignMechanic" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Assign Mechanic</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="BID">
				<select id="select-mechanic" class="form-control">
					<option value="-1">Select Mechanic</option>
					<option value="Jack Murphy">Jack Murphy</option>
					<option value="James Kelly">James Kelly</option>
					<option value="Noah Byrne">Noah Byrne</option>
					<option value="Rían Ryan">Rían Ryan</option>
					<option value="Michael Doyle">Michael Doyle</option>
					<option value="Thomas Walsh">Thomas Walsh</option>
				</select>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn_submit" onclick="addMechanic()">Submit</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="assignCost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Assign Cost</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="CBID">
				<input type="hidden" id="type">
				<select id="parts" class="form-control" multiple name="parts">
				<option value="ABS BRAKE UNIT@65.99">ABS BRAKE UNIT (65.99)</option>
				<option value="ABS CONTROL MODULE@32.99">ABS CONTROL MODULE (32.99)</option>
				<option value="ABS SPEED SENSOR@8.99">ABS SPEED SENSOR (8.99)</option>
				<option value="AC CLUTCH@12.99">AC CLUTCH (12.99)</option>
				<option value="AC COMPRESSOR@32.99">AC COMPRESSOR (32.99)</option>
				<option value="AC CONDENSOR@26.99">AC CONDENSOR (26.99)</option>
				<option value="AC EVAPORATOR@21.99">AC EVAPORATOR (21.99)</option>
				<option value="AC HOSE DOUBLE@16.99">AC HOSE DOUBLE (16.99)</option>
				<option value="AC HOSE SINGLE@12.99">AC HOSE SINGLE (12.99)</option>
				<option value="HOOD INSULATION@4.99">HOOD INSULATION (4.99)</option>
				<option value="HOOD LATCH@8.99">HOOD LATCH (8.99)</option>
				<option value="HOOD ORNAMENT@3.99">HOOD ORNAMENT (3.99)</option>
				<option value="HOOD PROP@5.99">HOOD PROP (5.99)</option>
				<option value="HOOD W/GRILL@65.99">HOOD W/GRILL (65.99)</option>
				<option value="HORN@4.99">HORN (4.99)</option>
				<option value="HUB CAP-REGULAR@5.99">HUB CAP-REGULAR (5.99)</option>
				<option value="SPEEDOMETER-DIGITAL@23.99">SPEEDOMETER-DIGITAL (23.99)</option>
				<option value="SPEEDOMETER-REGULAR@13.99">SPEEDOMETER-REGULAR (13.99)</option>
				<option value="SPINDLE/KNUCKLE@18.99">SPINDLE/KNUCKLE (18.99)</option>
				<option value="STEERING WHEEL COVER@2.99">STEERING WHEEL COVER (2.99)</option>
				<option value="TRUNK LID@43.99">TRUNK LID (43.99)</option>
				<option value="TURBO CHARGER@54.99">TURBO CHARGER (54.99)</option>
				<option value="TURBO INTERCOOLER@37.99">TURBO INTERCOOLER (37.99)</option>
				</select>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn_submit" onclick="addCost()">Submit</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			</div>
			</div>
		</div>
	</div>

	<!-- Loading Scripts -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/fileinput.js"></script>

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


	<script src="js/BsMultiSelect.js"></script>
	<script src="js/main.js"></script>
	
	<script>
		

		function assignMechanic(BID) {
			$('#assignMechanic').modal({
				backdrop: 'static',
				keyboard: false
			});

			$('#BID').val(BID);
		}

		function addMechanic() {

			var BID = $('#BID').val();
			var mechanic = $('#select-mechanic').val();

			if (mechanic != '-1') {
				window.open('bookings.php?m='+mechanic+'&BID='+BID,'_self');
			} else {
				alert('Please select Mechanic')
			}
		}

		function assignCost(BID,type) {
			$('#assignCost').modal({
				backdrop: 'static',
				keyboard: false
			});

			$('#CBID').val(BID);
			$('#type').val(type);
			$('#parts').bsMultiSelect({cssPatch : {
				choices: {columnCount:'1' },
			}});
		}

		function addCost() {

			var BID = $('#CBID').val();
			var type = $('#type').val();
			var arr = $('#parts').val();
			var cost = 0;
			
			if (type == '1') {
				cost = 120;
			} else if (type == '2') {
				cost = 460;
			} else if (type == '3') {
				cost = 340;
			} else {
				cost = 240;
			}
			
			//add cost for each part
			for (let i = 0; i < arr.length; i++) {
				cost = cost + parseInt(arr[i].split('@')[1]);
			}
			
			window.open('bookings.php?cost='+cost+'&parts='+arr+'&BID='+BID,'_self');
		}

		
		function Print(BID) {
			window.open('invoice.php?BID='+BID,'_self');
		}

		
		function fetchData() {
			//fetch date
			var start_date = $('#start_date').val();
			var end_date = $('#end_date').val();
		
			window.open('bookings.php?start='+start_date+'&end='+end_date,'_self');
		
		}
	
	</script>
	
</body>
</html>
<?php } ?>