<?php include'src/config.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin-Login</title>
	<link rel="shortcut icon" href="../images/book_logo.png">

	<link rel="stylesheet" type="text/css" href="style/index.css">
</head>
<body>
	<?php include'src/header.php'; ?>
	<h2 class="center-align" style="font-family: 'Roboto';">Admin Login</h2>
	<hr style="margin: 5px 50px;">
	<div class="login-form">
	  	<div class="form">
		    <form action="<?php $_SERVER['PHP_SELF']?>" method="POST">
		      	<input type="text" name="username" placeholder="username.." required/><br>
		      	<input type="password" name="password" placeholder="password.." required/><br>
		      	
		      	<?php
					if ($_SERVER["REQUEST_METHOD"] == "POST")
					{
						if(isset($_POST["login"]) == true)
						{
							$uname = $_POST['username'];
							$pass = $_POST['password'];


							if ($stmt = $conn->prepare('SELECT password, name FROM super_user WHERE username = ?')) 
							{
								$stmt->bind_param('s', $uname);
								$stmt->execute();
								$stmt->store_result();

								if ($stmt->num_rows > 0)
								{
									$stmt->bind_result($password, $name);
									$stmt->fetch();
									if ($pass == $password) 
									{
										session_start();
										$_SESSION['loggedinadmin'] = TRUE;
										$_SESSION['name'] = $name;
										header("Location:dashboard-admin.php?name=$name");
										unset($uname);
									} 
									else 
									{
										echo "<div class='center-align' style='color: #bb2124; font-size:15px;'>"."&#9888; Sorry Wrong Password"."</div>";
										unset($uname);
									}
								}
								else
								{
									echo "<div class='center-align' style='color: #bb2124; font-size:15px;'>"."&#9888; Sorry Wrong Username"."</div>";
									unset($uname);
								}
							}
						}
					}
				?>


		      	<button name="login">login</button>
		    </form>
	  	</div>
	</div>

	<?php include 'src/footer.php'; ?>

	<script type="text/javascript">
		if ( window.history.replaceState ) {
 			 window.history.replaceState( null, null, window.location.href );
		}
	</script>

</body>
</html>