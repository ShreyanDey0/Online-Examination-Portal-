<?php  
	require 'src/config.php';
?>
<?php
	session_start();

	if (!isset($_SESSION['view-answer'])) {
		header('Location: dashboard-teacher.php');
		exit;
	}

	if ($_GET['status'] != 'true'){
		header('Location: dashboard-teacher.php');
		exit;
	}
	$vid = $_SESSION['vid'];	
	$vid = strtolower($vid);
	$qid = $_SESSION['qid'];
?>
<?php 

	$sql = "SELECT * FROM question WHERE question_id = '$qid' AND subject_code = '$vid'";
	$fire =  mysqli_query($conn,$sql) or die("cannnot access databse!".mysqli_error($conn));

	$question = mysqli_fetch_assoc($fire);	

?>
<?php  

	if (isset($_POST["close"]) == true){
		$_SESSION['view-answer'] = NULL;
		header('Location: dashboard-teacher.php');
	}

?>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Answer-<?=$vid?></title>
	<link rel="shortcut icon" href="images/book_logo.png">

	
	<link rel="stylesheet" type="text/css" href="style/table.css">
</head>
<body>
	<?php include'src/header.php'; ?>
	<h2 style="text-align: center;"> Answer Table of <?=$vid?>: </h3>
	<hr style="margin: 3px 20px;">
	<div class="answer-table">	
		<table class="table-main" id="answer-table">
    		<thead class="thead-dark">
			    <tr>
					<th>Student Name</th>
					<th>Exam ID</th>
					<th>College Id</th>
					<th>Stream</th>
					<th>Roll Number</th>
					<th><?=$question['question_1'];?></th>
					<th><?=$question['question_2'];?></th>
					<th><?=$question['question_3'];?></th>
					<th><?=$question['question_4'];?></th>
					<th><?=$question['question_5'];?></th>
					<th><?=$question['question_6'];?></th>
				</tr>
			</thead>
			<tbody id="myTable" class="myTable">
				<?php
					$sqlq = "SELECT * FROM `$vid`";
					$fire =  mysqli_query($conn,$sqlq) or die("cannnot access databse!".mysqli_error($conn));

					if (mysqli_num_rows($fire) > 0)
					{
						while ($answer = mysqli_fetch_assoc($fire)) 
						{
							?>
												
							<tr>
								<td><?=$answer['student_name']?></td>
								<td><?=$answer['student_examid'] ?></td>
								<td><?=$answer['student_collegeid']?></td>
								<td><?=$answer['stream']?></td>
								<td><?=$answer['rollnumber']?></td>
								<td><?=$answer['question_1']?></td>
								<td><?=$answer['question_2']?></td>
								<td><?=$answer['question_3']?></td>
								<td><?=$answer['question_4']?></td>
								<td><?=$answer['question_5']?></td>
								<td><?=$answer['question_6']?></td>

							</tr>

							<?php
						}	
					}
				?>
			</tbody>
		</table>
	</div>	
		<div style="text-align: center;">
			<input type="button" id="btnExport" value="Export Table As PDF" onclick="Export()" />
			<span><div class="input"><form action="<?php $_SERVER['PHP_SELF']?>" method = "POST" ><button id="close" name="close">&#9747;Close</button></form></div></span>
		</div>
	<?php include'src/footer.php'; ?>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script type="text/javascript">
        function Export() {
            html2canvas(document.getElementById('answer-table'), {
                onrendered: function (canvas) {
                    var data = canvas.toDataURL();
                    var docDefinition = {
                        content: [{
                            image: data,
                            width: 500
                        }]
                    };
                    pdfMake.createPdf(docDefinition).download("<?=$vid?>.pdf");
                }
            });
        }
    </script>
</body>