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
	echo "There was a problem running this query for some raisins";
}

//fetches comments for post	
$comment = $pdo->query('SELECT content, created_by, created_at FROM comment WHERE post_id= '.$postId);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forum | <?php echo htmlEsc($row['title']) ?></title>
	<?php include 'lib/head.php'; ?>
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
		<div class="contentWrap">
			<p class="content font-main"><?php echo nl2br(htmlEsc($row['content']))?></p>
		</div>
		<div class="contentWrap">
			<span class="name font-lite"><i>By <?php echo htmlEsc($row['created_by'])?> At <?php echo htmlEsc($row['created_at']) ?></i></span>
		</div>
		
		<hr>
		<!--COMMENTS-->
			<h4 class="font-title"><span>Comments</span></h4>
		<?php 
			$check = false;
			while($item = $comment->fetch(PDO::FETCH_ASSOC)):?>		
				<div class="contentWrap comment">
					<p class="font-main"><?php echo nl2br(htmlEsc($item["content"]))?></p>
						<span class="name font-lite"><i>By <?php echo htmlEsc($item["created_by"]).' at '.htmlEsc($item["created_at"])?></i></span>
				</div>
				<?php $check = true;
			endwhile;
			if(!$check){?>
				<p class="font-title"><span>Be the first to comment</span></p>
			<?php }	?>

	</div>
	<div class="wrapper">
		<form action="scripts/submit-comment.php" method="post">
				<input type="hidden" name="username" value="<?php echo $_SESSION['username'] ?>">
				<input type="hidden" name="page_id" value="<?php echo $postId ?>">
				
				<textarea type="text" name="comment" class="form-control form-comment" placeholder="Leave a comment here."></textarea>

			<div class="btn-control">
				<input type="submit" class="btn btn-success font-lite" value="Submit Comment">
				<input type="reset" class="btn btn-warning font-lite" value="Reset">
				<hr>
				<p><a href="welcome.php" class="btn btn-info font-lite">Back To Home</a></p>
			</div>
		</form>
	</div>
</body>
</html>