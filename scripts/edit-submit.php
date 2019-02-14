<?php
require_once '../lib/configLib.php';

$date = date("Y-m-d h:i:s");

if($_SERVER["REQUEST_METHOD"] == "POST"){
	if(isset($_POST['postId'])){
		if(!empty($_POST['edit'])){
			$sql = "UPDATE forum
				SET content = :edit, created_at = :date
				WHERE id = :postId";
		} else {
			echo "Sorry, you can't submit an empty edit.";
		}
	} else {
		echo "Sorry, you cannot edit this post.";
	}
	if($pdoResult = $pdo->prepare($sql)){
		$pdoResult->bindParam(':postId', $param_id, PDO::PARAM_INT);
		$pdoResult->bindParam(':edit', $param_edit, PDO::PARAM_STR);
		$pdoResult->bindParam(':date', $param_date, PDO::PARAM_STR);
		
		$param_id = $_POST['postId'];
		$param_edit = $_POST['edit'];
		$param_date = $date;
		
		if($pdoResult->execute()){
			header("location: ../welcome.php");
		} else {
			echo "Something went wrong for some raisins.";
		}
	}
	unset($pdo);
}
?>