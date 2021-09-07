<?php include'src/config.php'; ?>
<?php
	session_start();
	if (!isset($_SESSION['loggedinadmin'])) 
	{
		header('Location:index.php');
		exit;
	}

?>
<?php
	if (isset($_GET['deletetec'])){
		$id = $_GET['deletetec'];
		$sql = "DELETE FROM teacher_detail WHERE collegeid = '$id'";
		$fire = mysqli_query($conn,$sql) or die("cannnot access databse!".mysqli_error($conn));
								
		if ($fire) {
		 	header('Location: '.$_SERVER['PHP_SELF']);
		}
	}
?>
<?php
	if (isset($_GET['deletestu'])) {
		$id = $_GET['deletestu'];
		$sql = "DELETE FROM student_detail WHERE examid = '$id'";
		$fire = mysqli_query($conn,$sql) or die("cannnot access databse!".mysqli_error($conn));
								
		if ($fire) {
		 	header('Location: '.$_SERVER['PHP_SELF']);
		}
	}
?>
<?php
	if (isset($_GET['deleteq'])) {
		$id = $_GET['deleteq'];
		$sql = "DELETE FROM query WHERE `query_id` = '$id'";
		$fire = mysqli_query($conn,$sql) or die("cannnot access databse!".mysqli_error($conn));
		
		if ($fire) {
			header('Location: '.$_SERVER['PHP_SELF']);
		}
	}
?>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin-Dashboard</title>
	<link rel="shortcut icon" href="../images/book_logo.png">
	<link rel="stylesheet" type="text/css" href="style/dashboard-admin.css">
	<link rel="stylesheet" type="text/css" href="style/index.css">
	<link rel="stylesheet" type="text/css" href="../style/table.css">

	<script type="text/javascript" src="../jquery/jquery.js"></script>
