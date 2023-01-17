<?php
require_once "config.php";
include("session-checker.php");
if((isset($_SESSION['usertype']) && $_SESSION['usertype'] == "ADMINISTRATOR" )){
	if(isset($_POST['btnsubmit'])){
		$sql = "UPDATE tblaccounts SET status = 'INACTIVE' WHERE username = ?";
		if($stmt = mysqli_prepare($link, $sql)){
			mysqli_stmt_bind_param($stmt, "s", trim($_POST["username"]));
			if(mysqli_stmt_execute($stmt)){
				header("location: accounts.php");
				exit();
			}
			else{
				echo "Error on update statement";
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
<style>
body
{
	background-image: url(background.jpg);
    height: 100%;
    background-repeat: no-repeat;
    background-size: cover;
}
</style>
<title>Deactivate Account</title>
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
	  <div class="modal fade" id="myModal" role="dialog">
	    <div class="modal-dialog">
	      <div class="modal-content">
	        <div class="modal-header">
	        <h4 class="modal-title">Deactivate Account</h4>
	        </div>
	        <div class="modal-body">
	       		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "post">
				<input type = "hidden" name = "username" value = "<?php echo trim($_GET["username"]); ?>" />
				<p>Are you sure you want to deactivate this account?</p><br>
	        	<input type = "submit" name = "btnsubmit" value = "Yes">
				<a href = "accounts.php">No</a>
				</form>
	        </div>
	      </div>
	    </div>
	  </div>	
	</body>
</html>