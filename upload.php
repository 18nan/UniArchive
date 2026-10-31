
<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if (isset($_POST['upload'])) {

    $Subject = $_POST['subject'];
    $Chapter = $_POST['chapter'];
    $Title = $_POST['title'];

    $FileName = $_FILES['file']['name'];
    $TempName = $_FILES['file']['tmp_name'];
    $FileSize = $_FILES['file']['size'];

    $FileExtension = pathinfo($FileName, PATHINFO_EXTENSION);

    if ($FileExtension != "pdf") {
        $message = "Only PDF files are allowed!";
    }
    else if ($FileSize > 10 * 1024 * 1024) {
        $message = "File size must be below 10 MB!";
    }
    else {

        $NewFileName = time() . "_" . $FileName;

        if (move_uploaded_file($TempName, "uploads/" . $NewFileName)) {

            $UserID = $_SESSION['user_id'];

            $Insert = mysqli_query($conn, "INSERT INTO notes
            (user_id, subject, chapter, title, file_name, file_size)
            VALUES ('$UserID', '$Subject', '$Chapter', '$Title', '$NewFileName', '$FileSize')");

            if ($Insert) {
                $message = "Study material uploaded successfully!";
            }
            else {
                $message = "Upload failed!";
            }
        }
        else {
            $message = "File could not be uploaded!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>UniArchive - Upload</title>
</head>
<body>

    <h2>Upload Study Material</h2>

    <form method="POST" enctype="multipart/form-data">

        Subject:
        <input type="text" name="subject" required>
        <br><br>

        Chapter:
        <input type="text" name="chapter" required>
        <br><br>

        Title:
        <input type="text" name="title" required>
        <br><br>

        Select PDF:
        <input type="file" name="file" accept=".pdf" required>
        <br><br>

        <input type="submit" name="upload" value="Upload">

    </form>

    <p><?php echo $message; ?></p>

    <a href="dashboard.php">Back to Dashboard</a>

</body>
</html>