</head>
<body>
	<?php include'src/header.php'; ?>

	<div class="main-body">	
		<div class="tabs-container">            
		    <div class="tabs-menu">
		        <li class="active">
		            <a href="javascript:void(0);"> Teacher </a>
		        </li>
		        <li>
		        	<a href="javascript:void(0);"> Student </a>
				</li>
		        <li>
		        	<a href="javascript:void(0);">  Issues> </a>
		        </li>
		        <br>
		        <hr>
		        <span><a href="logout.php" style="color: white; text-decoration: none; padding: 8px;"><I>Logout</I></a></span>
		    	<hr>	
		    </div>
		    <div class="tab">
		        <div class="panes clear" style="display:block;">
		        	<div class="tab-content">
		        		<h3 class="center-align">Teacher</h3>
		        		<hr style="margin: 1px 40px 10px 40px;">
		        		<br>
		        		<div class="login-form">
						  	<div class="form">
							    <form action="<?php $_SERVER['PHP_SELF']?>" method="POST">
							      	<input type="text" name="fname" placeholder="Full Name.." required/><br>
							      	<input type="text" name="collegeid" placeholder="College Id.." required/><br>
							      	<input type="text" name="examid" placeholder="Exam ID.." required/><br>
							      	<input type="text" name="password" placeholder=" Set Password.." required/><br>		      	
							      	<?php
										if ($_SERVER["REQUEST_METHOD"] == "POST")
										{
											if (isset($_POST['submit'])){
		
												$fname = $_POST['fname'];
												$collegeid = $_POST['collegeid'];
												$examid = $_POST['examid'];
												$password = $_POST['password'];

												$sql = "INSERT INTO teacher_detail(fname, collegeid, examid, password) VALUES('$fname', '$collegeid', '$examid', '$password')";
												$fire = mysqli_query($conn,$sql) or die("cannnot access databse!".mysqli_error($conn));
												
												if ($fire) {
												 	echo "Teacher details successfully updated";
												} 
											}
										}
									?>
							      	<button name="submit">Add Details</button>
							    </form>
						  	</div>
						</div>
		        		<hr>
				        <div class="center-align" ><input style="outline:none; padding: 5px; width: 80%;" id="myInput1" type="text" placeholder="Search Name, Id , etc.."></div>
						<table class="table" style="margin: 20px 80px; ">
		    				<thead class="thead-dark">
		      					<tr>
									<th>Full Name</th>
									<th>Examid</th>
									<th>College Id</th>
									<th>Password</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody id="myTable1">

								<?php
									$sql = "SELECT * FROM teacher_detail";
									$fire =  mysqli_query($conn,$sql) or die("cannnot access databse!".mysqli_error($conn));

									if (mysqli_num_rows($fire) > 0)
									{
										while ($users = mysqli_fetch_assoc($fire)) 
										{
											?>
											
											<tr>
												<td><?=$users['fname']?></td>
												<td><?=$users['examid'] ?></td>
												<td><?=$users['collegeid']?></td>
												<td><?=$users['password']?></td>
												<td>
													<a href="<?php $_SERVER['PHP_SELF']?>?deletetec=<?=$users['collegeid']?>" class="btn btn-primary btn-danger">Delete</a>
												</td>
											<tr>

											<?php
										}	
									}
								?>
							</tbody>
						</table>
		        	</div>
				</div>
		        <div class="panes clear">
		        	<div class="tab-content">
		            	<h3 class="center-align">Student</h3>
		        		<hr style="margin: 1px 40px 10px 40px;"> 
		        		<div class="center-align" ><input style="outline:none; padding: 5px; width: 80%;" id="myInput2" type="text" placeholder="Search Name, Id , etc.."></div>
		  				<br>
						<table class="table" style="margin: 20px 80px; ">
		    				<thead class="thead-dark">
		      					<tr>
									<th>Full Name</th>
									<th>Email</th>
									<th>Roll Number</th>
									<th>College Id</th>
									<th>Password</th>
									<th>Examid</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody id="myTable2">

								<?php
									$sql = "SELECT * FROM student_detail";
									$fire =  mysqli_query($conn,$sql) or die("cannnot access databse!".mysqli_error($conn));

									if (mysqli_num_rows($fire) > 0)
									{
										while ($users = mysqli_fetch_assoc($fire)) 
										{
											?>
											
											<tr>
												<td><?=$users['fname']?></td>
												<td><?=$users['email'] ?></td>
												<td><?=$users['rollnumber'] ?></td>
												<td><?=$users['collegeid']?></td>
												<td><?=$users['password']?></td>
												<td><?=$users['examid'] ?></td>
												<td>
													<a href="<?php $_SERVER['PHP_SELF']?>?deletestu=<?=$users['examid']?>" class="btn btn-primary btn-danger">Delete</a>
												</td>
											<tr>

											<?php
										}	
									}
								?>
							</tbody>
						</table>    
		            </div>
		        </div>                               
		        <div class="panes clear">
		        	<div class="tab-content">
				        <h3 class="center-align">Support</h3>
		        		<hr style="margin: 1px 40px 10px 40px;">
				       	<div class="center-align" ><input style="outline:none; padding: 5px; width: 80%;" id="myInput3" type="text" placeholder="Search Name, Id , etc.."></div>
		  				<br>
						<table class="table" style="margin: 20px 80px; ">
		    				<thead class="thead-dark">
		      					<tr>
									<th>Id</th>
									<th>Email</th>
									<th>Query</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody id="myTable3">

								<?php
									$sql = "SELECT * FROM `query`";
									$fire =  mysqli_query($conn,$sql) or die("cannnot access databse!".mysqli_error($conn));

									if (mysqli_num_rows($fire) > 0)
									{
										while ($users = mysqli_fetch_assoc($fire)) 
										{
											?>
											
											<tr>
												<td><?=$users['query_id'] ?></td>
												<td><a href="mailto:<?=$users['query-email'];?>" style="color: black; text-decoration: none;"><?=$users['query-email'];?></a></td>
												<td><?=$users['query'] ?></td>
												<td>
													<a href="<?php $_SERVER['PHP_SELF']?>?deleteq=<?=$users['query_id']?>" class="btn btn-primary btn-danger">Delete</a>
												</td>
											<tr>

											<?php
										}	
									}
								?>
							</tbody>
						</table>
			    	</div>
		        </div>
		    </div>
	    </div>
	</div>
		
	<?php include 'src/footer.php'; ?>

	<script type="text/javascript" src="jquery/dashboard-admin.js"></script>
	<script type="text/javascript">
		if ( window.history.replaceState ) {
 			 window.history.replaceState( null, null, window.location.href );
		}
	</script>
</body>