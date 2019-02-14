<?php
include_once 'lib/common.php';
require_once 'lib/configLib.php';

session_start();

if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("location: login.php");
	exit;
}

$postId = 0;
$row = NULL;
if (isset($_GET['post_id'])){
    $postId = $_GET['post_id'];
}

$sql = 'SELECT
		title, content, created_by, created_at, img_location
	FROM
		forum
	WHERE
		id= :id';

if($pdoRes = $pdo->prepare($sql)){
	$pdoRes->bindParam(':id', $param_id, PDO::PARAM_INT);
			
	$param_id = $postId;

	if($pdoRes->execute()){
		$row = $pdoRes->fetch(PDO::FETCH_ASSOC);
	}
}
if(!$row){
	echo "There was a problem retrieving this post for some raisins";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post | <?php echo htmlEsc($row['title']) ?></title>
    <?php include 'lib/head.php'; ?>

	<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
</head>
<body style="background-image: url(depot/final-beach.svg), url(depot/final-space-alt.svg);">
	<div class="wrapper ">
		<div class="post-title">
			<p><a href="welcome.php" class="btn btn-info font-lite">Back To Home</a></p>
			<hr>
			<h1 class="title font-title"><span><?php echo htmlEsc($row['title']) ?></span></h1>
		</div>
		<?php
			if(!empty($row['img_location'])){
				echo 
				"<div class='contentWrap'>
						<img class='content-img' src='uploads/".htmlEsc($row['img_location'])."
				'/></div>";
			}
		?>
		
		<form action="scripts/edit-submit.php" method="post">
				<input type="hidden" name="postId" value="<?php echo $postId ?>">
				<div class="contentWrap">
					<textarea type="text" name="edit" class="form-control form-edit font-main"><?php echo $row['content']?></textarea>
				</div>
				<div class="contentWrap">
					<span class="name font-lite"><i>By <?php echo htmlEsc($row['created_by'])?> At <?php echo htmlEsc($row['created_at']) ?></i></span>
				</div>

			<div class="btn-control">
				<input type="submit" class="btn btn-success font-lite" value="Submit Edit">
				<input type="reset" class="btn btn-warning font-lite" value="Reset">
				<p class='del-button btn btn-danger font-lite' id='del<?php echo $postId ?>')>Delete Post</p>
				<hr>
				<p><a href="welcome.php" class="btn btn-info font-lite">Back To Home</a></p>
			</div>
		</form>
		<div id="deleteBox">
			<div class="delete-content">
				<p class="font-main">Are you sure you want to delete your post?</p>
				<p style="float:left;" id="delete"><a href="#" class="btn btn-danger font-lite">Yes, delete it</a></p>
				<p style="float:right;" id="keep"><a href="#" class="btn btn-default font-lite">No, keep it</a></p>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="js/edit.js"></script>
</body>
</html>

















