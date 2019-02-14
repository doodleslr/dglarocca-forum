<?php
require_once '../lib/configLib.php';

$value = $sql = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
	if(isset($_POST['postId'])){
		$value = $_POST['value'];
		$currentUser = $_POST['username'];
		
		$userQuery = 
		"SELECT 
			username, postId, vote
		FROM 
			userVotes 
		WHERE 
			postId = :postId";
		
		if($userCheck = $pdo->prepare($userQuery)){
			$userCheck->bindParam(':postId', $param_postId, PDO::PARAM_INT);
			
			$param_postId = $_POST['postId'];
			
			if($userCheck->execute()){
				$exists = $uniqueVote = "";
				while($obj = $userCheck->fetch(PDO::FETCH_ASSOC)):
					if($currentUser == $obj['username']){
						$exists = true;
						if($value == $obj['vote']){
							$uniqueVote = false;
						} else {
							$uniqueVote = true;
						}
					} else {
						$exists = false;
					}
				endwhile;
				
				if($exists){
					if($uniqueVote){
						//update vote tally
						if($value == 'true'){
							$sql = "UPDATE forum
							SET upvotes = upvotes + 1
							WHERE id = :postId";
						} else if($value == 'false'){
							$sql = "UPDATE forum
							SET downvotes = downvotes + 1
							WHERE id = :postId";
						}
						if($pdoResult = $pdo->prepare($sql)){
							$pdoResult->bindParam(':postId', $param_id, PDO::PARAM_INT);
							
							$param_id = $_POST['postId'];
							
							if($pdoResult->execute()){
								echo " updated vote tally, ";
							}
						}
						
						//update user vote choice
						$sql = "UPDATE userVotes
							SET vote = :value
							WHERE postId = :postId AND username = :currentUser";
						if($pdoResult = $pdo->prepare($sql)){
							$pdoResult->bindParam(':postId', $param_id, PDO::PARAM_INT);
							$pdoResult->bindParam(':currentUser', $currentUser, PDO::PARAM_STR);
							$pdoResult->bindParam(':value', $value, PDO::PARAM_STR);
							
							$param_id = $_POST['postId'];
							
							if($pdoResult->execute()){
								echo " updated user vote, ";
							}
						}
					}
				} else if(!$exists) {
					$userUpdate = $pdo->prepare(
						"INSERT INTO userVotes
							('username', 'postId', 'vote')
						VALUES 
							(:username, :postId, :vote)"
					);
					if($userUpdate){
						$userUpdate->bindParam(':username', $param_user, PDO::PARAM_STR);
						$userUpdate->bindParam(':postId', $param_postId, PDO::PARAM_INT);
						$userUpdate->bindParam(':vote', $param_vote, PDO::PARAM_STR);
						
						$param_user = $currentUser;
						$param_postId = $_POST['postId'];
						$param_vote = $value;
						
						if($userUpdate->execute()){
							echo " inserted new user, ";
						}
					}
					if($value == 'true'){
							$sql = "UPDATE forum
							SET upvotes = upvotes + 1
							WHERE id = :postId";
					} else if($value == 'false'){
							$sql = "UPDATE forum
							SET downvotes = downvotes + 1
							WHERE id = :postId";
					}
						
					if($pdoResult = $pdo->prepare($sql)){
						$pdoResult->bindParam(':postId', $param_id, PDO::PARAM_INT);
							
						$param_id = $_POST['postId'];
							
						if($pdoResult->execute()){
							echo " new user vote inserted, ";
						}
					}
				}
			}
		}
	}
	unset($pdo);
}
?>