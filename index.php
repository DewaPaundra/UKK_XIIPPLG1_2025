<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$category_query = "SELECT * FROM categories";
$category_result = mysqli_query($conn, $category_query);

$user_id = $_SESSION['user_id'];
$task_query = "SELECT * FROM tasks WHERE user_id = '$user_id' ORDER BY id DESC";
$task_result = mysqli_query($conn, $task_query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task = $_POST['task'];
    $category_id = $_POST['category_id'];
    $status = "not complete";

    $insert_query = "INSERT INTO tasks (task, category_id, user_id, status) 
                     VALUES ('$task', '$category_id', '$user_id', '$status')";

    if (mysqli_query($conn, $insert_query)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TDL PaundraDewa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-image: url('images/valen.jpg');
            background-size: cover;
            background-position: center;
        }
        .todo-container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.63);
        }
        .doneText {
            text-decoration: line-through;
            color: gray;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand"><i class="fas fa-clipboard-list"></i> TDL Paundra</a>
            <div class="d-flex align-items-center">
                <a href="profil.php" class="btn btn-light btn-sm me-2">My Profile</a>
                <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center text-white"><i class="fas fa-clipboard-list"></i> TDL Paundra</h1>

        <div class="todo-container mt-4">
            <form method="POST" action="index.php">
                <div class="row g-2">
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="task" placeholder="Tambahkan tugas..." required>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" name="category_id" required>
                            <option value="">Pilih Kategori</option>
                            <?php while ($row = mysqli_fetch_assoc($category_result)) : ?>
                                <option value="<?= $row['id'] ?>"><?= $row['category'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary form-control" type="submit"><i class="fas fa-plus"></i> Tambah</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="todo-container mt-4">
            <input type="text" id="search" class="form-control" placeholder="🔍 Cari tugas..." autocomplete="off">
        </div>

        <div class="todo-container mt-4">
            <h4 class="text-center">📌 Daftar Tugas</h4>
            <ul class="list-group" id="task-list">
                <?php while ($task = mysqli_fetch_assoc($task_result)) : ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?= htmlspecialchars($task['task']) ?>
                    <div>
                        <button class="btn btn-success btn-sm complete-task" data-id="<?= $task['id'] ?>">Complete</button>
                        <a href="delete_task.php?id=<?= $task['id'] ?>" class="btn btn-danger btn-sm">Hapus</a>
                    </div>
                </li>

                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            function loadTasks(query = '') {
                $.ajax({
                    url: "search.php",
                    method: "POST",
                    data: { query: query },
                    success: function (data) {
                        $("#task-list").html(data);
                    }
                });
            }

            loadTasks();

            $("#search").keyup(function () {
                let searchText = $(this).val();
                loadTasks(searchText);
            });
        });
    </script>

</body>
</html>
