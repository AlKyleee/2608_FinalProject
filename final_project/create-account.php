<?php
include("session-checker.php");
require_once "config.php";
$validate = " ";
if((isset($_SESSION['usertype']) && $_SESSION['usertype'] == "ADMINISTRATOR" )){
	if(isset($_POST['btnsubmit'])){
		//check if the username is existing
		$sql = "SELECT * FROM tblaccounts WHERE username = ?";
		if($stmt = mysqli_prepare($link, $sql)){
			mysqli_stmt_bind_param($stmt, "s", $_POST['txtusername']);
			if(mysqli_stmt_execute($stmt)){
				$result = mysqli_stmt_get_result($stmt);
				if(mysqli_num_rows($result) != 1){
					//insert new user to the accounts table
					$sql = "INSERT INTO tblaccounts VALUES (?, ?, ?, ?, ?)";
					if($stmt = mysqli_prepare($link, $sql)){
						$status = "ACTIVE";
						mysqli_stmt_bind_param($stmt, "sssss", $_POST['txtusername'], $_POST['txtpassword'], $_POST['cmbusertype'], $status, $_SESSION['username']);
						if(mysqli_stmt_execute($stmt)){
							echo("<script>alert('Account successfully created!')</script>");
	 						echo("<script>window.location = 'accounts.php';</script>");
							exit();
						}
						else{
							echo "Error in insert statement";
						}
					}
				}
				else{
					$validate = "Serial number already exists";
				
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
	background-image: url(background.jpg);
    height: 100%;
    background-repeat: no-repeat;
    background-size: cover;
}

.container
{
	width: 500px;
	height: 550px;
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


input[type="text"],input[type="password"]
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
		<img src="login.png">
		<p>Fill up this form and submit to add a new user</p>
		<p id = "validate"><?php echo $validate; ?></p>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		<form>
			<div class="form-input">
				<i class="fa fa-user icon" style="padding-left: 07px; padding-top: 36px; position: absolute; font-size: 35px; color: #2980b9;"></i>
				<input type="text" name="txtusername" placeholder="Username" required>	
			</div>
			<div class="form-input">
				<i class="fa fa-lock icon" style="padding-left: 07px; padding-top: 36px; position: absolute; font-size: 35px; color: #2980b9;"></i>
				<input type="password" name="txtpassword" placeholder="Password" required>
			</div>
			<p>User type: <select name = "cmbusertype" id = "cmbusertype" required></p>
				<option value = "">--Select Usertype--</option>
				<option value = "ADMINISTRATOR">Administrator</option>
				<option value = "TECHNICAL">Technical</option>
				<option value = "USER">User</option>
			</select><br><br>
			<input type = "submit" name = "btnsubmit" value = "CREATE" class="btncreate"><br><br>
			<a href = "accounts.php">Cancel</a>
		</form>
	</div>
</form>
</body>
</html>
