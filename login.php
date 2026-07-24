<?php
session_start();
require_once __DIR__ . '/includes/db.php';

// $sql = "SELECT * FROM users WHERE username = ? AND password = ? "

/*if (isset($_POST["submit"])) {
           $email = $_POST["email"];
           $password = $_POST["password"];
        
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if ($user) {
                if (password_verify($password, $user["password"])) {
                  
                    $_SESSION["user"] = "yes";
                    header("Location: dashboard.php");
                    die();
                }else{
                    echo "<div class='alert alert-danger'>Password does not match</div>";
                }
            }else{
                echo "<div class='alert alert-danger'>Email does not match</div>";
            }
        }*/

//code here john paul bototo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $errors = 'Please fill in both email and password.';
    } else {
        $stmt = mysqli_prepare($conn, 'SELECT id, full_name, password FROM users WHERE email = ?');
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            header('Location: index.php');
            exit;
        }

        $errors = 'Invalid email or password.';
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

		<form action="login.php" method="post">
			<div class="field">
				<label for="login-email">Email</label>
				<input id="login-email" name="email" type="email" required autocomplete="username" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
			</div>
			<div class="field">
				<label for="login-pass">Password</label>
				<input id="login-pass" name="password" type="password" required autocomplete="current-password">
			</div>
			<div class="actions">
				<button type="submit" name="submit" class="btn">Sign in</button>
			</div>
		<div class="error"></div>
		</form>

		<div class="note">Checks the email/password against MySQL.</div>
	</div>
</body>
</html>
