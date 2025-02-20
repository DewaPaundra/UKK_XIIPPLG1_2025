<?php
session_start();
include 'connect.php';

$search = isset($_POST['query']) ? $_POST['query'] : '';

$task_query = "SELECT tasks.id, tasks.task, tasks.status, categories.category 
               FROM tasks 
               JOIN categories ON tasks.category_id = categories.id
               WHERE tasks.user_id = " . $_SESSION['user_id'];

if (!empty($search)) {
    $task_query .= " AND (tasks.task LIKE '%$search%' OR categories.category LIKE '%$search%')";
}

$task_result = mysqli_query($conn, $task_query);

if (mysqli_num_rows($task_result) > 0) {
    while ($task = mysqli_fetch_assoc($task_result)) {
        echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
        echo '<div><span class="' . ($task['status'] == 'complete' ? 'doneText' : '') . '">';
        echo '<strong>' . $task['task'] . '</strong> <small>(' . $task['category'] . ')</small>';
        echo '</span></div>';
        echo '<div>';
        echo '<a href="complete.php?id=' . $task['id'] . '" class="btn btn-success btn-sm"><i class="fas fa-check"></i></a>';
        echo '<a href="edit.php?id=' . $task['id'] . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>';
        echo '<a href="delete.php?id=' . $task['id'] . '" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>';
        echo '</div></li>';
    }
} else {
    echo '<li class="list-group-item text-center">❌ tugas tidak di temukan.</li>';
}
?>
