<?php
require_once __DIR__ . '/includes/db.php';

if(isset($_POST["submit"])){
	$fullName = $_POST["full_name"];
	$email	  = $_POST["email"];
	$password = $_POST["password"];
	$password2 = $_POST["password2"];
	
	$passwordhash = password_hash($password, PASSWORD_DEFAULT);
	$errors = array();

	if (count($errors)>0){
		foreach ($errors as $error){
			echo "<div class='alert alert-danger'>$error</div>";
		}
	} else{
		//insert the data into database
		$sql = "INSERT INTO users (full_name, email, password) VALUES ( ?, ?, ? )";
		$stmt = mysqli_stmt_init($conn);
		$prepareStmt = mysqli_stmt_prepare($stmt,$sql);
		if ($prepareStmt){
			mysqli_stmt_bind_param($stmt,"sss", $fullName, $email, $passwordhash);
			mysqli_stmt_execute($stmt);
			echo "<div class='alert alert-succes'>You are registered successfully.</div>";
		}else{
			die("Something went wrong");
		}
	}
}
//code here john paul bototo
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Register</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrap">

		<h2>Account</h2>
		<div class="tabs">
			<a href="login.php">Login</a>
			<a href="register.php" class="active">Register</a>
		</div>
		<form action="register.php" method="post">
			<div class="field">
				<label for="reg-name">Full name</label>
				<input id="reg-name" name="full_name" type="text" required value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>">
			</div>
			<div class="field">
				<label for="reg-email">Email</label>
				<input id="reg-email" name="email" type="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
			</div>
			<div class="row">
				<div class="field" style="flex:1">
					<label for="reg-pass">Password</label>
					<input id="reg-pass" name="password" type="password" required>
				</div>
				<div class="field" style="flex:2">
					<label for="reg-pass2">Confirm</label>
					<input id="reg-pass2" name="password2" type="password" required>
				</div>
			</div>
			<div class="actions">
				<button type="submit" name="submit" class="btn">Create account</button>
			</div>
			<div class="error"></div>
			<div class="success"></div>
		</form>

		<div class="note">Data is saved to the MySQL <code>jampol.users</code> table.</div>
	</div>
</body>
</html>
