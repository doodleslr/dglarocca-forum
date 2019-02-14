<?php
require_once '../lib/configLib.php';

$target_dir = "../uploads/";
$target_file = $target_dir.basename($_FILES["imageUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if($_SERVER["REQUEST_METHOD"] == "POST"){
	if(isset($_POST['username'])){
		
		//image upload
		$check = getimagesize($_FILES["imageUpload"]["tmp_name"]);
		if($check !== false){
			echo "File is an image - ".$check["mime"].".";
			$uploadOk = 1;
		} else {
			echo "File is not an image";
			$uploadOk = 0;
		}
		
		if(file_exists($target_file)){
			echo "Sorry, file already exists with that name.";
			$uploadOk = 0;
		}
		
		if($_FILES["imageUpload"]["size"] > 5000000){
			echo "Sorry, image file size too large.";
			$uploadOk = 0;
		}
		
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif"){
			echo "sorry, only JPG, PNG and GIF files allowed.";
			$uploadOk = 0;
		}
		
		if($uploadOk == 0){
			echo "Sorry your file was not uploaded.";
		} else {
			if(move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $target_file)){
				echo "The file ".basename($_FILES["imageUpload"]["name"])." has been uploaded.";
			} else {
				echo "Sorry there was an error uploading your file.";
			}
		}
		//END image upload
		
		$date = date("Y-m-d h:i:s");
		
		$sql = 
		"INSERT INTO forum 
			('title', 'content', 'created_by', 'created_at', upvotes, downvotes, img_location)
		VALUES 
			(:title, :content, :created_by, :created_at, :upvotes, :downvotes, :img_location)";
			
		if($pdoRes = $pdo->prepare($sql)){
			$pdoRes->bindParam(':title', $param_title, PDO::PARAM_STR);
			$pdoRes->bindParam(':content', $param_content, PDO::PARAM_STR);
			$pdoRes->bindParam(':created_by', $param_by, PDO::PARAM_STR);
			$pdoRes->bindParam(':created_at', $param_at, PDO::PARAM_STR);
			$pdoRes->bindParam(':upvotes', $param_up, PDO::PARAM_INT);
			$pdoRes->bindParam(':downvotes', $param_down, PDO::PARAM_INT);
			$pdoRes->bindParam(':img_location', $param_img, PDO::PARAM_STR);
			
			$param_title = $_POST['title'];
			$param_content = $_POST['content'];
			$param_at = $date;
			$param_by = $_POST['username'];
			$param_up = $param_down = 0;
			$param_img = basename($_FILES["imageUpload"]["name"]);

			if($pdoRes->execute()){
				header("location: ../welcome.php");
			} else {
				echo "somethign went wrong for some raisins";
			}
		}
		unset($pdoRes);
	}
} else {
	echo "somethign went wrong for some raisins.";
}

?>