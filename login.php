<?php
require_once 'lib/configUser.php';

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$userTemp = $_POST["username"];
	if(empty(trim($userTemp))){
		$username_err = "Please enter a username";
	} else {
		$username = trim($userTemp);
	}
	
	$passTemp = $_POST["password"];
	if(empty(trim($passTemp))){
		$password_err = "Please enter a password";
	} else {
		$password = $passTemp;
	}
	
	if(empty($username_err) && empty($password_err)){
		$pdoSelect = 'SELECT username, password, family FROM users WHERE username = :username';
		
		if($pdoResult = $pdo->prepare($pdoSelect)){
			$pdoResult->bindParam(':username', $param_username, PDO::PARAM_STR);
			
			$param_username = $username;

			if($pdoResult->execute()){
				$check = false;
				$family = "";
				while($row = $pdoResult->fetch(PDO::FETCH_ASSOC)){
					if($username == $row['username']){
						$check = true;
						$hashed_password = $row['password'];
						$family = $row['family'];
					} else {
						$check = false;
					}
				}
				if($check){
					if(password_verify($password, $hashed_password)){
						session_start();
						$_SESSION['username'] = $username;
						$_SESSION['family'] = $family;
						header("location: welcome.php");
					} else {
						$password_err = "The password you have entered is invalid";
					}
				} else {
					$username_err = "That user does not exist.";
				}
			} else {
				echo "Something went wrong for some raisins";
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
    <title>Login</title>
	<?php include 'lib/head.php'; ?>
</head>
<body style="background-image: url('depot/final-space.svg'), url('depot/final-mountain-alt.svg');">
    <div class="wrapper"id="wrap-main">
        <h2 class="font-title">Login</h2>
        <p class="font-main">Please fill your details to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label class="font-main">Username:</label>
                <input type="text" name="username"class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label class="font-main">Password:</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="btn-control">
                <input type="submit" class="btn btn-primary font-lite" value="Submit">
				<hr>
				<p class="font-main">Don't have an account? <a href="register.php">Register here</a>.</p>
            </div>
            
        </form>
    </div>    
</body>
</html>