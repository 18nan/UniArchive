
<?php
include "db.php";

$message = "";

if (isset($_POST['register'])) {

    $Username = $_POST['username'];
    $Password = $_POST['password'];

    $Check = mysqli_query($conn, "SELECT * FROM users WHERE username='$Username'");

    if (mysqli_num_rows($Check) > 0) {
        $message = "Username already exists!";
    }
    else {
        $HashedPassword = password_hash($Password, PASSWORD_DEFAULT);

        $Insert = mysqli_query($conn, "INSERT INTO users (username, password)
        VALUES ('$Username', '$HashedPassword')");

        if ($Insert) {
            $message = "Registration successful! You can now login.";
        }
        else {
            $message = "Registration failed!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>UniArchive - Register</title>
</head>
<body>

    <h2>UniArchive - Create Account</h2>

    <form method="POST" action="">

        Username:
        <input type="text" name="username" required>
        <br><br>

        Password:
        <input type="password" name="password" required>
        <br><br>

        <input type="submit" name="register" value="Register">

    </form>

    <p><?php echo $message; ?></p>

    <p>Already have an account?
        <a href="login.php">Login here</a>
    </p>

</body>
</html>
