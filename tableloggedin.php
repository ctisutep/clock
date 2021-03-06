<!DOCTYPE html>
<html lang="en">

	<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>Employees logged in:</title>

		<!-- Bootstrap Core CSS -->
		<link href="css/bootstrap.css" rel="stylesheet">

		<!-- MetisMenu CSS -->
		<link href="css/metisMenu.css" rel="stylesheet">

		<!-- Timeline CSS -->
		<link href="css/timeline.css" rel="stylesheet">

		<!-- Custom CSS -->
		<link href="css/sb-admin-2.css" rel="stylesheet">

		<!-- Morris Charts CSS -->
		<link href="css/morris.css" rel="stylesheet">

		<!-- Tables CSS -->
		<link href="css/dataTables.css" rel="stylesheet">

		<!-- Custom Fonts -->
		<link href="font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->

	</head>

	<body>

		<div id="wrapper">

			<!-- Navigation -->
			<?php
				include ('navbar.php');
 ?>

			<div id="page-wrapper">

				<div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">Logged In Users</h1>
					</div>
					<!-- /.col-lg-12 -->
				</div>
				<!-- /.row -->

				<!-- /.row -->
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<table class="table table-striped" id="logged_in">
							<thead>
								<tr>
									<th>Name</th>
									<th>Date</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody id="usersin">
								<tr><td colspan="3">Loading...</td></tr>
							</tbody>
						</table>
					</div>

				</div>
				<!-- /.row -->
				<div id="sound"></div>
			</div>
			<!-- /#page-wrapper -->

		</div>
		<!-- /#wrapper -->

		<!-- jQuery -->
		<script src="js/jquery.js"></script>

		<!-- Bootstrap Core JavaScript -->
		<script src="js/bootstrap.js"></script>

		<!-- Metis Menu Plugin JavaScript -->
		<script src="js/metisMenu.js"></script>

		<!-- Morris Charts JavaScript -->
		<script src="js/raphael.js"></script>

		<!-- Custom Theme JavaScript -->
		<script src="js/sb-admin-2.js"></script>

		<!-- Tables JavaScript -->
		<script src="js/dataTables.js"></script>

		<script>
			function playSound(filename){
                document.getElementById("sound").innerHTML='<audio autoplay="autoplay"><source src="sound/' + filename + '.mp3" type="audio/mpeg" /><source src="sound/' + filename + '.ogg" type="audio/ogg" /><embed hidden="true" autostart="true" loop="false" src="sound/' + filename +'.mp3" /></audio>';
            }
			$(document).ready(function(){
				var usersIn = 0;
				$.post('tableinsource.php', {'usersin': true}, function(data){
					$('#usersin').html(data.html);
					usersIn = data.total;
					$('title').html('Employees in: ' + usersIn);
				});
				setInterval(function(){
					$.post('tableinsource.php', {'usersin': true}, function(data){
						$('#usersin').html(data.html);
						$('title').html('Employees in: ' + data.total);
						if(usersIn < data.total){
							playSound("in");
							usersIn = data.total;
						}
						else if(usersIn > data.total){
							playSound("out");
							usersIn = data.total;
						}
					});
					//setTimeout(getUsersIn(), );
				}, (500 * 60));//every 30 sec

			});
			$('#usersin').delegate('.kickout','click', function (e){
				e.preventDefault();
				var $row = $(this).closest('tr');
				var person = $(this).data('id');
				console.log(person);
				$.post('user.php', {'kickout': 'true', 'person': person}, function(){
					$row.remove();
				});

			});
		</script>

	</body>

</html>
