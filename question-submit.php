<?php require 'src/config.php'; ?>
<?php
	if ($_GET['submit'] != 'true'){
		header('Location: question.php?next=true');
		exit;
	}
?>
<?php  
	session_start();

	$examid = $_POST['student_examid'];
	$subject_code = $_POST['subject_code'];
	$answer_1 = $_POST['answer_1'];
	$answer_2 = $_POST['answer_2'];
	$answer_3 = $_POST['answer_3'];
	$answer_4 = $_POST['answer_4'];
	$answer_5 = $_POST['answer_5'];
	$answer_6 = $_POST['answer_6'];

	$sqlsq = "UPDATE `$subject_code` 
		SET `question_1` = '$answer_1', `question_2` = '$answer_2', `question_3` = '$answer_3', `question_4` = '$answer_4', `question_5` = '$answer_5', `question_6` = '$answer_6' 
		WHERE `$subject_code`.`student_examid` = '$examid';";

	$fire = mysqli_query($conn,$sqlsq) or die("cannnot access databse!".mysqli_error($conn));
	if ($fire) 
	{ 
		$_SESSION['next'] = NULL;
		header('Location: dashboard.php');
		$_SESSION['Success-answer-submit'] = true;
	}
	else
	{
		echo "<script>alert('Question cannot be updated Updated')</script>";	
	}

?>