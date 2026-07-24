<?php
session_start();
require_once __DIR__ . '/includes/db.php';

if(isset($_POST["add-user"])){
	$fullName = $_POST["full_name"];
	$email	  = $_POST["email"];
	$password = $_POST["password"];
	
	
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
		
		}else{
			die("Something went wrong");
		}
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
    <div class="container mt-5">
        
        <?php include('message.php'); ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4> Add User 
                             <a href="index.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
                            
                      
                    </div>
                    <div class="card-body">
                        
                        <form action="code.php" method="post">

                            <div class="mb-3">
                                <label> Full Name </label>
                                <input type="text" name="full_name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label> Email </label>
                                <input type="email" name="email" class="form-control">
                            </div>
                             <div class="mb-3">
                                <label> Password </label>
                                <input type="password" name="password" class="form-control">
                            </div>
                           
                            <div class="mb-3">
                                <button type="submit" name="save_user" class="btn btn-primary">Save</button>
                               
                            </div>
                         
                    </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>




<!-- Option 1:Bootstrap Bundle with Popper -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>  
</body>
</html>