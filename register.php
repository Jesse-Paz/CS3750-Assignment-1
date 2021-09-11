<?php

require_once "config.php";
require_once "session.php";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])){
	$firstname = trim($_POST['firstname']);
	$lastname = trim($_POST['lastname']);
	$password = trim($_POST['password']);
	$confirm_password = trim($_POST["confirm_password"];
	$password_hash = password_hash($password, PASSWORD_BCRYPT);
	$email = trim($_POST['email']);
	$birthdate = trim($_POST['birthdate']);
	
	if($query = $db->prepare(SELECT * FROM users WHERE email = ?)){
		$error = '';
		
		$query ->bind_param('s', $email);
		$query->execute();
		$query->store_result();
		
		if($query->num_rows > 0){
			$error .= '<p class="error">The email address is already associated with an account!</p>';
		} else {
			if(strlen($password) < 6){
				$error .= '<p class="error">Password must be a minimum of 6 characters</p>';
			}
			
			if(empty($confirm_password)){
				$error .= '<p class="error">Must confirm password</p>';
			} else {
				if(empty($error) && ($password != $confirm_password)){
					$error .= '<p class="error">Paswords must match</p>';
				}
			}
			
			if(empty($error)){
				$insertQuery = $db->prepare("INSERT INTO Users (firstname, lastname, email, password, birthdate) VALUES (?,?,?,?,?);");
				$insertQuery = bind_param("sss", $firstname, $lastname, $email, $password, $birthdate);
				$result = $insertQuery->execute();
				if($result){
					$error .= '<p class="error">Account created!</p>';
				} else {
					$error .= '<p class="error">Something went wrong!</p>';
				}
			}
		}
	}
	$query->close();
	$insertQuery->close();
	mssql_close($db);
}
?>
<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <title>Create Account</title>
    <link rel="stylesheet"/>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="cell">
                <h1>Create New Account</h1>
                <p>If you do not have an account fill out this form.</p>
                <form action="" method="post">
                    <div class="group">
                        <label>Email</label>
                        <input type="email" name="email" class="control" required />
                    </div>
                    <div class="group">
                        <label>First Name</label>
                        <input type="text" name="firstname" class="control" required />
                    </div>
                    <div class="group">
                        <label>Last Name</label>
                        <input type="text" name="lastname" class="control" required />
                    </div>
                    <div class="group">
                        <label>Password</label>
                        <input type="text" name="password" class="control" required />
                    </div>
                    <div class="group">
                        <label>Confirm Password</label>
                        <input type="text" name="confirm_password" class="control" required />
                    </div>
                    <div class="group">
                        <label>Birthdate</label>
                        <input type="text" name="birthdate" class="control" required />
                    </div>
					<div class="group">
						<input type="submit" name="submit" class="btn btn-primary" value="Submit">
					</div>
                    <p>For Existing Accounts <a href="login.php">Login Here.</a></p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>