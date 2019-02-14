<?php
require_once '../lib/configLib.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
	if(isset($_POST['username'])){
		
		$redirect = "location: ../view-post.php?post_id=".$_POST['page_id'];

		$date = date("Y-m-d h:i:s");
		
		$sql = 
		"INSERT INTO comment
			('post_id', 'content', 'created_by', 'created_at')
		VALUES 
			(:post_id, :content, :created_by, :created_at)";
			
		if($pdoRes = $pdo->prepare($sql)){
			$pdoRes->bindParam(':post_id', $param_id, PDO::PARAM_INT);
			$pdoRes->bindParam(':content', $param_content, PDO::PARAM_STR);
			$pdoRes->bindParam(':created_by', $param_by, PDO::PARAM_STR);
			$pdoRes->bindParam(':created_at', $param_at, PDO::PARAM_STR);
						
			$param_content = $_POST['comment'];
			$param_at = $date;
			$param_by = $_POST['username'];
			$param_id = $_POST['page_id'];

			if($pdoRes->execute()){
				header($redirect);
			} else {
				echo "somethign went wrong for some raisins";
			}
		}
		unset($pdoRes);
	}
}
?>