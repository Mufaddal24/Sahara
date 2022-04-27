<?php 

$login = false;
$showError = false;

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    include 'partials/_dbconnect.php';
    $user = $_POST['username'];
    $password = $_POST['pass'];
    $email = $_POST['email'];

    $sql = "SELECT * FROM `user_login` WHERE `user_email` = '$email' AND `username` = '$user'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);

    if($num == 1)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            if($password == $row['PASS'])
            {
                $login = true;
                session_start();
                $_SESSION['loggedIn'] = true;
                $_SESSION['username'] = $user;
                header("location: /dbms/index.php");
            }
            else
            {
                $showError = "Invalid Credentials";
            }
        }
    }
    else
    {
        $showError = "This account does not exist. Please Signup first.";
    }
    
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5.1.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <script src="bootstrap-5.1.3-dist/js/bootstrap.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="header">
        <div class="container">
            <?php require 'partials/_nav.php' ?>
            <?php 
            
            if($showError)
            {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error! </strong>'.$showError.'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
            
            ?>
            <div class="form-group">
                <form action="/dbms/login.php" method="POST">
                    <h1>Enter details to Login.</h1>
                    <div class="input-box">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username">
                    </div>
                    <div class="input-box">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email">
                    </div>
                    <div class="input-box">
                        <label for="pass">Password</label>
                        <input type="password" name="pass" id="pass">
                    </div>
                    
                    <button type="submit" class="btn">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <?php require 'partials/_footer.php' ?>
</body>

</html>