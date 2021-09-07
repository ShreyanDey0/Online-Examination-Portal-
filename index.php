<?php  
	require 'src/config.php';
?>

<?php  
	
	$query1 = "SELECT * FROM student_detail ORDER BY examid DESC limit 1";
	
	$result1 = mysqli_query($conn, $query1);
	$row = mysqli_fetch_array($result1);
	$lastid = $row['examid'];

	if ($lastid == '') 
	{
		$examid = "EXM/STU/111";
	}
	else
	{
		$examid = substr($lastid, 8);
		$examid = intval($examid);
		$examid = "EXM/STU/" . ($examid + 1);		
	}
?>

<?php 
	if ($_SERVER["REQUEST_METHOD"] == "POST") 
	{
		if(isset($_POST["signupform"]) == true)
		{
			if ($stmt = $conn->prepare('SELECT collegeid, rollnumber FROM student_detail WHERE email = ?')) 
			{
				$stmt->bind_param('s', $_POST['email']);
				$stmt->execute();
				$stmt->store_result();
	
				if ($stmt->num_rows > 0) 
				{
					session_start();
					$_SESSION["already_done"] = true;
				}
				else 
				{
					if ($stmt = $conn->prepare('INSERT INTO student_detail (fname, email, rollnumber, collegeid, password, examid) VALUES (?, ?, ?, ?, ?, ?)'))
					{
						$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
						$stmt->bind_param('ssssss', $_POST['fname'], $_POST['email'], $_POST['rollnumber'], $_POST['collegeid'], $password, $_POST['examid'] );
						$stmt->execute();

						session_start();
						$_SESSION["success"] = true;
						
					}
					else
					{
						session_start();
						$_SESSION["unsuccess"] = true;
					}
				}
				$stmt->close();
			}
			$conn->close(); 
		}
		elseif (isset($_POST["loginform"]) == true) 
		{	
			if ($stmt = $conn->prepare('SELECT password, fname FROM student_detail WHERE collegeid = ?')) 
			{
				$stmt->bind_param('s', $_POST['collegeid']);
				$stmt->execute();
				$stmt->store_result();

				if ($stmt->num_rows > 0)
				{
					$stmt->bind_result($password, $fname);
					$stmt->fetch();
					if (password_verify($_POST['password'], $password)) 
					{
						session_start();
						$_SESSION['loggedinstu'] = TRUE;
						$_SESSION['collegeid'] = $_POST['collegeid'];
						$_SESSION['fname'] = $fname;
						$_SESSION['password'] = $_POST['password'];

						header("Location: dashboard.php?name=$fname");
					} 
					else 
					{
						session_start();
						$_SESSION["incorrect"] = true;
					}
				}
				elseif($stmt = $conn->prepare('SELECT password, fname FROM teacher_detail WHERE collegeid = ?'))
				{
					$stmt->bind_param('s', $_POST['collegeid']);
					$stmt->execute();
					$stmt->store_result();

					if ($stmt->num_rows > 0)
					{
						$stmt->bind_result($password, $fname);
						$stmt->fetch();
						if ($_POST['password'] === $password) 
						{
							session_start();
							$_SESSION['loggedintea'] = TRUE;
							$_SESSION['collegeid'] = $_POST['collegeid'];
							$_SESSION['fname'] = $fname;

							header("Location: dashboard-teacher.php?name=$fname");
						} 
						else 
						{
							session_start();
							$_SESSION["incorrect"] = true;
						}
					}
					else 
					{	
						session_start();
						$_SESSION["incorrect"] = true;
					}

				}
				else 
				{	
					session_start();
					$_SESSION["incorrect"] = true;
				}
			}
			else 
			{	
				session_start();
				$_SESSION["incorrect"] = true;
			}

			$stmt->close();
		}
		elseif (isset($_POST["forgetform"]) == true)
		{
			if ($stmt = $conn->prepare('SELECT password FROM student_detail WHERE email = ? AND collegeid = ?')) 
			{
				$stmt->bind_param('ss', $_POST['email'] , $_POST['collegeid']);
				$stmt->execute();
				$stmt->store_result();

				if ($stmt->num_rows > 0)
				{
					$newpassword = password_hash($_POST['email'], PASSWORD_DEFAULT);
					$stmt = $conn->prepare('UPDATE student_detail SET password=?  WHERE email=? AND collegeid=?');
					$stmt->bind_param('sss', $newpassword, $_POST['email'] , $_POST['collegeid']);
       				$stmt->execute();
       				echo "<script>alert('Your email is your new password!')</script>";		
				}
				else
				{
					session_start();
					$_SESSION["incorrect"] = true;
				}
			}
			$stmt->close();
		}  
	}
	else 
	{
		// header('Location:login.php');
	}
			

