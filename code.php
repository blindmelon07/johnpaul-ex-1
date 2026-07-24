<?php 
session_start();
require_once __DIR__ . '/includes/db.php';





if(isset($_POST['delete_user']))
{
    $user_Id = mysqli_real_escape_string($conn, $_POST['delete_user']);

    $query = "DELETE FROM users WHERE id='$user_Id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['message'] = "User Deleted Successfully";
        header("Location: index.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "User Not Deleted";
        header("Location: index.php");
        exit(0);
    }
}

// Update User
if(isset($_POST['update_user']))
{
   $user_id = $_POST['id'];
    $fname   = $_POST['full_name'];
    $email   = $_POST['email'];
    $password = $_POST['password'];

    // Hash password before saving
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $query = "UPDATE users 
              SET full_name='$fname', 
                  email='$email', 
                  password='$hashedPassword' 
              WHERE id='$user_id'";

    if (mysqli_query($conn, $query)) {
         $_SESSION['message'] = "User Updated Successfully";
        header("Location: index.php");
        exit(0);
    } else {
        $_SESSION['message'] = "User Not Updated";
        header("Location: index.php");
        exit(0);
    }
}
   

if(isset($_POST['save_user']))
{
    $fname = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
  

    $query = "INSERT INTO users (full_name, email, password) VALUES ('$fname','$email','$password')";

    $query_run = mysqli_query($conn, $query);
    if($query_run)
    {
        $_SESSION['message'] = "User Created Successfully";
        header("Location: add.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "User Not Created";
        header("Location: add.php");
        exit(0);
    }
}

?>