<?php
session_start();

// Guard clause: bounce anyone who isn't logged in back to the login page.
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Dashboard</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="wrap">
		<h2>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?></h2>
		<p class="note">You are logged in. This page is only reachable with an active session.</p>
		<div class="actions">
			<a class="btn" href="logout.php" style="text-decoration:none">Log out</a>
		</div>
	</div>
</body>
</html>
