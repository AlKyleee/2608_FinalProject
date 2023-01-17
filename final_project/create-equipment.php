<?php
include("session-checker.php");
require_once "config.php";
$validate = " ";
if((isset($_SESSION['usertype']) && $_SESSION['usertype'] != "USER")){
	if(isset($_POST['btnsubmit'])){
		//check if the serial_number is existing
		$sql = "SELECT * FROM equipmenttbl WHERE serial_number = ?";
		if($stmt = mysqli_prepare($link, $sql)){
			mysqli_stmt_bind_param($stmt, "s", $_POST['txtserial_number']);
			if(mysqli_stmt_execute($stmt)){
				$result = mysqli_stmt_get_result($stmt);
				if(mysqli_num_rows($result) != 1){
					//insert new serial_number to the equipment table
					$sql = "INSERT INTO equipmenttbl VALUES (?, ?, ?, ?, ?, ?)";
					if($stmt = mysqli_prepare($link, $sql)){
						$status = "WORKING";
						mysqli_stmt_bind_param($stmt, "ssssss", $_POST['txtserialnumber'], $_POST['txtmodel'], $_POST['txtdescription'], $_POST['txtdepartment'], $status, $_SESSION['username']);
						if(mysqli_stmt_execute($stmt)){
							echo("<script>alert('Equipment successfully created!')</script>");
	 						echo("<script>window.location = 'equipments.php';</script>");
							exit();
						}
						else{
							$validate = "Serial number already exists";
						}
					}
				}
				else{
					;		
				}
			}
			else{
				echo "Error on select statement";
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
<title>Add new account</title>
		<style>
body
{
	background-image: url(bg.jpg);
    height: 100%;
    background-repeat: no-repeat;
    background-size: cover;
}

.container
{
	width: 500px;
	height: 600px;
	text-align: center;
	margin: 0 auto;
	background-color: rgba(44, 62, 80,0.7);
	margin-top: 160px;
}	

.container img
{
	height: 150px;
	margin-top: -60px;
}

p{
	font-size: 20px;
	color: white;
}

h1
{
	color: white;
}


input[type="text"]
{
	margin-top: 30px;
	height: 45px;
	width: 300px;
	font-size: 18px;
	margin-bottom: 20px;
	background-color: #fff;
	padding-left: 40px;
}

#validate
{
	color: red;
}

.btncreate
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
	<link rel="stylesheet" a href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<div class="container">
		<br><br><br>
		<p>Fill up this form and submit to add a new equipment</p>
		<p id = "validate"><?php echo $validate; ?></p>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		<form>
			<div class="form-input">
				<i class="fa fa-cog icon" style="padding-left: 07px; padding-top: 36px; position: absolute; font-size: 35px; color: #2980b9;"></i>
				<input type="text" name="txtserialnumber" placeholder="Serial Number" required>	
			</div>
			<p>Model: <select name = "txtmodel" id = "model" required></p>
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
			<div class="form-input">
				<i class="fa fa-file-word-o icon" style="padding-left: 07px; padding-top: 36px; position: absolute; font-size: 30px; color: #2980b9;"></i>
				<input type="text" name="txtdescription" placeholder="Description" required>
			</div>
			<p>User type: <select name = "txtdepartment" id = "department" required></p>
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
			</select><br><br>
			<input type = "submit" name = "btnsubmit" value = "CREATE" class="btncreate"><br><br>
			<a href = "equipments.php">Cancel</a>
		</form>
	</div>
</form>
</body>
</html>
