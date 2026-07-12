<?php
require_once __DIR__ . '/includes/db.php';

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

		<form method="post" novalidate>
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
				<button type="submit" class="btn">Create account</button>
			</div>
			<div class="error"></div>
			<div class="success"></div>
		</form>

		<div class="note">Data is saved to the MySQL <code>jampol.users</code> table.</div>
	</div>
</body>
</html>
