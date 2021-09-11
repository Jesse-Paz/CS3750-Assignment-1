<?php

session_start();

if(!isset($_SESSION["userid"]) || $_SESSION["userid"] !== true) {
	header("location: login.php");
	exit;
}
?>
<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <title>Howdy <?php echo $_SESSION["name"]; ?></title>
    <link rel="stylesheet"/>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="cell">
				<h1>Hi, <strong><?php echo $_SESSION["name"]; ?></strong>. This is a cool page</h1>
			</div>
			<p>
				<a href="logout.php" class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">Log Out</a>
			</p>
		</div>
	</div>
</body>
</html>
