<?php
require_once __DIR__ . '/includes/db.php';

$error = '';
$success = '';

// This block only runs when the form is submitted (POST).
// On a normal page visit (GET) it's skipped and we just show the empty form.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    if (!$name || !$email || !$password || !$password2) {
        $error = 'All fields are required.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif ($password !== $password2) {
        $error = 'Passwords do not match.';
    } else {
        // Prepared statement: the ? placeholders keep user input out of the SQL string,
        // which is what stops SQL injection.
        $stmt = mysqli_prepare($conn, 'SELECT id FROM users WHERE email = ?');
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $error = 'An account with that email already exists.';
        } else {
            $insert = mysqli_prepare($conn, 'INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)');
            mysqli_stmt_bind_param($insert, 'sss', $name, $email, $password);
            if (mysqli_stmt_execute($insert)) {
                $success = 'Account created! You can now log in.';
            } else {
                $error = 'Something went wrong. Please try again.';
            }
        }
    }
}
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
				<div class="field" style="flex:1">
					<label for="reg-pass2">Confirm</label>
					<input id="reg-pass2" name="password2" type="password" required>
				</div>
			</div>
			<div class="actions">
				<button type="submit" class="btn">Create account</button>
			</div>
			<?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
			<?php if ($success): ?><div class="success"><?= htmlspecialchars($success) ?></div><?php endif; ?>
		</form>

		<div class="note">Data is saved to the MySQL <code>jampol.users</code> table.</div>
	</div>
</body>
</html>
