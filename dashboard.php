<?php
session_start();

if (!isset($_SESSION['loggedinstu'])) 
{
	header('Location: index.php');
	exit;
}

?>
<?php  
	require 'src/config.php';
?>
<?php 
	if (isset($_SESSION['Success-answer-submit'])){
		echo "<script>alert('Succesfully submitted the exam')</script>";
		$_SESSION['Success-answer-submit'] = null;
	} 
?>
<?php
	$cid = $_SESSION['collegeid'];
	$stmt = $conn->prepare('SELECT * FROM student_detail WHERE collegeid = ?');
	$stmt->bind_param('s', $cid);
	$stmt->execute();
	$stmt->bind_result($fname, $email, $rollnumber, $collegeid, $password, $examid);
	$stmt->fetch();
	$_SESSION['examid']=$examid;
	$stmt->close();
?>
<?php
	$examid = $_SESSION['examid'];
	
	if(isset($_POST["submit-exam-details"]) == true)
	{
		$subject_code = $_SESSION['sub'];
		$question_id = $_SESSION['sid'];

		$sqlq = "SELECT * FROM `$subject_code` WHERE student_examid = '$examid'"; 
		$result = $conn->query($sqlq);
												
		if ($result->num_rows > 0) 
		{
			echo "<script>alert('You had, already given your exam once!')</script>";
		}
		else 
		{
			if ($stmtnext = $conn->prepare("INSERT INTO `$subject_code` (student_name, student_examid, student_collegeid, stream, rollnumber) VALUES (?, ?, ?, ?, ?)"))
			{
				$stmtnext->bind_param('sssss', $_POST['student_name'], $_POST['student_examid'], $_POST['student_collegeid'], $_POST['stream'], $_POST['rollnumber']);
								
				if($stmtnext->execute())
				{
					session_start();
					$_SESSION['student_examid'] = $examid;
					$_SESSION['subject_code'] = $subject_code;
					$_SESSION['question_id'] = $question_id; 
					$_SESSION['next'] = true;
					header('Location:question.php?next=true');
				}	
				else
				{
					echo "cannot access database".mysqli_error($conn);
				}
			}
		}
	}

