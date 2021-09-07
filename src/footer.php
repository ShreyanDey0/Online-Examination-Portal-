
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="style/footer.css">
</head>
<body>
<div class="footer">
	<div class="footnav">
		<div class="left">
			<img src="images/book_logo.png"><h1>Online Examination Portal</h1>
		</div>
		<div class="right">
			<h3>&#9993; <a href="mailto:xyz@gmail.com">Give Us Feedback!</a></h3>
			<h3><a href="javascript:void(0);" id="queries">&#9993; Post Queries?</a></h3>
			<div class="hidden" style="display: none;">
				<form action="<?php $_SERVER['PHP_SELF']?>" method="POST">
					<div class="query-input"><input type="text" name="query-email" placeholder="email" required></div>
					<div class="query-input"><textarea name="query" placeholder="Post your query..." required></textarea></div>
					<div class="query-input"><button style="outline: none;" name="query-submit">Submit</button><span class="query-cross" style="display: none;"><b>&#9746;</b></span></div>
				</form>
			</div>
			<?php 
				if ($_SERVER["REQUEST_METHOD"] == "POST") {
					if (isset($_POST["query-submit"]) == true) {
						$email = $_POST['query-email'];
						$query = $_POST['query'];

						$sql = "INSERT INTO query(`query-email`,`query`) VALUES('$email', '$query')";
						$fire = mysqli_query($conn,$sql) or die("cannnot access databse!".mysqli_error($conn));
						
						if ($fire) {
						 	echo "Your Query has been Submitted successfully;"."<br>"."Wait for response.";
						}else {
							echo "Your Query has not been Submitted;"."<br>"."Try Again!";
						} 
					}
				}
			?>
			<h3>&#9743; Need Help? - <a href="tel:1234567890">1234567890</a></h3>
		</div>
	</div>
	<div class="footnav-btm">
		<div class="footer-copyright">
			<p><span style="color: white;">© 2020 Copyright:</span><a href="<?php echo $_SERVER['PHP_SELF'];?>" style="color: #A9A9A9;"> Online Examination Portal</a></p>
  		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
  		$("#queries").click(function(){
    		jQuery('.hidden').show();
    		jQuery('.query-cross').show();
  		});
  		$(".query-cross").click(function(){
    		jQuery('.hidden').hide();
    		jQuery('.query-cross').hide();
  		});
  	});
</script>
</body>
</html>