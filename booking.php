<?php
$page = "booking.php";
session_start();
error_reporting(0);
include('include/config.php');
$error = Null;
$msg = Null;

if (!strlen(isset($_SESSION['authtoken']))) {
    header("location: login.php");
}

if(isset($_GET['s']))
{

	$valid = true;
	 
	$booking_type= mysqli_real_escape_string($con,$_POST['booking_type']);
	$vehicle_type= mysqli_real_escape_string($con,$_POST['vehicle_type']);
	$vehicle_make= mysqli_real_escape_string($con,$_POST['vehicle_make']);
	$vehicle_other= mysqli_real_escape_string($con,$_POST['vehicle_other']);
	$licence_detail= mysqli_real_escape_string($con,$_POST['licence_detail']);
	$engine_type= mysqli_real_escape_string($con,$_POST['engine_type']);
	$date= mysqli_real_escape_string($con,$_POST['date']);
	$description= mysqli_real_escape_string($con,$_POST['description']);

	if ($booking_type == '-1') {
		echo "<script>
		alert('Please select booking type');
		window.location.href='booking.php';
		</script>";
		$valid = false;
	}
	if ($vehicle_type == '-1') {
		echo "<script>
		alert('Please select vehicle type');
		window.location.href='booking.php';
		</script>";
		$valid = false;
	}
	if ($vehicle_make == '-1') {
		echo "<script>
		alert('please select vehicle make');
		window.location.href='booking.php';
		</script>";
		$valid = false;
	}
	if ($vehicle_make == '0' && $vehicle_other == "") {
		echo "<script>
		alert('please enter vehicle details');
		window.location.href='booking.php';
		</script>";
		$valid = false;
	}
	if ($licence_detail == "") {
		echo "<script>
		alert('please enter licence details');
		window.location.href='booking.php';
		</script>";
		$valid = false;
	}
	if ($engine_type == '-1') {
		echo "<script>
		alert('please select engine_type type');
		window.location.href='booking.php';
		</script>";
		$valid = false;
	}
	if ($date == '') {
		echo "<script>
		alert('please select booking date');
		window.location.href='booking.php';
		</script>";
		$valid = false;
	}

    $sql = "SELECT * FROM bookings WHERE booking_date = '$date'";
    $result = $con->query($sql);
    if ($result->num_rows > 15) {
        echo "<script>
            alert('Sorry No more Booking is accepted on this day!');
            </script>";
        $valid = false;
    }

	if ($valid) {
		$UID = $_SESSION['ID'];

        if ($vehicle_make == '0') {
            $vehicle_make = $vehicle_other;
        }

		$sql="INSERT INTO vehicle(UID, type, make, licence_details ,engine_type) VALUES('$UID','$vehicle_type','$vehicle_make','$licence_detail','$engine_type')";

		if($con->query($sql) === TRUE)
		{
			$VID = $con->insert_id;
			
			$sql="INSERT INTO bookings(BID, UID, VID, description , booking_date) VALUES('$BID','$UID','$VID','$description','$date')";

			if($con->query($sql) === TRUE)
			{
				echo "<script>
				alert('You have successfully Booked your vehicle service');
				window.location.href='index.php';
				</script>";
				
			}
			else 
			{
				echo "<script>
				alert('Something went wrong. Please try again!');
				window.location.href='booking.php';
				</script>";
			}
		}
		else 
		{
		
			echo "<script>
				alert('Something went wrong. Please try again!');
				window.location.href='booking.php';
				</script>";
		}	
	}

}
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
                    <h2 class="section-title wow fadeInDown" style="border:0px">Booking</h2>
                </div>
                <div class="row">
				  <div class="col-sm-4 col-md-4"></div>
                    <div class="col-sm-4 col-md-4">
                        <div class="contact-form">

                            Name : <?php echo $_SESSION['name'];?><br>
                            Email : <?php echo $_SESSION['email'];?><br>
                            Mob. No. : <?php echo $_SESSION['phone'];?><br>
                            <br>
                            <form action="booking.php?s" id="form1" style="text-align:right" name="booking" method="post">
                                <div class="form-group">
                                    <select id="booking_type" class="form-control" name="booking_type">
                                        <option value="-1" selected>Select Booking Type</option>
                                        <option value="1" >Annual Service</option>
                                        <option value="2" >Major Service</option>	
                                        <option value="3" >Repair / Fault</option>
                                        <option value="4" >Major Repair</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select id="vehicle_type" class="form-control" name="vehicle_type">
                                        <option value="-1" selected>Select Vehicle Type</option>
                                        <option value="MotorBike" >MotorBike</option>
                                        <option value="Car" >Car</option>	
                                        <option value="Small Van" >Small Van</option>
                                        <option value="Small Bus" >Small Bus</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select id="vehicle_make" class="form-control" onchange="checkMake()" name="vehicle_make">
                                        <option value="-1" selected>Select Vehicle Make</option>
                                        <option value="Acura">Acura</option> 
                                        <option value="Alfa Romeo">Alfa Romeo</option> 
                                        <option value="Allard">Allard</option> 
                                        <option value="Cadillac">Cadillac</option> 
                                        <option value="Chevrolet">Chevrolet</option> 
                                        <option value="Chrysler">Chrysler</option> 
                                        <option value="Citroen">Citroen</option> 
                                        <option value="Daewoo">Daewoo</option> 
                                        <option value="Duesenberg">Duesenberg</option> 
                                        <option value="Eagle">Eagle</option> 
                                        <option value="Edsel">Edsel</option> 
                                        <option value="Ferrari">Ferrari</option> 
                                        <option value="FIAT">FIAT</option> 
                                        <option value="Fisker">Fisker</option> 
                                        <option value="Ford">Ford</option> 
                                        <option value="Franklin">Franklin</option> 
                                        <option value="Graham">Graham</option> 
                                        <option value="Hillman">Hillman</option> 
                                        <option value="Honda">Honda</option> 
                                        <option value="Intermeccanica">Intermeccanica</option> 
                                        <option value="International Harvester">International Harvester</option> 
                                        <option value="Iso">Iso</option> 
                                        <option value="Isuzu">Isuzu</option> 
                                        <option value="Jaguar">Jaguar</option> 
                                        <option value="Mobility Ventures">Mobility Ventures</option> 
                                        <option value="Morris">Morris</option> 
                                        <option value="Moskvitch">Moskvitch</option> 
                                        <option value="Muntz">Muntz</option> 
                                        <option value="Nash">Nash</option> 
                                        <option value="Nissan">Nissan</option> 
                                        <option value="Oldsmobile">Oldsmobile</option> 
                                        <option value="Pininfarina">Pininfarina</option> 
                                        <option value="Plymouth">Plymouth</option> 
                                        <option value="Reliant">Reliant</option> 
                                        <option value="Riley">Riley</option> 
                                        <option value="Rolls-Royce">Rolls-Royce</option> 
                                        <option value="Shelby">Shelby</option> 
                                        <option value="smart">smart</option> 
                                        <option value="Tesla">Tesla</option> 
                                        <option value="Toyota">Toyota</option> 
                                        <option value="0" >Other</option>
                                    </select>
                                </div>
                                <div class="form-group" id="make_other" style="display:none">
                                    <input type="text" id="vehicle_other" class="form-control" name="vehicle_other" placeholder="Enter Vehicle Type and Make">
                                </div>
                                <div class="form-group">
                                    <input type="text" id="licence_detail" class="form-control" name="licence_detail" placeholder="Enter Vehicle Licence details" required>
                                </div>
                                <div class="form-group">
                                    <select id="engine_type" class="form-control" name="engine_type">
                                        <option value="-1" selected>Select Engine Type</option>
                                        <option value="Diesel" >Diesel</option>
                                        <option value="Petrol" >Petrol</option>
                                        <option value="Hybrid" >Hybrid</option>
                                        <option value="Electric" >Electric</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="date" id="date" class="form-control" min="<?php echo date("Y-m-d"); ?>" name="date" required>
                                </div>
                                <div class="form-group">
                                    <textarea id="description" class="form-control" placeholder="Note" name="description" rows="4"></textarea>
                                </div>
                                <br>
                                <div>
                                    <button class="btn btn-primary" name="booking" type="submit">Submit</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>   
   </section><!--/#bottom-->

    <?php include('footer.php');?> 
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>

        function checkMake() {
            if($('#vehicle_make').val() == '0') {
                $('#make_other').show();
            }else {
                $('#make_other').hide();
            }
        }

        const picker = document.getElementById('date');
        picker.addEventListener('input', function(e){
        var day = new Date(this.value).getUTCDay();
        if([0].includes(day)){
            e.preventDefault();
            this.value = '';
            alert('Garage is closed on Sunday!!');
        }
        });

    </script>

</body>
</html>