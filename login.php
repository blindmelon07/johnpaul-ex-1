<?php
session_start();
require_once __DIR__ . '/includes/db.php';

//code here john paul bototo
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Login</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrap">
		<h2>Account</h2>
		<div class="tabs">
			<a href="login.php" class="active">Login</a>
			<a href="register.php">Register</a>
		</div>

		<form method="post" novalidate>
			<div class="field">
				<label for="login-email">Email</label>
				<input id="login-email" name="email" type="email" required autocomplete="username" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
			</div>
			<div class="field">
				<label for="login-pass">Password</label>
				<input id="login-pass" name="password" type="password" required autocomplete="current-password">
			</div>
			<div class="actions">
				<button type="submit" class="btn">Sign in</button>
			</div>
		<div class="error"></div>
		</form>

		<div class="note">Checks the email/password against MySQL.</div>
	</div>
</body>
</html>
