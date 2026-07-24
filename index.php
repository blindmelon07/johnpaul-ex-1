<?php
require_once __DIR__ . '/includes/db.php';
session_start();


// Check if user is logged in. Guard clause: bounce anyone who isn't logged in back to the login page.
if (!isset($_SESSION['user_id'])) {
header('Location: login.php');
exit;
}

?>

<!DOCTYPE html>
<html>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>User Details</title>
</head>
<body>
    
    <h3>Welcome, <?php echo $_SESSION['user_name']; ?>!</h3>
    
  
    <div class="container mt-4">

        <?php include('message.php'); ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a href="logout.php" class="btn btn-primary float-end">Log out</a>

                        <h4>User Details
                            <a href="add.php" class="btn btn-primary float-end">Add User</a>
                        </h4>
                    </div>
                    
                    <div class="card-body">

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $query = "SELECT * FROM users";
                                    $query_run = mysqli_query($conn, $query);

                                    if(mysqli_num_rows($query_run) > 0)
                                    {
                                        foreach($query_run as $user)
                                        {
                                            ?>
                                            <tr>
                                                <td><?= $user['id']; ?></td>
                                                <td><?= $user['full_name']; ?></td>
                                                <td><?= $user['email']; ?></td>
                                                
                                              
                                                <td>
                                                 
                                                    <a href="edit.php?id=<?= $user['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                                    <form action="code.php" method="POST" class="d-inline">
                                                        <button type="submit" name="delete_user" value="<?=$user['id'];?>"
                                                        class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                    
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        echo "<h5> No Record Found </h5>";
                                    }
                                ?>
                                
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
                                    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
<?php
$conn->close();
?>