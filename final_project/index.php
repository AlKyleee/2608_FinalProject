<html>
<head>
	<title>Homepage</title>
	<style>
		body
		{
			background-image: url(loginbg.jpg);
		    height: 100%;
		    background-repeat: no-repeat;
		    background-size: cover;
		}
		.container {
			margin-top: 160px;
	    	display: flex;
		    justify-content: center;
		    height: 700px;
		    margin: 0 auto;
		    text-align:center;
		}
		.block {
			margin-top: 150px;
		    height: 400px;
		    width: 400px;
		    margin-right: 50px;
		}
		#logout{
			padding: 15px 25px;
			border: none;
			background-color: #27ae60;
			color: #fff;
			margin-left: 46%;
		}
		p{
			font-size: 20px;
		}

	</style>
</head>
<body>
	<?php
	include 'session-checker.php';
	if((isset($_SESSION['usertype']) && $_SESSION['usertype'] == "ADMINISTRATOR")){?>
		<div class="container">
		    <div class="block">
		    	<p>EQUIPMENTS</p>
		    	<br>
		    	<a href="equipments.php"><img src='equipments.jpg'></a>
		    </div>
		    <div class="block">
		    	<p>ACCOUNTS</p>
		    	<br>
		    	<a href="accounts.php"><img src='accounts.jpg'></a>
		    </div>
		</div>
		<a href="logout.php" id = logout>LOGOUT</a><?php
	}

	else{?>
        <div class="container">
		    <div class="block">
		    	<p>EQUIPMENTS</p>
		    	<br>
		    	<a href="equipments.php"><img src='equipments.jpg'></a>
		    </div>
		</div>
		<a href="logout.php" id = logout>LOGOUT</a><?php
	}
	?>

</body>
</html>