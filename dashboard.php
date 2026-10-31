
<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$Subject = "";
$Chapter = "";
$MaxSize = "any";

$Query = "SELECT notes.*, users.username
          FROM notes
          INNER JOIN users ON notes.user_id = users.user_id
          WHERE 1=1";

if (isset($_GET['search'])) {

    $Subject = mysqli_real_escape_string($conn, $_GET['subject']);
    $Chapter = mysqli_real_escape_string($conn, $_GET['chapter']);
    $MaxSize = $_GET['max_size'];

    if ($Subject != "") {
        $Query = $Query . " AND subject LIKE '%$Subject%'";
    }

    if ($Chapter != "") {
        $Query = $Query . " AND chapter LIKE '%$Chapter%'";
    }

    if ($MaxSize != "any" && is_numeric($MaxSize)) {
        $MaxSize = (int)$MaxSize;
        $Query = $Query . " AND file_size <= " . ($MaxSize * 1024 * 1024);
    }
}

$Result = mysqli_query($conn, $Query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>UniArchive - Dashboard</title>
</head>
<body>

    <h1>Welcome to UniArchive!</h1>

    <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>

    <a href="upload.php">Upload Study Material</a> |
    <a href="my_uploads.php">My Uploads</a> |
    <a href="logout.php">Logout</a>

    <hr>

    <h2>Find Study Material</h2>

    <form method="GET" action="">

        Subject:
        <input type="text" name="subject"
        value="<?php echo htmlspecialchars($Subject); ?>">

        <br><br>

        Chapter:
        <input type="text" name="chapter"
        value="<?php echo htmlspecialchars($Chapter); ?>">

        <br><br>

        Maximum File Size:

        <select name="max_size">
            <option value="any">Any Size</option>
            <option value="5" <?php if ($MaxSize == "5") echo "selected"; ?>>5 MB</option>
            <option value="10" <?php if ($MaxSize == "10") echo "selected"; ?>>10 MB</option>
            <option value="20" <?php if ($MaxSize == "20") echo "selected"; ?>>20 MB</option>
            <option value="50" <?php if ($MaxSize == "50") echo "selected"; ?>>50 MB</option>
        </select>

        <br><br>

        <input type="submit" name="search" value="Search">

    </form>

    <hr>

    <h2>Available Study Materials</h2>

    <?php
    if (mysqli_num_rows($Result) > 0) {
    ?>

        <table border="1" cellpadding="10">

            <tr>
                <th>Subject</th>
                <th>Chapter</th>
                <th>Title</th>
                <th>Uploaded By</th>
                <th>File Size</th>
                <th>Download</th>
            </tr>

            <?php
            while ($Row = mysqli_fetch_assoc($Result)) {
            ?>

                <tr>
                    <td><?php echo htmlspecialchars($Row['subject']); ?></td>
                    <td><?php echo htmlspecialchars($Row['chapter']); ?></td>
                    <td><?php echo htmlspecialchars($Row['title']); ?></td>
                    <td><?php echo htmlspecialchars($Row['username']); ?></td>
                    <td><?php echo round($Row['file_size'] / 1024 / 1024, 2); ?> MB</td>
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
        echo "No study materials found!";
    }
    ?>

</body>
</html>
