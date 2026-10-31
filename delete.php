
<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {

    $ID = $_GET['id'];
    $UserID = $_SESSION['user_id'];

    $Query = mysqli_query($conn, "SELECT * FROM notes
    WHERE note_id='$ID' AND user_id='$UserID'");

    if (mysqli_num_rows($Query) > 0) {

        $Delete = mysqli_query($conn, "DELETE FROM notes
        WHERE note_id='$ID' AND user_id='$UserID'");

        if ($Delete) {
            echo "Study material deleted successfully!";
        }
        else {
            echo "Deletion failed!";
        }

    }
    else {
        echo "You cannot delete this study material!";
    }
}
else {
    echo "Invalid request!";
}
?>

<br><br>

<a href="my_uploads.php">Back to My Uploads</a>
