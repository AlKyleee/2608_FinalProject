<?php
	$error = " ";
  	if(isset($_POST['btnsubmit'])){
	    require_once "config.php";
	    $sql = "SELECT * FROM tblaccounts WHERE username = ? and password = ? and status = 'ACTIVE'";
	    if($stmt = mysqli_prepare($link, $sql)){
		    mysqli_stmt_bind_param($stmt, "ss", $_POST['txtusername'], $_POST['txtpassword']);
	    	if(mysqli_stmt_execute($stmt)){
	    		$result = mysqli_stmt_get_result($stmt);
	        	if(mysqli_num_rows($result) == 1){
	        		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	        		session_start();
	        		$_SESSION['username'] = $_POST['txtusername'];
	        		$_SESSION['usertype'] = $row['usertype'];
	            	header("location: index.php");
	    		}
	    		else{
	            	$error = "Incorrect username or Password or Account is Inactive";
	    		}
	    	}
	    }
	    else{
	    		echo "Error on select statement";
	    }
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>MySQL Login</title>
	<link rel="stylesheet" a href="style.css">
	<link rel="stylesheet" a href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	<div class="container">
		<img src="login.png">
		<p><?php echo $error; ?></p>
		<form>
			<div class="form-input">
				<i class="fa fa-user icon" style="padding-left: 07px; padding-top: 40px; position: absolute; font-size: 35px; color: #2980b9;"></i>
				<input type="text" name="txtusername" placeholder="Username" required>	
			</div>
			<div class="form-input">
				<i class="fa fa-lock icon" style="padding-left: 07px; padding-top: 40px; position: absolute; font-size: 35px; color: #2980b9;"></i>
				<input type="password" name="txtpassword" placeholder="Password" required>
			</div>
			<br>
			<input type="submit" name="btnsubmit" value="LOGIN" class="btn-login">
		</form>
	</div>
</body>
</html>