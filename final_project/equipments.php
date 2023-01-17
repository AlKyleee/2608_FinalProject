<html>
<head>
	<title>Equipment Management</title>
	<style>
		body
		{
			background-image: url(bg.jpg);
		    height: 100%;
		    background-repeat: no-repeat;
		    background-size: cover;
		}
		table
		{
  			font-family: arial, sans-serif;
			border-collapse: collapse;
			width: 100%;
		}

		td, th 
		{
			border: 1px solid #dddddd;
			text-align: left;
			padding: 8px;
		}

		.container
		{
			width: 1000px;
			height: 800px;
			text-align: center;
			margin: 15px;
			background-color: rgba(44, 62, 80,0.7);
			margin-top: 160px;
		}	

		.container img
		{
			height: 150px;
			margin-top: -60px;
		}

		.container .top .header h1
		{
			color: white;
		}

		.container .top .header h3
		{
			color: white;
		}

		.container table
		{
			font-size: 15px;
			color: white;
		}

		.container td
		{	
			font-size: 15px;
			color: white;
		}

		.container a
		{
			color: white;
		}

		.container p
		{
			color: white;
		}

		.btnsubmit
		{
			padding: 5px 5px;
			border: none;
			background-color: #27ae60;
			color: #fff;
		}
	</style>
</head>
<body>
	<center>
	<div class="container">
		<img src="login.png">
			<div class="top">
				<?php
				session_start();
				if(isset($_SESSION['username'])){ ?>
					<div class = "header">
					<h1><?php echo "Welcome, " . $_SESSION['username']; ?> </h1>
					<h3><?php echo "Usertype: " . $_SESSION['usertype']; ?> </h3> 
					</div>
				<?php
				}
				else{
					header("location: login.php");
				}
				?>
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
					<a href="index.php">Home</a><br>
					<a href="logout.php">Logout</a><br><?php
					if((isset($_SESSION['usertype']) && $_SESSION['usertype'] != "USER")){?>
						<a href="create-equipment.php">Add Equipment</a><br><?php
					}?>
					<br><p>Search: <input type="text" name="txtsearch" placeholder="Input here">
					<input type="submit" name="btnsubmit" value="Find" class="btnsubmit"></p>
				</form>
				<center>
				<?php
				function build_table($result){
					if(mysqli_num_rows($result) > 0){
						//Table header
						echo "<table>";
						echo "<tr>";
						echo "<th>Serial Number</th>";
						echo "<th>Model</th>";
						echo "<th>Description</th>";
						echo "<th>Department</th>";
						echo "<th>Status</th>";
						echo "<th>Created By</th>";
						echo "</tr>";
						echo "<br>";
						//Table data (loop each row of the result)
						while($row = mysqli_fetch_array($result)){
							echo "<tr>";
							echo "<td>" . $row['serial_number'] . "</td>";
							echo "<td>" . $row['model'] . "</td>";
							echo "<td>" . $row['description'] . "</td>";
							echo "<td>" . $row['department'] . "</td>";
							echo "<td>" . $row['status'] . "</td>";
							echo "<td>" . $row['createdby'] . "</td>";
							echo "<td>";
							if((isset($_SESSION['usertype']) && $_SESSION['usertype'] != "USER")){
								echo "<a href = 'update-equipment.php?serial_number=" . $row['serial_number'] . "'>Update </a>";
								echo "<a href = 'delete-equipment.php?serial_number=" . $row['serial_number'] . "'>Delete</a>";
							}
							echo "</td>";
							echo "</tr>";
							echo "<br>";
						}
						echo "</table>";
					}
					else{
						?><p><?php echo "No equipment/s found"; ?></p><?php
					}
				}
				require_once "config.php";
				//search button
				if(isset($_POST['btnsubmit'])) {
					$sql = "SELECT * FROM equipmenttbl WHERE serial_number <> ? AND serial_number LIKE ? OR model LIKE ? ORDER BY serial_number";
					if($stmt = mysqli_prepare($link, $sql)) {
						$search = '%' . $_POST['txtsearch'] . '%';
						mysqli_stmt_bind_param($stmt, "sss", $_SESSION['username'], $search, $search);
						if(mysqli_stmt_execute($stmt)) {
							$result = mysqli_stmt_get_result($stmt);
							build_table($result);
						}
						else {
							echo "Error on search button";
						}
					}
				} 
				//Form load
				else {
					$sql = "SELECT * FROM equipmenttbl" ;
					if($stmt = mysqli_prepare($link, $sql)) {
						if(mysqli_stmt_execute($stmt)) {
							$result = mysqli_stmt_get_result($stmt);
							build_table($result);
						}
						else {
							echo "Error on form load";
						}
					}
				}
				?>
				</center>
			</div>
	</center>
	</body>
</html>