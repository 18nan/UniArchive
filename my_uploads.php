
<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$UserID = $_SESSION['user_id'];

$Query = "SELECT * FROM notes WHERE user_id='$UserID'";

$Result = mysqli_query($conn, $Query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>UniArchive - My Uploads</title>
</head>
<body>

    <h2>My Uploaded Study Materials</h2>

    <a href="dashboard.php">Back to Dashboard</a>

    <br><br>

    <?php
    if (mysqli_num_rows($Result) > 0) {
    ?>

        <table border="1" cellpadding="10">

            <tr>
                <th>Subject</th>
                <th>Chapter</th>
                <th>Title</th>
                <th>File Name</th>
                <th>File Size</th>
                <th>Download</th>
            </tr>

            <?php
            while ($Row = mysqli_fetch_assoc($Result)) {
            ?>

                <tr>
                    <td><?php echo $Row['subject']; ?></td>
                    <td><?php echo $Row['chapter']; ?></td>
                    <td><?php echo $Row['title']; ?></td>
                    <td><?php echo $Row['file_name']; ?></td>

                    <td>
                        <?php echo round($Row['file_size'] / 1024 / 1024, 2); ?> MB
                    </td>

                    <td>
                        <a href="download.php?id=<?php echo $Row['note_id']; ?>">
                            Download
                        </a>
                    </td>
                </tr>

            <?php
            }
            ?>

        </table>

    <?php
    }
    else {
        echo "You have not uploaded any study materials yet!";
    }
    ?>

</body>
</html>
