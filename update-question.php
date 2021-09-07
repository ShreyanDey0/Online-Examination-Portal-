<?php  
	require 'src/config.php';
?>
<?php
	session_start();

	if (!isset($_SESSION['update'])) {
		header('Location: dashboard-teacher.php');
		exit;
	}

	if ($_GET['status'] != 'true'){
		header('Location: dashboard-teacher.php');
		exit;
	}
	$uid = $_SESSION['uid'];
	$qid = $_SESSION['qid'];
?>
<?php 
	$sql = "SELECT * FROM question WHERE subject_code = '$uid' AND question_id = '$qid'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
  		
  		$question = $result->fetch_assoc();
	} 
	else {
  		echo "Warning data cannot be fetched! : ". mysqli_error($conn);
	}
?>
<?php  
	
	if (isset($_POST["update-question-paper"]) == true)
	{
		$subject_code = $_POST['subject_code'];
		$subject_name = $_POST['subject_name'];
		$semester = $_POST['semester'];
		$stream = $_POST['stream'];
		$time = $_POST['time'];
		$fullmarks = $_POST['fullmarks'];
		$question_1 = $_POST['question_1'];
		$question_2 = $_POST['question_2'];
		$question_3 = $_POST['question_3'];
		$question_4 = $_POST['question_4'];
		$question_5 = $_POST['question_5'];
		$question_6 = $_POST['question_6'];

		$question_id = $_SESSION['qid'];

		$sql8 = "UPDATE question 
				SET subject_code = '$subject_code', subject_name = '$subject_name', semester = '$semester', stream = '$stream', time = '$time', fullmarks = '$fullmarks',  	question_1= '$question_1', question_2 = '$question_2', question_3 = '$question_3', question_4 = '$question_4', question_5 = '$question_5', question_6 = '$question_6'
			 	WHERE question_id = '$question_id'";

		$fire = mysqli_query($conn,$sql8) or die("cannnot access databse!".mysqli_error($conn));
		if ($fire) { 
			$_SESSION['update'] = NULL;
			$sql9 = "RENAME TABLE `$uid` TO `$subject_code`";
			mysqli_query($conn,$sql9) or die("cannnot access databse!".mysqli_error($conn));
			header('Location: dashboard-teacher.php');
		}
		else{
			echo "<script>alert('Question cannot be updated Updated')</script>";	
		}
	}
	elseif (isset($_POST["cancel"]) == true){
		$_SESSION['update'] = NULL;
		header('Location: dashboard-teacher.php');
	}

?>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Update-<?php echo $_SESSION['uid']; ?></title>
	<link rel="shortcut icon" href="images/book_logo.png">

	
	<link rel="stylesheet" type="text/css" href="style/question.css">

</head>
<body>
<?php include'src/header.php'; ?>
	<div class="question-paper">
		<div class="header-question">
			<div class="logo center-column">
				<img src="images/book_logo.png">
			</div>
			<h1>Online Examination Portal- Question Paper</h1>
			<hr>
		</div>
		<form action="<?php $_SERVER['PHP_SELF']?>" method="POST">
			<div class="nav">
				<div class="tags center-column">
					<label for="subject_code">Paper code : </label><span><input type="text" id="subject_code" name="subject_code" value="<?=$question['subject_code']?>" required></span>
				</div>
		    	<div class="tags center-column">
		      		<label for="subject_name">Paper Name : </label><span><input type="text" class="form-control" value="<?=$question['subject_name']?>" id="subject_name" name="subject_name" required></span>	
		    	</div>
		    	<div class="double-column">
			    	<div class="tags center-column">
			      		<label for="semester">Semester : </label><span><input type="number" class="form-control" value="<?=$question['semester']?>" id="semester" name="semester" required></span>	
			    	</div>
			    	<div class="tags center-column">
			      		<label for="stream">Stream : </label><span><input type="text" class="form-control" value="<?=$question['stream']?>" id="stream" name="stream" required></span>	
			    	</div>
			    </div>
		    	<div class="double-column">
		    		<div class="tags center-column">
		      			<label for="time">Time(Mins) : </label><span><input type="number" class="form-control" value="<?=$question['time']?>" id="time" name="time" required></span>	
		    		</div>
		    		<div class="tags center-column">
		      			<label for="fullmarks">Full Marks : </label><span><input type="number" class="form-control" value="<?=$question['fullmarks']?>" id="fullmarks" name="fullmarks" required></span>	
		    		</div>
		    	</div>
		    	<hr style="margin: 9px 25px;">
			</div>
			<div class="question">
				<h2 class="center-column"><u>Answer any 5 Question:-</u></h2>
				<div class="tags">
			      	<label for="question_1">Q1) :</label><span><input type="text" class="form-control" value="<?=$question['question_1']?>" id="question_1" name="question_1" required></span>
			      	<textarea class="dummy-input"  placeholder="Answer.."  readonly></textarea>	
			    </div>
			    <div class="tags">
			      	<label for="question_2">Q2) :</label><span><input type="text" class="form-control" value="<?=$question['question_2']?>" id="question_2" name="question_2" required></span>
					<textarea class="dummy-input"  placeholder="Answer.."  readonly></textarea>		
			    </div>
			    <div class="tags">
			      	<label for="question_3">Q3) :</label><span><input type="text" class="form-control" value="<?=$question['question_3']?>" id="question_3" name="question_3" required></span>
			      	<textarea class="dummy-input"  placeholder="Answer.."  readonly></textarea>		
			    </div>
			    <div class="tags">
			      	<label for="question_4">Q4) :</label><span><input type="text" class="form-control" value="<?=$question['question_4']?>" id="question_4" name="question_4" required></span>
			      	<textarea class="dummy-input"  placeholder="Answer.."  readonly></textarea>	
			    </div>
			    <div class="tags">
			      	<label for="question_5">Q5) :</label><span><input type="text" class="form-control" value="<?=$question['question_5']?>" id="question_5" name="question_5" required></span>
			      	<textarea class="dummy-input"  placeholder="Answer.."  readonly></textarea>		
			    </div>
			    <div class="tags">
			      	<label for="question_6">Q6) :</label><span><input type="text" class="form-control" value="<?=$question['question_6']?>" id="question_6" name="question_6" required></span>
			      	<textarea class="dummy-input"  placeholder="Answer.."  readonly></textarea>		
			    </div>
			</div>
			<div class="tags button">
				<div class="input"><button id="update" name="update-question-paper" >Update</button></div><span><div class="input"><button id="cancel" name="cancel">Cancel</button></div></span>
			</div>
		</form>
	</div>

<?php include'src/footer.php'; ?>
</body>