?>
<?php
	if (isset($_POST["updateform"]) == true)
	{
		if ($stmt = $conn->prepare('SELECT * FROM student_detail WHERE examid = ?')) 
		{
			$stmt->bind_param('s', $_SESSION['examid']);
			$stmt->execute();
			$stmt->store_result();

			if ($stmt->num_rows > 0)
			{
				$newpassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
																		
				$stmt = $conn->prepare('UPDATE student_detail SET fname=?, email=?, rollnumber=?, collegeid=?, password=? WHERE examid=?');
				$stmt->bind_param('ssssss',$_POST['fname'], $_POST['email'], $_POST['rollnumber'], $_POST['collegeid'], $newpassword, $_SESSION['examid']);

				if($stmt->execute()){
							       				
					$_SESSION['password'] = $_POST['password'];
					$_SESSION["success"] = true;
				}
				else
				{
					echo "Something Went Wrong";
				}		
			}
			else
			{
				echo "Something Went Wrong";
			}
		}
		$stmt->close();	
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title>Student | Dashboard</title>
	<link rel="shortcut icon" href="images/book_logo.png">
	

	<link rel="stylesheet" type="text/css" href="style/dashboard.css">
	<link rel="stylesheet" type="text/css" href="style/table.css">

	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<script src="jquery/jquery.js"></script>
	<script type="text/javascript">sessionStorage.setItem("time", 0);</script>

</head>
<body>
	
<?php include'src/header.php'; ?>
	
	<div class="dash-board">
		<div class="dash-navbar">
			<div class="dash-navbar-left">
				<p>Welcome: <?=$fname?></p>
			</div>
			<div class="dash-navbar-right">
				<ul class="tabs-menu">
				    <li class="active">
				        <a href="javascript:void(0);">
				            <span class="fas">&#xf015; Home</span>
				        </a>
				    </li>
				    <li>
				        <a href="javascript:void(0);">
				            <span class="fas">&#xf406; Profile</span>
				        </a>
					</li>
				</ul>
				<p><a class="fas" href="logout.php?name=<?=$fname?>">&#xf2f5; Logout</a></p>
			</div>
		</div>
		<div class="tab">
		    <div class="panes clear" style="display:block;">
		        <div class="tab-content">
		            <div class="tab-content-title">
		            	<h3>Home:</h3>
		            </div>
		            <div class="tab-content-main">
		            	<div class="tab-content-main">
		            		<div class="tab-content-main-up">
								<input class="form-control" id="myInput" class="myInput" type="text" placeholder="&#9819;Search Name, Paper-code, Semester..">
		            		</div>
		            		<br>
		            		<div class="tab-content-main-down">
		            			<div id="overlay"  class="overlay">
		            				<form action="dashboard.php" ><button class="overlay-cross" style="color: black; outline: none;">&#9747;</button></form>
  									<div id="text" class="overlay-text">
  										<section id="form" class="form-section">
											<?php
												if (isset($_POST['submit-answer']))
												{
													$_SESSION['sub'] = $_GET['sub'];
													$_SESSION['sid'] = $_GET['sid'];
													?>
													<script type="text/javascript">
														jQuery('.overlay').show();
													</script>
													<?php
												}
												else
												{
													?>
													<script type="text/javascript">
														jQuery('.overlay').hide();
													</script>
													<?php
												}
											?>
								        	<h1 style="text-align: center;">NOTE**: Check Your Details before Submit.<br> If any details is Wrong, then please update your profile details first.</h1>
								        	<form action="<?php $_SERVER['PHP_SELF']?>"method="POST">   
								            	<div class="form">
								                	<div class="tags">
								                    	<label for="student_name">Name:</label>
								                    	<div class="input"><input type="text" id="student_name" name="student_name" value="<?=$fname?>" readonly></div>
								                	</div>
									                <div class="tags">
									                    <label for="student_examid">Exam-ID</label>
									                    <div class="input"><input type="text" id="student_examid" name="student_examid" value="<?=$examid?>" readonly></div>
									                </div>
									                <div class="tags">
									                    <label for="student_collegeid">College-ID</label>
									                    <div class="input"><input type="text" id="student_collegeid" name="student_collegeid" value="<?=$collegeid?>" readonly></div>
									                </div>
									                <div class="tags">
									                    <label for="stream">Stream:</label>
									                    <div class="input"><input type="text" id="stream" name="stream" placeholder="stream..." required></div>
									                </div>
									                <div class="tags">
									                    <label for="rollnumber">Roll Number:</label>
									                    <div class="input"><input type="text" id="rollnumber" name="rollnumber" value="<?=$rollnumber?>" readonly></div>
									                </div>
									                <div class="tags">
									                	 <div class="input"><button id="submit-exam-details" name="submit-exam-details" style="">Next</button></div>
									                </div>
								            	</div>
								        	</form>
								    	</section>
  									</div>
								</div>
		            			<table class="table-main">
    								<thead class="thead-dark">
			      						<tr>
											<th>Question Id</th>
											<th>Stream</th>
											<th>Subject Code</th>
											<th>Semester</th>
											<th>Subject Name</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody id="myTable" class="myTable">
										<?php
											$sql = "SELECT * FROM question";
											$fire =  mysqli_query($conn,$sql) or die("cannnot access databse!".mysqli_error($conn));

											if (mysqli_num_rows($fire) > 0)
											{
												while ($users = mysqli_fetch_assoc($fire)) 
												{
													?>
														
													<tr>
														<td><?=$users['question_id']?></td>
														<td><?=$users['stream'] ?></td>
														<td><?=$users['subject_code']?></td>
														<td><?=$users['semester']?></td>
														<td><?=$users['subject_name']?></td>
														<td>
															<form action="<?php $_SERVER['PHP_SELF']?>?sub=<?=$users['subject_code']?>&sid=<?=$users['question_id']?>" method="POST"><button class="btn-primary btn-warning" name="submit-answer">Submit Answer</button></form>
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
		    <div class="panes clear">
		        <div class="tab-content">
		            <div class="tab-content-title">
		            	<h3>Profile:</h3>
		            </div>
		            <div class="tab-content-main">
		            	<div class="profile-details">
							<p><b>Your account details are below:</b></p>
							<table>
								<tr>
									<td><b>Full Name:</b></td>
									<td><?=$fname?></td>
								</tr>
								<tr>
									<td><b>Email:</b></td>
									<td><?=$email?></td>
								</tr>
								<tr>
									<td><b>Roll Number:</b></td>
									<td><?=$rollnumber?></td>
								</tr>
								<tr>
									<td><b>College Id:</b></td>
									<td><?=$collegeid?></td>
								</tr>
								<tr>
									<td><b>Password:</b></td>
									<td><?=$_SESSION['password']?></td>
								</tr>
								<tr>
									<td><b>Exam Id:</b></td>
									<td><?=$_SESSION['examid']?></td>
								</tr>
							</table>
							<p><b class="lower-text-profile" style="cursor: pointer;">Update Details</b></p>
							<div class="profile-update">
								<form action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
    								<div class="form-group">
      									<label for="fname">Full Name:</label>
      									<input type="text" class="form-control" value="<?=$fname?>" id="fname" name="fname" required>
    								</div>
    								<div class="form-group">
      									<label for="email">Email:</label>
      									<input type="text" class="form-control" value="<?=$email?>" id="email" name="email" required>
    								</div>
    								<div class="form-group">
      									<label for="rollnumber">Roll Number:</label>
      									<input type="text" class="form-control" value="<?=$rollnumber?>" id="rollnumber" name="rollnumber" required>
    								</div>
    								<div class="form-group">
      									<label for="collegeid">College-Id:</label>
      									<input type="text" class="form-control" value="<?=$collegeid?>" id="collegeid" name="collegeid" required>
    								</div>
    								<div class="form-group">
      									<label for="password">Password:</label>
      									<input type="text" class="form-control" value="<?=$_SESSION['password']?>" id="password" name="password" required>
    								</div>
    								<button class="btn btn-primary" name="updateform">Update</button>
    							</form>
							</div>
							<?php 
								if (isset($_SESSION["success"]) == true) 
								{
									echo '<div class="alert alert-success">Profile Details updated; 
											<span class="cross" style="float:right; cursor: pointer;">&#10008;</span></div>';
								}
							?>
						</div>
		            </div>
				</div>
		    </div>
		</div>
	</div>

<?php include'src/footer.php'; ?>

	<script type="text/javascript" src="jquery/login.js"></script>
	<script type="text/javascript" src="jquery/dashboard.js"></script>

	<script type="text/javascript">
		$(document).ready(function(){
  			$(".cross").click(function(){
    			jQuery('.alert').hide();
	    		<?php
	    			if (isset($_SESSION["success"]) == true) 
					{
						$_SESSION["success"] = NULL;	
					}
	    		?>
  			});
		});
	</script>
	<script type="text/javascript">
		if ( window.history.replaceState ) {
 			 window.history.replaceState( null, null, window.location.href );
		}
	</script>

</body>
</html>