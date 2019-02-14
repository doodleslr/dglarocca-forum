<?php

session_start();

if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("location: login.php");
	exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>New Post</title>
    <?php include 'lib/head.php'; ?>
</head>
<body style="background-image: url(depot/final-beach.svg), url(depot/final-space-alt.svg);">
	<div class="wrapper ">
		<div class="post-title">
			<a href="welcome.php" class="btn btn-info font-lite">Back To Home</a>
			<hr>
			<h1 class="font-title"><?php echo $_SESSION['username'] ?>'s new post</h1>
		</div>

		<form action="scripts/submit-post.php" method="post" enctype="multipart/form-data">
			<input type="hidden" name="username" value="<?php echo $_SESSION['username'] ?>">
			<input type="text" name="title" class="form-control form-title" placeholder="Subject">
			<textarea name="content" class="form-control form-content" placeholder="Content"></textarea>
			
			<label class="font-main">Select an image to upload: </label>
			<input type="file" name="imageUpload" class="form-control">
			<div class="btn-control">
				<input type="submit" class="btn btn-success font-lite" value="Submit New Post">
				<input type="reset" class="btn btn-warning font-lite" value="Reset">
				<hr>
				<p><a href="welcome.php" class="btn btn-info font-lite">Back To Home</a></p>
			</div>
		</form>
	</div>
</body>
</html>