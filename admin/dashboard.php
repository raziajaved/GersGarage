<?php
session_start();
error_reporting(0);
include('includes/config.php');

//check if admin is logged in 
if(strlen($_SESSION['admintoken'])==0)
{	
	header('location:index.php');
}else{

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
		button,input[type=submit] {
			padding: 10px;
			background-color: green;
			border: 0px;
			border-radius: 4px;
			color: #fff;
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

						<h2 class="page-title">Dashboard</h2>
						<h3 class="page-title">Users</h3>
						 <?php

								// query to select users.
								$sql = 'SELECT * FROM user';
									
								// running queries
								$query = mysqli_query($dbh, $sql);
								
								//echo mysql_num_rows($query);
								if (mysqli_num_rows($query)==0) {
									echo '<h2>No Data Available</h2>';
								}else {
									
								echo '<table class="data-table">';
								echo '<caption class="title"></caption>';
								echo '<thead>';
								//table header
									echo '<tr>';
										echo '<th>User ID</th>';
										echo '<th>Name</th>';
										echo '<th>Email</th>';
										echo '<th>Mobile</th>';
										echo '<th>Password</th>';
										echo '<th>Address</th>';
										echo '<th>View Detail</th>';
									echo '</tr>';
									
								echo '</thead>';
								echo '<tbody>';
								
								// fetch rows
								while ($row = mysqli_fetch_array($query))
								{
									/// get data
									echo "<tr>";
									$UID= $row['UID'];
									$name= $row['fname'].' '.$row['lname'];
									$email= $row['email'];
									$mobile= $row['mobile'];
									$address= $row['address'];
									
											echo "<td>".$row['UID']."</td>";
											echo "<td>".$name."</td>";
											echo "<td>".$row['email']."</td>";
											echo "<td>".$row['mobile'] . "</td>";
											echo "<td>".$row['password']."</td>";
											echo "<td>".$row['address']."</td>";
											
											
											echo "<td><form method=\"post\" action=\"user-details.php\">
													<input name=\"UID\" type=\"hidden\" value=\"$UID\">
													<input name=\"name\" type=\"hidden\" value=\"$name\">
													<input name=\"email\" type=\"hidden\" value=\"$email\">
													<input name=\"mobile\" type=\"hidden\" value=\"$mobile\">
													<input name=\"address\" type=\"hidden\" value=\"$address\">
													<input name=\"submit\" type=\"submit\" value=\"details\">
													</form></td>";
											
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