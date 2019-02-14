<?php
require_once 'lib/configUser.php';

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$userTemp = $_POST["username"];
	if(empty(trim($userTemp))){
		$username_err = "Please enter a username";
	} else {
		$pdoQuery = "SELECT username FROM users WHERE username= :username";
		if($pdoResult = $pdo->prepare($pdoQuery)){
			$pdoResult->bindParam(':username', $param_username, PDO::PARAM_STR);
			
			$param_username = trim($userTemp);
			
			if($pdoResult->execute()){
				$check = false;
				while ($row = $pdoResult->fetch(PDO::FETCH_ASSOC)){
					if(trim($userTemp) == $row['username']){
						$check = true;
					} else {
						$check = false;
					}
				}
				if($check){
					$username_err = "This username already exists";
				} else {
					$username = trim($userTemp);
				}
			} else {
				echo "Oops somethign went wrong for some raisins. Please try again lates";
			}
		}
		unset($pdoResult);
	}
	
	//validates password
	$passTemp = $_POST["password"];
	if(empty(trim($passTemp))){
		$password_err = "Please enter a password";
	} elseif (strlen(trim($passTemp)) < 6) {
		$password_err = "Password must have at least 6 characters.";
	} else {
		$password = $passTemp;
	}
	
	//validates confirmed password
	$conTemp = $_POST["confirm_password"];
	if(empty(trim($conTemp))){
		$confirm_password_error = "Please confirm password.";
	} else {
		$confirm_password = trim($conTemp);
		if($confirm_password != $password){
			$confirm_password_err = "Password did not match.";
		}
	}

	if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
		
		$pdoQuery = "INSERT INTO users (username, password, family) VALUES (:username, :password, :family)";
		
		if($pdoResult = $pdo->prepare($pdoQuery)){
			
			$pdoResult->bindParam(':username', $param_username, PDO::PARAM_STR);
			$pdoResult->bindParam(':password', $param_password, PDO::PARAM_STR);
			$pdoResult->bindParam(':family', $param_admin, PDO::PARAM_STR);
			
			$param_username = $username;
			$param_password = password_hash($password, PASSWORD_DEFAULT);
			$param_admin = "admin";
			
			if($pdoResult->execute()){
				header("location: login.php");
			} else {
				echo "Somethign went wrong for some raisins. Pdo did not execute, needs more raisins.";
			}
		}
		unset($pdoResult);
	}
	unset($pdo);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Rego Administrator</title>
    <?php include 'lib/head.php'; ?>
</head>
<body style="background-image: url('depot/final-space.svg'), url(depot/final-mountain-alt.svg);">
    <div class="wrapper" id="wrap-main">
        <h2 class="font-title">Sign Up</h2>
        <p class="font-main">Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label class="font-main">Username:</label>
                <input type="text" name="username"class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label class="font-main">Password:</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label class="font-main">Confirm Password:</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="btn-control">
                <input type="submit" class="btn btn-primary font-lite" value="Submit">
                <input type="reset" class="btn btn-warning font-lite" value="Reset">
				<hr>
				<p class="font-main">Already have an account? <a href="login.php">Login here</a>.</p>
            </div>
        </form>
    </div>    
</body>
</html>