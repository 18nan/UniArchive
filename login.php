
<?php
session_start();
include "db.php";

$message = "";

if (isset($_POST['login'])) {

    $Username = $_POST['username'];
    $Password = $_POST['password'];

    $Check = mysqli_query($conn, "SELECT * FROM users WHERE username='$Username'");

    if (mysqli_num_rows($Check) > 0) {

        $User = mysqli_fetch_assoc($Check);

        if (password_verify($Password, $User['password'])) {

            $_SESSION['user_id'] = $User['user_id'];
            $_SESSION['username'] = $User['username'];

            header("Location: dashboard.php");
            exit();

        }
        else {
            $message = "Incorrect password!";
        }

    }
    else {
        $message = "Account does not exist! Please register.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>UniArchive - Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>UniArchive - Login</h2>

    <form method="POST" action="">

        Username:
        <input type="text" name="username" required>
        <br><br>

        Password:
        <input type="password" name="password" required>
        <br><br>

        <input type="submit" name="login" value="Login">

    </form>

    <p><?php echo $message; ?></p>

    <p>Don't have an account?
        <a href="register.php">Register here</a>
    </p>

</body>
</html>
