<?php
$page = "past-bookings.php";
session_start();
error_reporting(0);
include('include/config.php');

if (!strlen(isset($_SESSION['authtoken']))) {
    header("location: login.php");
}						

$id = $_SESSION['ID'];

//query to get user details
$sql = "select bookings.BID,bookings.booking_type,
bookings.description,bookings.booking_date,
vehicle.VID,
vehicle.type,
vehicle.make,
vehicle.licence_details,
vehicle.engine_type 
from bookings 
inner join vehicle on bookings.VID = vehicle.VID   
where bookings.UID='$id' order by bookings.timestamp desc";

// execute query
$query = mysqli_query($con, $sql);

$rows = mysqli_num_rows($query);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
  	    <?php include('head.php');?>
    </head>
<body>

    <?php include('header.php');?>
  
    <section id="contact" style="min-height:550px">
        
        <div class="container">
            <div class="container contact-info">
                <div class="section-header" style="text-align:center;margin-bottom:0px">
                    <h2 class="section-title wow fadeInDown" style="border:0px">Past Bookings</h2>
                </div>
                <div class="row">
                    <div class="col-sm-12 contact clearfix">
                        <table class="table table-sm">
                            <thead class="thead-dark">
                                <tr>
                                    <th>BID</th>
                                    <th>Booking Type</th>
                                    <th>Vehicle Type</th>
                                    <th>Vehicle Make</th>
                                    <th>Licence Details</th>
                                    <th>Engine Type</th>
                                    <th>Booking Date</th>
                                    <th>Customer Note</th>
                                </tr>
                                
                            </thead>
                            <tbody>
                            <?php
                                while ($row = mysqli_fetch_array($query))
                                {
                                    echo "<tr>";

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
                                    echo "<td>".$booking_type."</td>";
                                    echo "<td>".$row['type']."</td>";
                                    echo "<td>".$row['make']."</td>";
                                    echo "<td>".$row['licence_details']."</td>";
                                    echo "<td>".$row['engine_type']."</td>";
                                    echo "<td>".date('d-m-Y',strtotime($row['booking_date']))."</td>";
                                    echo "<td>".$row['description']."</td>";

                                    echo "</tr>";
                                }

                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>   
   </section><!--/#bottom-->

    <?php include('footer.php');?> 
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</body>
</html>