?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login Portal</title>
	<link rel="shortcut icon" href="images/book_logo.png">
	<link rel="stylesheet" type="text/css" href="style/login.css">
  	<script src="jquery/jquery.js"></script>
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<?php include'src/header.php'; ?>

	<!-- navbar -->
		<div class="tabs-container">
			
			<!-- navheader -->

			<div class="tab-section">
				<div class="openNav" style="font-size:30px;cursor:pointer" onclick="openNav()" id="openNav">&#9776;</div><span onclick="closeNav()" class="openNav closeNav" id="closeNav" style="font-size: 30px; color: black; padding: 12px 3px;">&#10005;</span>
				<ul class="tabs-menu" id="mySidenav">
				    <li>
				        <a href="javascript:void(0);">
					       	<h3>About</h3>
					    </a>
					</li>
					<li class="login">
					    <a href="javascript:void(0);">
					        <h3>Log in</h3>
						</a>
					</li>
					<li class="active signup">
					    <a href="javascript:void(0);">
					        <h3>Sign Up(Student)</h3>
					    </a>
					</li>
				</ul>
			</div>

			<!-- navbody -->

			<div class="tabs-body">

				<div class="tabs-picture">
					<img src="images/Books_login_page.jpg">
				</div>


				<div class="tab">
					<?php 
						if (isset($_SESSION["success"]) == true) 
						{
							echo '<div class="alert alert-success">Success! You Have SignedUp successfully; 
									<span class="cross" style="float:right; cursor: pointer;">&#10008;</span></div>';
							session_destroy();
						}
						elseif (isset($_SESSION["unsuccess"]) == true) 
						{
							echo '<div class="alert alert-unsuccess">Sorry! Something Went Wrong.
									<span class="cross" style="float:right; cursor: pointer;">&#10008;</span></div>';
							session_destroy();
						}
						elseif (isset($_SESSION["already_done"]) == true) 
						{
							echo '<div class="alert alert-unsuccess">Hola! You have already signed up;
									<span class="cross" style="float:right; cursor: pointer;">&#10008;</span></div>';
							session_destroy();
						}
						elseif (isset($_SESSION["incorrect"]) == true) 
						{
							echo '<div class="alert alert-unsuccess">Invalid Details!
									<span class="cross" style="float:right; cursor: pointer;">&#10008;</span></div>';
							session_destroy();
						}
					?>
					<!-- navabout -->

					<div class="panes clear" id="about">
				        <div class="tab-content">
				        	<h3 class="form-head" style="background-color: #B8B8B8;">About</h3>
							<p>Hello World</p>
						</div>
				    </div>

				    <!-- nav-loginform -->

				    <div class="panes clear">
				        <div class="tab-content">
				        	<h3 class="form-head" style="background-color: #B8B8B8;">Log in</h3>
							<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" style="padding-top: 1rem;">
								<div class="form-group">
      								<label for="collegeid">College-Id:<span style="color: red; font-size: 10px;">*</span></label>
      								<input type="text" class="form-control" id="collegeid" placeholder="Enter Your college id" name="collegeid" required>
    							</div>
    							<div class="form-group">
      								<label for="password">Password:<span style="color: red; font-size: 10px;">*</span></label>
      								<input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required>
      								<span toggle="#password" class="fa fa-fw fa-lock field-icon toggle-password"></span>
    							</div>
    							<button type="submit" class="btn btn-primary" name="loginform">Submit</button>
    							<span class="button-side-text signup-txt"><a href="javascript:void(0);">Need Account? Sign Up</a></span>
    							<br><br>
    							<span class="button-side-text forget-txt"><a href="javascript:void(0);">Forget password?</a></span>
							</form>
				        </div>

				        <!-- nav-resetform -->

				        <div class="tab-content reset">
				        	<h3 class="form-head" style="background-color: #B8B8B8;">Forget Password</h3>
							<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" style="padding-top: 1rem;">
								<div class="form-group">
      								<label for="collegeid">College Id:<span style="color: red; font-size: 10px;">*</span></label>
      								<input type="text" class="form-control" id="collegeid" placeholder="Enter Your college id" name="collegeid" required>
    							</div>
    							<div class="form-group">
      								<label for="email">Email:<span style="color: red; font-size: 10px;">*</span></label>
      								<input type="text" class="form-control" id="email" placeholder="Enter Your Email" name="email" required>
    							</div>
    							<button type="submit" class="btn btn-primary reset" name="forgetform">Reset</button>
							</form>
				        </div>
					</div>

					<!-- nav-signupform -->

				    <div class="panes clear" style="display:block;">
				        <div class="tab-content">
				        	<h3 class="form-head" style="background-color: #B8B8B8;">Sign Up (Student)</h3>
							<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" style="padding-top: 1rem;">
    							<div class="form-group">
      								<label for="fname">Full Name:<span style="color: red; font-size: 10px;">*</span></label>
      								<input type="text" class="form-control" id="fname" placeholder="Enter Your Full name" name="fname" required>
    							</div>
    							<div class="form-group">
      								<label for="email">Email:<span style="color: red; font-size: 10px;">*</span></label>
      								<input type="text" class="form-control" id="email" placeholder="Enter Your Email" name="email" required>
    							</div>
    							<div class="form-group">
      								<label for="rollnumber">Roll Number:<span style="color: red; font-size: 10px;">*</span></label>
      								<input type="text" class="form-control" id="rollnumber" placeholder="Stream-year-section-collegeRollNumber-semester (e.g BCA3A0455)" name="rollnumber" required>
    							</div>
    							<div class="form-group">
      								<label for="collegeid">College-Id:<span style="color: red; font-size: 10px;">*</span></label>
      								<input type="text" class="form-control" id="collegeid" placeholder="Enter Your college id" name="collegeid" required>
    							</div>
    							<div class="form-group">
      								<label for="password">Password:<span style="color: red; font-size: 10px;">*</span></label>
      								<input type="text" class="form-control" id="password" placeholder="Create Password" name="password" required>
    							</div>
    							<div class="form-group">
      								<label for="examid">Exam id:</label>
      								<input type="text" class="form-control" id="examid" value="<?=$examid ?>" name="examid" readonly>
    							</div>
    							<button class="btn btn-primary" name="signupform">Submit</button>
    							<span class="button-side-text login-txt"><a href="javascript:void(0);">Have Account? Log in</a></span>
    						</form>
				        </div>
				    </div>

				    <!-- nav-formends -->

				</div>
			</div>
		</div>

		<footer>
			<?php include 'src/footer.php' ?>
		</footer>	


<script type="text/javascript" src="jquery/login.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
  		$(".cross").click(function(){
    		jQuery('.alert').hide();
    		<?php
    			if (isset($_SESSION["success"]) == true) 
				{
					$_SESSION["success"] = NULL;	
				}
				elseif (isset($_SESSION["unsuccess"]) == true) 
				{
					$_SESSION["unsuccess"]	= NULL;
				}
				elseif (isset($_SESSION["already_done"]) == true) 
				{
					$_SESSION["already_done"]	= NULL;
				}
				elseif (isset($_SESSION["incorrect"]) == true) 
				{
					$_SESSION["incorrect"]	= NULL;
				}
    		?>
  		});
	});
	
	if ( window.history.replaceState ) {
 		window.history.replaceState( null, null, window.location.href );
	}
</script>

</body>
</html>