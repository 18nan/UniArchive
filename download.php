
<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {

    $ID = $_GET['id'];

    $Query = mysqli_query($conn, "SELECT * FROM notes WHERE note_id='$ID'");

    if (mysqli_num_rows($Query) > 0) {

        $Row = mysqli_fetch_assoc($Query);

        $FileName = $Row['file_name'];

        echo "<a href='uploads/$FileName' download>Click here to download your file</a>";

    }
    else {
        echo "Study material not found!";
    }
}
else {
    echo "Invalid download request!";
}
?>
