<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $task_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    
    $query = "SELECT * FROM tasks WHERE id = '$task_id' AND user_id = '$user_id'";
    $result = mysqli_query($conn, $query);
    
    if ($row = mysqli_fetch_assoc($result)) {
      
        $move_query = "INSERT INTO riwayat (task, category_id, user_id, status, completed_at) 
                       VALUES ('".$row['task']."', '".$row['category_id']."', '$user_id', 'complete', NOW())";
        
        if (mysqli_query($conn, $move_query)) {
          
            $delete_query = "DELETE FROM tasks WHERE id = '$task_id'";
            mysqli_query($conn, $delete_query);
            header("Location: riwayat.php");
            exit();
        }
    }
}

header("Location: index.php");
exit();
?>
