<?php
//session start
session_start();
error_reporting(0);
include('includes/config.php');

//check if user is logged in
if(strlen($_SESSION['admintoken'])==0)
{	
	header('location:index.php');
}
//check if bid exists
else if(!isset($_GET['BID'])){
	header('location:bookings.php');
}
else{							

	$BID = $_GET['BID'];

	//query to get booking details
	$sql = "select user.fname,user.lname,user.mobile,
	vehicle.type,vehicle.make,vehicle.licence_details,
	bookings.booking_type,bookings.cost,bookings.status    
	from bookings 
	inner join user on user.UID = bookings.UID 
	inner join vehicle on vehicle.VID = bookings.VID 
	where bookings.BID = '$BID' limit 1";
									
	// execute query
	$query = mysqli_query($dbh, $sql);
	
	//check if rows>0
	if (mysqli_num_rows($query)==0) {
		header('location:bookings.php');
	}
	
	//fetch data
	$row = mysqli_fetch_array($query);

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
	<!-- Admin Stye -->
	<link rel="stylesheet" href="css/style.css">
	
	
<style>
.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}

  #parent_div_1, #parent_div_2, #parent_div_3{
	position: relative;
    width:350px;
    height:100px;
    margin-right:10px;
    float:left;
	}
	#parent_div_2{
	position: relative;
    width:400px;
    height:100px;
   
    margin-right:10px;
    float:left;
	}
		.dropbtn {
    background-color: #464d4f;
    color: white;
    padding: 16px;
	 padding-top: 30px;
    font-size: 14px;
    border: none;
}

.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #464d4f;
      min-width: 300px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {background-color: #ddd;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: #3e8e4;}
 
</style>

</head>

<body>
	<?php include('includes/header.php');?>
	<div class="ts-main-content">
	<?php include('includes/leftbar.php');?>
		<div class="content-wrapper" style="margin-left:200px">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">
					
						<h2 class="page-title">Invoice</h2>

						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default" style="border: 0px;">
									      <div   style = "height:800px;" id="text">
												  <?php 

												  	echo '<div style = "text-align :center; height: auto; width:1000px;">';

														echo '<div id="parent_div_2">';
														
														echo '<table style="width: 500px; text-align:left;">';
														
														echo '<tr style="height:30px"><td style="width:100px">CUSTOMER: </td><td>'.$row['fname'].' '.$row['lname'].'</td></tr>';
														echo '<tr><td>Mob No: </td><td>'.$row['mobile'].'</td></tr>';														
														echo '<tr><td>&nbsp;</td><td></td></tr>';

														echo '<tr style="height:30px"><td>Vehicle: </td><td>'.$row['type'].' '.$row['make'].'</td></tr>';
														echo '<tr><td>Licence: </td><td>'.$row['licence_details'].'</td></tr>';														
														echo '<tr><td>&nbsp;</td><td></td></tr>';


														$total_cost = $row['cost'];

														$booking_type = "";
														$booking_cost = 0;

														//set booking type and cost for each booking type
														if ($row['booking_type'] == '1') {
															$booking_type = 'Annual Service';
															$booking_cost = 120;
														}else if ($row['booking_type'] == '2') {
															$booking_type = 'Major Service';
															$booking_cost = 460;
														}else if ($row['booking_type'] == '3') {
															$booking_type = 'Repair / Fault';
															$booking_cost = 340;
														}else {
															$booking_type = 'Major Repair';
															$booking_cost = 240;
														}

														echo '</table><table style="width: 500px; text-align:left;">';

														echo '<tr style="height:25px"><td style="width:150px">'.$booking_type.' </td><td>€'.$booking_cost.'</td></tr>';
														
														
														//fetch parts used in booking
														$sql = "select name,cost from parts where BID = '$BID'";
																						
														// execute query
														$query = mysqli_query($dbh, $sql);
														
														//check if rows>0
														if (mysqli_num_rows($query)==0) {
															header('location:bookings.php');
														}
														
														while($row = mysqli_fetch_array($query)) {
															echo '<tr style="height:25px"><td>'.$row['name'].' </td><td>€'.$row['cost'].'</td></tr>';
														}
														
														echo '<tr><td><b>TOTAL DUE </b></td><td><b style="border-top: 2px solid #000;padding-top: 2px;">€'.$total_cost.'</b></td></tr>';

														echo '</table>';
													echo '</div>';
													echo '</div>';
													?>
								<br />
								
						</div>
					</div>
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
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>
</body>
</html>
<?php } ?>