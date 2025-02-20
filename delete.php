<?php
include 'connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM tasks WHERE id=$id";
    mysqli_query($conn, $query);
}

header("Location: index.php");
exit();
?>
