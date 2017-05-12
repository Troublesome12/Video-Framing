<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Video</title>

	<!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/app.css'); ?>" rel="stylesheet">
    <!-- Fonts -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">

    <style>
    	form {
    		margin-top: 50px;
    	}
    </style>
</head>
<body>
	<div class="container">
		<form action="<?php echo base_url('home'); ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
			<div class="col-md-10">
				<input type="file" name="file" class="form-control">
			</div>
			<div class="col-md-2">
				<input type="submit" name="submit" class="btn btn-success">
			</div>
		</form>
	</div>

	<?php

	/*
	FFmpeg Commands
		-i Input File Name
		-an Disabled Audio
		-ss GET Image FROM X Seconds Of The Video
		-s Size Of The Image
	*/

	if(isset($_POST['submit'])) {
		$ffmpeg = "D:\\ffmpeg\\bin\\ffmpeg";
		$videoFile = $_FILES["file"]["tmp_name"];
		$size = "1024x800";
		$interval = 5;
		$imagePath = 'assets/img/';

		for($num=0;$num<30;$num++){
			$interval =  $interval + 0.1;
			$cmd = "$ffmpeg -i $videoFile -an -ss $interval -s $size $imagePath$num.jpg";
			shell_exec($cmd);
			echo "Image Created: $num.jpg<br>";
		}
	}

 	?>

 	<script>
        var base_url = '<?php echo base_url(); ?>';
    </script>

    <script src="<?php echo base_url('assets/js/jquery-1.11.3.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/app.js'); ?>"></script>
</body>
</html>