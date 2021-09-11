<?php

require_once "config.php";
require_once "session.php";

$error = '';
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])){
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	
	if(empty($email)){
		$error .= '<p class ="error">Please enter your email.</p>';
	}
	if(empty($password)){
		$error .= '<p class ="error">Please enter your password.</p>';
	}
	
	if(empty($error)){
		if($query = $db->prepare("SELECT * FROM Users WHERE email = ?")){
			$query->bind_param('s', $email);
			$query->execute();
			 $row = $query->fetch();
			 if($row){
				 if(password_verify($password, $row['Password'])){
					 $_SESSION["userid"] = $row['id'];
					 $_SESSION["user"] = $row;
					 
					 header("location: index.php");
					 exit;
				 } else {
					 $error .= '<p class ="error">The password is not valid</p>';
				 } 
			 } else {
				 $error .= '<p class ="error">No user with the email.</p>';
			 }
		}
		$query->close();
	}
	mssql_close($db);
}
?>
<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet"/>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="cell">
                <h1>Login</h1>
                <p>Enter email and password</p>
                <form action="" method="post">
                    <div class="group">
                        <label>Email</label>
                        <input type="email" name="email" class="control" required />
                    </div>
                    <div class="group">
                        <label>Password</label>
                        <input type="text" name="password" class="control" required />
                    </div>
                    <div class="group">
                        <input type="submit" name="submit" class="btn btn-primary" value="Submit" >
                    </div>
                    <p>Need an account? <a href="login.php">Create new account here.</a></p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>