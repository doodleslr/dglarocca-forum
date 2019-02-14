<?php
include_once 'lib/common.php';
require_once 'lib/configLib.php';

session_start();

$user = $_SESSION['username'];
if(!isset($user) || empty($user)){
	header("location: login.php");
	exit;
}
$family = false;
if($_SESSION['family'] == 'admin'){
	$family = true;
}

$stmt = $pdo->query(
	'SELECT
		id, title, content, created_by, created_at, upvotes, downvotes, img_location, upvotes - downvotes as score
	FROM
		forum
	ORDER BY score DESC'
);

$rowArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(!$stmt){
	echo "There was a problem running this query for some raisins";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Welcome</title>
    <?php include 'lib/head.php'; ?>

	<script src="https://code.jquery.com/jquery-3.2.1.js"  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
  	<script type="text/javascript">
  		var session = '<?php echo json_encode($user) ?>';
 	</script>
</head>
<body style="background-image: url(depot/final-mountain.svg), url(depot/final-beach-alt.svg);">
	<div class="wrapper ">
		<div class="page-header">
			<h1 class="title font-title"><span>Hi, <b><?php echo $_SESSION['username']; ?></b>. Welcome to our site.</span></h1>
		</div>
			<p class="welcome-btn" style="float: left;" id="signout"><a style="color: #a82424; text-shadow: 0 1px 1px rgba(0,0,0,0.2);" href="#" class="btn btn-default font-lite">Sign Out</a></p>
			<p class="welcome-btn" style="float: right;" ><a href="new-post.php" class="btn btn-success font-lite">Create A New Post</a></p>
		<ol class="list-actual">
			<?php
				foreach($rowArray as $row) {
					$img = "#";
					$full = "";
					$class = "";
					if(!empty($row['img_location'])){
						$img = "uploads/".htmlEsc($row['img_location']);
						$full = "<img class='sml-img' src='".$img."'/>";
					}
					if($row['created_by'] == $user){
						$class = "action";
					} else if($family){
						$class = "action";
					}?>
					<li class='item <?php echo $class ?>' id='<?php echo $row['id']?>'>
					<div class='holder-img'>
						<?php echo $full ?>
					</div>
					<a class='list-link' href='view-post.php?post_id=<?php echo $row['id']?>'></a>
					<div class='holder-arrows' id='vote-<?php echo $row['id']?>'>
					<p class='score font-lite'><?php echo $row['score']?></p>
						<a class='arrow-up'></a>
						<a class='arrow-down'></a>
					</div>
					<div class='holder-title'>
						<h4 class='title font-title'><?php echo htmlEsc($row['title'])?></h4>
						<p class='name font-lite'><i>by <?php echo htmlEsc($row['created_by'])." at ".htmlEsc($row['created_at'])?></i></p>	
					</div>
						<p class='holder-content font-main'><?php echo nl2br(htmlEsc($row['content']))?></p>
						<div class='edit-content'>
							<p><a href='edit-post.php?post_id=<?php echo $row['id']?>' class='btn btn-xs btn-info font-lite'>Edit Post</a>
							<p class='del-button' id='del<?php echo $row['id']?>')><a href='#' class='btn btn-xs btn-warning font-lite'>Delete Post</a></p>
						</div>
					</li>
			<?php }?>
		</ol>
		<hr>
		<div id="confirmBox">
			<div class="confirm-content">
				<p class="font-main">Are you sure you want to logout?</p>
					<p class="welcome-btn" style="float:left;"><a href="logout.php" class="btn btn-danger font-lite">Sign Out</a></p>
					<p class="welcome-btn" style="float:right;" id="stay"><a href="#" class="btn btn-default font-lite">No keep me logged in</a></p>
			</div>
		</div>
		<div id="deleteBox">
			<div class="delete-content">
				<p class="font-main">Are you sure you want to delete your post?</p>
					<p class="welcome-btn" style="float:left;" id="delete"><a href="#" class="btn btn-danger font-lite">Yes, delete it</a></p>
					<p class="welcome-btn" style="float:right;" id="keep"><a href="#" class="btn btn-default font-lite">No, keep it</a></p>
			</div>
		</div>
		<p class="welcome-btn" style="float: right;" ><a href="new-post.php" class="btn btn-success font-lite">Create A New Post</a></p>
	</div>
	<script type="text/javascript" src="js/main.js"></script>
</body>
</html>



















