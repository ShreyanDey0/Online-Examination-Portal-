<?php  
	require 'src/config.php';
?>
<?php
	session_start();

	if (!isset($_SESSION['next'])) {
		header('Location: dashboard.php');
		exit;
	}

	if ($_GET['next'] != 'true'){
		header('Location: dashboard.php');
		exit;
	}
	$examid = $_SESSION['student_examid'];
	$subject_code = $_SESSION['subject_code'];
	$sqid = $_SESSION['question_id'];
?>
<?php 
	$sql = "SELECT * FROM question WHERE subject_code = '$subject_code' AND question_id = '$sqid'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
  		
  		$question = $result->fetch_assoc();
	} 
	else {
  		echo "Warning data cannot be fetched! : ". mysqli_error($conn);
	}
?>




<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Question-<?=$subject_code?></title>
	<link rel="shortcut icon" href="images/book_logo.png">

	<link rel="stylesheet" type="text/css" href="style/question.css">

	<script type="text/javascript" src="jquery/dashboard.js"></script>	
	<script src="jquery/jquery.js"></script>

	

</head>
<body onload="timeout()" onclick="openFullscreen()">
	<?php include 'src/header.php'; ?>


	<div class="question-paper">
		<div class="header-question">
			<div class="logo center-column">
				<img src="images/book_logo.png">
			</div>
			<h1>Online Examination Portal- Question Paper</h1>
			<hr>
		</div>
		<form id="answer-form" action="question-submit.php?submit=true" method="POST">
			<div class="nav">
				<div class="tags center-column">
					<label for="subject_code">Paper code : </label><span><input type="text" id="subject_code" name="subject_code" value="<?=$question['subject_code']?>" readonly></span>
				</div>
		    	<div class="tags center-column">
		      		<label for="subject_name">Paper Name : </label><span><input type="text" class="form-control" value="<?=$question['subject_name']?>" id="subject_name" name="subject_name" readonly></span>	
		    	</div>
		    	<div class="double-column">
			    	<div class="tags center-column">
			      		<label for="semester">Semester : </label><span><input type="number" class="form-control" value="<?=$question['semester']?>" id="semester" name="semester" readonly></span>	
			    	</div>
			    	<div class="tags center-column">
			      		<label for="stream">Stream : </label><span><input type="text" class="form-control" value="<?=$question['stream']?>" id="stream" name="stream" readonly></span>	
			    	</div>
			    </div>
		    	<div class="double-column">  
		    		<div class="tags center-column">
		      			<label for="time">Time(Mins): </label><span><b id="timer">TimeOut</b></span>	
		    		</div>
		    		<div class="tags center-column">
		      			<label for="fullmarks">Full Marks : </label><span><input type="number" class="form-control" value="<?=$question['fullmarks']?>" id="fullmarks" name="fullmarks" readonly></span>	
		    		</div>
		    	</div>
		    	<div class="tags center-column">
		      		<label for="student_examid">Exam-Id : </label><span><input type="text" class="form-control" value="<?=$examid?>" id="student_examid" name="student_examid" readonly></span>	
		    	</div>
		    	<h2 class="center-column">Note**: Once You Submit the Question-paper,<br>
		    		You cannot resubmit it again.
		    		<br>***If you close this tab, Your paper will be automatically submited.
		    		<br>****Do not try to cheat during the test.
		    	</h2>
		    	<hr style="margin: 9px 25px;">
			</div>
			<div class="question">
				<h2 class="center-column"><u>Answer any 5 Question:-</u></h2>
				<div class="tags">
			      	<label for="question_1">Q1) :</label><span style="margin: 5px; font-weight: lighter; font-size: 20px;"><?=$question['question_1']?></span>
			      	<textarea class="dummy-input" name="answer_1"  placeholder="Answer.." ></textarea>	
			    </div>
			    <div class="tags">
			      	<label for="question_2">Q2) :</label><span style="margin: 5px; font-weight: lighter; font-size: 20px;"><?=$question['question_2']?></span>
					<textarea class="dummy-input" name="answer_2"  placeholder="Answer.." ></textarea>		
			    </div>
			    <div class="tags">
			      	<label for="question_3">Q3) :</label><span style="margin: 5px; font-weight: lighter; font-size: 20px;"><?=$question['question_3']?></span>
			      	<textarea class="dummy-input" name="answer_3" placeholder="Answer.." ></textarea>		
			    </div>
			    <div class="tags">
			      	<label for="question_4">Q4) :</label><span style="margin: 5px; font-weight: lighter; font-size: 20px;"><?=$question['question_4']?></span>
			      	<textarea class="dummy-input" name="answer_4" placeholder="Answer.." ></textarea>	
			    </div>
			    <div class="tags">
			      	<label for="question_5">Q5) :</label><span style="margin: 5px; font-weight: lighter; font-size: 20px;"><?=$question['question_5']?></span>
			      	<textarea class="dummy-input" name="answer_5" placeholder="Answer.." ></textarea>		
			    </div>
			    <div class="tags">
			      	<label for="question_6">Q6) :</label><span style="margin: 5px; font-weight: lighter; font-size: 20px;"><?=$question['question_6']?></span>
			      	<textarea class="dummy-input" name="answer_6" placeholder="Answer.." ></textarea>		
			    </div>
			</div>
			<div class="tags button">
				<div class="input"><button id="submit-question-paper" name="submit-question-paper" >Submit</button></div>
			</div>
		</form>
	</div>


	<?php include 'src/footer.php'; ?>


	<script type="text/javascript">

		var elem = document.documentElement;
		
		function openFullscreen() {
		  	if (elem.requestFullscreen) 
		  	{
		    	elem.requestFullscreen();
		  	} 
		  	else if (elem.webkitRequestFullscreen)
		  	{
		    	elem.webkitRequestFullscreen();
		 	}
		 	else if (elem.msRequestFullscreen) 
		 	{
		    	elem.msRequestFullscreen();
		  	}
		}

		document.onkeydown=function(event) {
			if (event.keyCode == 116) {
				event.preventDefault();
			}
		}


	</script>


	<script type="text/javascript">
		if (sessionStorage.getItem("time")){
			if (sessionStorage.getItem("time") == 0) {
				var timeleft = <?=$question['time']*60?>;	
			}
			else{
				var timeleft = sessionStorage.getItem("time");
			}
		}
		else{
			var timeleft = <?=$question['time']*60?>;
		}

		function timeout(){
			var min = Math.floor(timeleft/60);
			var sec = timeleft % 60;
			var min = timeformat(min);
			var sec = timeformat(sec);
			if (timeleft <= 0){
				clearTimeout(tm);
				document.getElementById("answer-form").submit();
				alert('Sorry Timeout');

			}
			else{
				document.getElementById("timer").innerHTML = min + ":" + sec;
			}
			timeleft--;
			sessionStorage.setItem("time", timeleft);
			var tm = setTimeout(function(){timeout();}, 1000);
		}
		function timeformat(ts){
			if(ts < 10){
				return ts = "0" + ts;
			}else{
				return ts;
			}
		}
	</script>


</body>