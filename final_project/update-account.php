<?php
include ("session-checker.php");
require_once "config.php";
//update
if((isset($_SESSION['usertype']) && $_SESSION['usertype'] == "ADMINISTRATOR" )){
	if(isset($_POST['btnsubmit'])){
		$sql = "UPDATE tblaccounts SET password = ?, usertype = ? WHERE username = ?";
	    if($stmt = mysqli_prepare($link, $sql)){
	        mysqli_stmt_bind_param($stmt, "sss", $_POST['txtpassword'],
	        $_POST['cmbusertype'],  $_GET['username']);
	        if(mysqli_stmt_execute($stmt)){
	            header("location: accounts.php");
	            exit();
	        }
	        else{
	                echo "Error on update statement";
	        } 
	    }
	}
	//displaying value
	else{
		if(isset($_GET['username']) && !empty(trim($_GET['username']))){
			$sql = "SELECT * FROM tblaccounts WHERE username = ?";
			if($stmt = mysqli_prepare($link, $sql)){
				mysqli_stmt_bind_param($stmt, "s", $_GET['username']);
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
	<style>
body
{
	background-image: url(background.jpg);
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


input[type="text"],input[type="password"]
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
	color: black;
}
	</style>
	<link rel="stylesheet" a href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<center>
		<div class="modal fade" id="myModal" role="dialog">
	    <div class="modal-dialog">
	      <div class="modal-content">
	        <div class="modal-header">
	        <h4 class="modal-title">Update Account</h4>
	        </div>
	        <div class="modal-body">
		<p>Edit the values and submit to update the account.</p><br>
		<form action = "<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method = "POST">
			<p>Username: <?php echo $row['username']; ?></p>
			<div class="form-input">
				<p>New Password: <input type = "password" name = "txtpassword" value = "<?php echo $row['password']; ?>" required></p>
			</div>	
		<p>Current Usertype: <?php echo $row['usertype']; ?> <br>
		<p>Select new Usertype: <select name = "cmbusertype" id = "cmbusertype" required>
			<option value = "">--Select Usertype--</option>
			<option value = "ADMINISTRATOR">Administrator</option>
			<option value = "TECHNICAL">Technical</option>
			<option value = "USER">User</option>
		</select><br><br>
		<input type = "submit" name = "btnsubmit" value = "SUBMIT" class="btnsubmit"><br><br>
		<a href = "accounts.php">Cancel</a>
				</form>
	        </div>
	      </div>
	    </div>
	  </div>	
	  </center>
</form>
</body>
</html>