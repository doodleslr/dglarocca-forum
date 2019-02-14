<?php 
require_once '../lib/configLib.php';

$delId = $_POST['id'];
if(isset($delId) && $delId > 0) {
	//delete record
	$delQuery = "DELETE FROM forum WHERE id=".$delId;
	$delResult = $pdo->prepare($delQuery);
	$delExec = $delResult->execute();
	
	if($delExec){
		echo 'ok';
	}else{
		echo 'error';
	}
	exit;
}
?>