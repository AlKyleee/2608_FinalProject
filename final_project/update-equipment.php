<?php
include ("session-checker.php");
require_once "config.php";
//update
if((isset($_SESSION['usertype']) && $_SESSION['usertype'] != "USER")){
	if(isset($_POST['btnsubmit'])){
		$sql = "UPDATE equipmenttbl SET model = ?, description = ?, department = ?, status = ? WHERE serial_number = ?";
	    if($stmt = mysqli_prepare($link, $sql)){
	        mysqli_stmt_bind_param($stmt, "sssss", $_POST['txtmodel'],
	        $_POST['txtdescription'], $_POST['txtdepartment'], $_POST['txtstatus'], $_GET['serial_number']);
	        if(mysqli_stmt_execute($stmt)){
	 			header("location: equipments.php");
	            exit();
	        }
	        else{
	                echo "Error on update statement";
	        } 
	    }
	}
//displaying value
	else{
		if(isset($_GET['serial_number']) && !empty(trim($_GET['serial_number']))){
			$sql = "SELECT * FROM equipmenttbl WHERE serial_number = ?";
			if($stmt = mysqli_prepare($link, $sql)){
				mysqli_stmt_bind_param($stmt, "s", $_GET['serial_number']);
				if(mysqli_stmt_execute($stmt)){
					$result = mysqli_stmt_get_result($stmt);
					if(mysqli_num_rows($result) == 1){
						$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
					}
					else{
						header("location: error.php");
						exit();
					}
				}
				else{
					echo "Error on select statement";
				}
			}
		}
	}
}
else{
	header("location: index.php");
}
?>
<html>
<head>
	<title>Update account</title>
	<style>
body
{
	background-image: url(bg.jpg);
    height: 100%;
    background-repeat: no-repeat;
    background-size: cover;
}

p{
	font-size: 20px;
	color: black;
}

h1
{
	color: black;
}


input[type="text"]
{
	height: 40px;
	width: 250px;
	font-size: 18px;
	margin-bottom: 20px;
	background-color: #fff;
	padding-left: 10px;
}

.btnsubmit
{
	padding: 15px 25px;
	border: none;
	background-color: #27ae60;
	color: #fff;
}

a
{
	font-size: 20px;
	color: white;
}
	</style>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script type="text/javascript">
    $(window).on('load',function(){
        $('#myModal').modal('show');
    });
</script>
</head>
<body>
	<center>
	  <div class="modal fade" id="myModal" role="dialog">
	    <div class="modal-dialog">
	      <div class="modal-content">
	        <div class="modal-header">
	        <h4 class="modal-title">Update Equipment</h4>
	        </div>
	        <div class="modal-body">
		<p>Edit the values and submit to update the equipment.</p><br>
		<form action = "<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method = "POST">
			<p>Serial Number: <?php echo $row['serial_number']; ?></p>
			<div class="form-input">
				<p>Current Model: <?php echo $row['model']; ?> <br>
				<p>New Model: <select name = "txtmodel" id = "model" required></p>
				<option value = "">--Select Model--</option>
				<option value = "AVR">AVR</option>
				<option value = "CPU">CPU</option>
				<option value = "Keyboard">Keyboard</option>
				<option value = "MAC">MAC</option>
				<option value = "Monitor">Monitor</option>
				<option value = "Mouse">Mouse</option>
				<option value = "Printer">Printer</option>
				<option value = "Projector">Projector</option>
				<option value = "Speaker">Speaker</option>
			</select>
			</div>
			<div class="form-input">
				<p>New Description: <input type = "text" name = "txtdescription" value = "<?php echo $row['description']; ?>" required></p>
			</div>	
		<p>Current Department: <?php echo $row['department']; ?> <br>
		<p>Select new Department: <select name = "txtdepartment" id = "txtdepartment" required>
			<option value = "">--Select Department--</option>
				<option value = "Faculty of Sacred Theology">Faculty of Sacred Theology</option>
				<option value = "Faculty of Philosophy">Faculty of Philosophy</option>
				<option value = "Faculty of Canon Law">Faculty of Canon Law</option>
				<option value = "Faculty of Civil Law">Faculty of Civil Law</option>
				<option value = "Faculty of Medicine & Surgery">Faculty of Medicine & Surgery</option>
				<option value = "Faculty of Pharmacy">Faculty of Pharmacy</option>
				<option value = "Faculty of Arts and Letters">Faculty of Arts and Letters</option>
				<option value = "Faculty of Engineering">Faculty of Engineering</option>
				<option value = "College of Education">College of Education</option>
				<option value = "College of Science">College of Science</option>
				<option value = "College of Architecture">College of Architecture</option>
				<option value = "College of Commerce and Business Administration">College of Commerce and Business Administration</option>
				<option value = "Graduate School">Graduate School</option>
				<option value = "Conservatory of Music">Conservatory of Music</option>
				<option value = "College of Nursing">College of Nursing</option>
				<option value = "College of Rehabilitation Sciences">College of Rehabilitation Sciences</option>
				<option value = "College of Fine Arts and Design">College of Fine Arts and Design</option>
				<option value = "Institute of Physical Education & Athletics">Institute of Physical Education & Athletics</option>
				<option value = "College of Accountancy">College of Accountancy</option>
				<option value = "College of Tourism & Hospitality Management">College of Tourism & Hospitality Management</option>
				<option value = "Institute of Information and Computing Sciences">Institute of Information and Computing Sciences</option>
				<option value = "Graduate School of Law">Graduate School of Law</option>
		</select>
		<p>Current Status: <?php echo $row['status']; ?> <br>
		<p>Select new Status: <select name = "txtstatus" id = "txtstatus" required>
			<option value = "">--Select Status--</option>
				<option value = "WORKING">Working</option>
				<option value = "ON REPAIR">On Repair</option>
				<option value = "RETIRED">Retired</option>
		</select><br><br>
		<input type = "submit" name = "btnsubmit" value = "SUBMIT" class="btnsubmit"><br><br>
		<a href = "equipments.php">Cancel</a>
			
				</form>
	        </div>
	      </div>
	    </div>
	  </div>	
	  </center>
	</body>
</html>