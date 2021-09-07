<?php
session_start();

if (!isset($_SESSION['loggedintea'])) 
{
	header('Location: index.php');
	exit;
}

?>
<?php  
	require 'src/config.php';
?>
<?php 
	$stmt = $conn->prepare('SELECT * FROM teacher_detail WHERE collegeid = ?');
	$stmt->bind_param('s', $_SESSION['collegeid']);
	$stmt->execute();
	$stmt->bind_result($fname, $examid, $collegeid, $password);
	$stmt->fetch();
	$stmt->close();
?>
<?php  
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if(isset($_POST["add"]) == true)
		{
			if ($stmt = $conn->prepare('SELECT * FROM question WHERE subject_code = ? AND semester = ?')) 
			{
				$stmt->bind_param('ss', $_POST['subject_code'], $_POST['semester']);
				$stmt->execute();
				$stmt->store_result();
	
				if ($stmt->num_rows > 0) 
				{
					echo "<script>alert('Question Already Added!')</script>";
				}
				else 
				{
					$subject_name =  $_POST['subject_code'];

					$sqli = "CREATE TABLE `$subject_name` ( `Id` INT NULL AUTO_INCREMENT , `student_name` VARCHAR(255) NOT NULL , `student_examid` VARCHAR(255) NOT NULL , `student_collegeid` VARCHAR(255) NOT NULL , `stream` VARCHAR(255) NOT NULL , `rollnumber` VARCHAR(255) NOT NULL , `question_1` VARCHAR(2000) NOT NULL , `question_2` VARCHAR(2000) NOT NULL , `question_3` VARCHAR(2000) NOT NULL , `question_4` VARCHAR(2000) NOT NULL , `question_5` VARCHAR(2000) NOT NULL , `question_6` VARCHAR(2000) NOT NULL , PRIMARY KEY (`Id`)) ENGINE = InnoDB;";

					$fire = mysqli_query($conn,$sqli) or die("cannnot access databse!".mysqli_error($conn));
					if ($fire) {
						if ($stmtq = $conn->prepare('INSERT INTO question (stream, subject_code, semester, subject_name, teacher_id, time, fullmarks, question_1, question_2, question_3, question_4, question_5, question_6) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'))
						{
							$stmtq->bind_param('sssssssssssss', $_POST['stream'], $_POST['subject_code'], $_POST['semester'], $_POST['subject_name'], $_POST['teacher_id'], $_POST['time'], $_POST['fullmarks'], $_POST['question_1'], $_POST['question_2'], $_POST['question_3'], $_POST['question_4'], $_POST['question_5'], $_POST['question_6'] );
					
							if($stmtq->execute()){
								header('Location: '.$_SERVER['PHP_SELF']);
								die;
								echo "<script>alert('New question Added!')</script>";
							}
						}
								
					}
					else
					{
						echo "<script>alert('New question cannot be Added!')</script>";
					}
				}
			}				
		}

		elseif(isset($_POST["delete"]) == true)
		{
			$id = $_GET['del'];
			$sqlr = "DROP TABLE `$id`";
			$fire = mysqli_query($conn,$sqlr) or die("cannnot access databse!".mysqli_error($conn));
		
			if ($fire) {
		 		$sqld = "DELETE FROM question WHERE subject_code = '$id'";
		 		$fired = mysqli_query($conn,$sqld) or die("canot access database!".mysqli_error($conn));
		 		if ($fired) {
					echo "<script>alert('Question deleted successfully')</script>";
					header('Location: '.$_SERVER['PHP_SELF']);
					die;		 			
		 		}
		 		else{
					echo "<script>alert('Question cannot be deleted')</script>";
				}
			}
			else{
				echo "<script>alert('Question cannot be deleted')</script>";
			}		
		}
		elseif(isset($_POST["update"]) == true)
		{
			$_SESSION['qid'] = $_GET['qid'];
			$_SESSION['uid'] = $_GET['uid'];
			$_SESSION['update'] = true;
			header('Location: update-question.php?status=true');
		}
		elseif(isset($_POST["view"]) == true)
		{
			$_SESSION['vid'] = $_GET['vid'];
			$_SESSION['qid'] = $_GET['qid'];
			$_SESSION['view-answer'] = true;
			header('Location: view-answer.php?status=true');
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title>Teacher | Dashboard</title>
	<link rel="shortcut icon" href="images/book_logo.png">


	<link rel="stylesheet" type="text/css" href="style/dashboard.css">
	<link rel="stylesheet" type="text/css" href="style/table.css">
	<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
	<script src="jquery/jquery.js"></script>
	<style type="text/css">
		
	</style>

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
		            	<div class="tab-content-main-up">
							<input class="form-control" id="myInput" class="myInput" type="text" placeholder="&#9819;Search Name, Paper-code, Semester..">
							<span><button id="overlay-on">Add Question</button></span>
		            	</div>
		            	<br>
		            	<div class="tab-content-main-down">
		            		<div id="overlay"  class="overlay">
		            			<span class="overlay-cross" style="">&#9747;</span>
  								<div id="text" class="overlay-text">
  									<b><h3 style="text-align: center;">Add Question:-</h3></b>
  									<hr>
  									<section id="form" class="form-section">
								        <form action="<?php $_SERVER['PHP_SELF']?>"method="POST">   
								            <div class="form">
								                <div class="tags">
								                    <label for="stream">Stream:</label>
								                    <div class="input"><input type="text" id="stream" name="stream" placeholder="stream..." required></div>
								                </div>
								                <div class="tags">
								                    <label for="subject_code">Subject code:</label>
								                    <div class="input"><input type="text" id="subject_code" name="subject_code" placeholder="subject_code..." required></div>
								                </div>
								                <div class="tags">
								                    <label for="semester">Semester:</label>
								                    <div class="input"><input type="number" id="semester" name="semester" placeholder="semester..." required></div>
								                </div>
								                <div class="tags">
								                    <label for="subject_name">Subject_name:</label>
								                    <div class="input"><input type="text" id="subject_name" name="subject_name" placeholder="subject_name..." required></div>
								                </div>
								                <div class="tags">
								                    <label for="teacher_id">Teacher_id:</label>
								                    <div class="input"><input type="text" id="teacher_id" name="teacher_id" value="<?=$collegeid?>" placeholder="College-Id..." required readonly></div>
								                </div>
								                <div class="tags">
								                    <label for="time">Time:<span style="font-size: 10px;"><span style="color: red;">*</span>(In Minute)</span></label>
								                    <div class="input"><input type="number" id="time" name="time" placeholder="time..." required></div>
								                </div>
								                <div class="tags">
								                    <label for="fullmarks">Fullmarks:</label>
								                    <div class="input"><input type="number" id="fullmarks" name="fullmarks" placeholder="fullmarks..." required></div>
								                </div>
								                <div class="tags">
								                    <label for="question_1">question_1:</label>
								                    <div class="input"><textarea id="question_1" name="question_1" placeholder="Question" required></textarea></div>
								                </div>
								                <div class="tags">
								                    <label for="question_2">question_2:</label>
								                    <div class="input"><textarea id="question_2" name="question_2" placeholder="Question" required></textarea></div>
								                </div>
								                <div class="tags">
								                    <label for="question_3">question_3:</label>
								                    <div class="input"><textarea id="question_3" name="question_3" placeholder="Question" required></textarea></div>
								                </div>
								                <div class="tags">
								                    <label for="question_4">question_4:</label>
								                    <div class="input"><textarea id="question_4" name="question_4" placeholder="Question" required></textarea></div>
								                </div>
								                <div class="tags">
								                    <label for="question_5">question_5:</label>
								                    <div class="input"><textarea id="question_5" name="question_5" placeholder="Question" required></textarea></div>
								                </div>
								                <div class="tags">
								                    <label for="question_6">question_6:</label>
								                    <div class="input"><textarea id="question_6" name="question_6" placeholder="Question" required></textarea></div>
								                </div>
								                <div class="tags">
								                	 <div class="input"><button id="add" name="add" style="">Add</button></div>
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
										<th>Action</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody id="myTable" class="myTable">
									<?php
										$sql = "SELECT * FROM question WHERE teacher_id = '$collegeid'";
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
														<form action="<?php $_SERVER['PHP_SELF']?>?del=<?=$users['subject_code']?>" method="POST"><button class="btn-primary btn-danger" name="delete">Delete</button></form>
													</td>
													<td>
														<form action="<?php $_SERVER['PHP_SELF']?>?uid=<?=$users['subject_code']?>&qid=<?=$users['question_id']?>" method="POST"><button class="btn-primary btn-warning" name="update">Update & View</button></form>
													</td>
													<td>
														<form action="<?php $_SERVER['PHP_SELF']?>?vid=<?=$users['subject_code']?>&qid=<?=$users['question_id']?>" method="POST"><button class="btn-primary btn-info" name="view">View Answer</button></form>
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
									<td><b>College Id:</b></td>
									<td><?=$collegeid?></td>
								</tr>
								<tr>
									<td><b>Password:</b></td>
									<td><?=$password?></td>
								</tr>
								<tr>
									<td><b>Exam Id:</b></td>
									<td><?=$examid?></td>
								</tr>
							</table>
							<p><b class="lower-text-profile" style="cursor: pointer;">Update Details</b></p>
							<div class="profile-update">
								<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
    								<div class="form-group">
      									<label for="fname">Full Name:</label>
      									<input type="text" class="form-control" value="<?=$fname?>" id="fname" name="fname" required>
    								</div>
    								<div class="form-group">
      									<label for="collegeid">College-Id:</label>
      									<input type="text" class="form-control" value="<?=$collegeid?>" id="collegeid" name="collegeid" required>
    								</div>
    								<div class="form-group">
      									<label for="password">Password:</label>
      									<input type="text" class="form-control" value="<?=$password?>" id="password" name="password" required>
    								</div>
    								<button class="btn btn-primary" name="updateform" id="updateform">Update</button>
    							</form>
							</div>
							<?php
								if (isset($_POST["updateform"]) == true)
								{
									$fname = $_POST['fname'];
									$collegeid = $_POST['collegeid'];
									$password = $_POST['password'];

									$sql5 = "UPDATE teacher_detail SET fname = '$fname', collegeid = '$collegeid', password = '$password' WHERE examid = '$examid'";
									$fire = mysqli_query($conn,$sql5) or die("cannnot access databse!".mysqli_error($conn));
										
									if ($fire) { 
										echo '<div style="padding:10px; color:#4a536e;">profile details updated</div>';
									}
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
		if ( window.history.replaceState ) {
 			 window.history.replaceState( null, null, window.location.href );
		}
	</script>
</body>
</html>