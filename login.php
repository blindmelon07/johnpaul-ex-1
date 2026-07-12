<?php
session_start();
require_once __DIR__ . '/includes/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
        $error = 'Please enter email and password.';
    } else {
        $stmt = mysqli_prepare($conn, 'SELECT id, full_name, password FROM users WHERE email = ?');
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        // Plain-text comparison for now (password_hash/verify is the next lesson).
        if ($user && $password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Invalid email or password.';
        }
    }
}
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
			<?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
		</form>

		<div class="note">Checks the email/password against MySQL.</div>
	</div>
</body>
</html>
