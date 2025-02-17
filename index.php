<?php
session_start();
$conn = new mysqli("localhost", "root", "", "ukklpk2025");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek apakah user sudah login
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Tambah tugas
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_task"])) {
    $task = trim($_POST["task"]);
    if (!empty($task)) {
        $stmt = $conn->prepare("INSERT INTO tasks (user_id, task) VALUES (?, ?)");
        $stmt->bind_param("is", $_SESSION["user_id"], $task);
        $stmt->execute();
    }
}

// Update status tugas
if (isset($_GET["done"])) {
    $task_id = $_GET["done"];
    $conn->query("UPDATE tasks SET status='done' WHERE id=$task_id AND user_id=" . $_SESSION["user_id"]);
}

// Hapus tugas
if (isset($_GET["delete"])) {
    $task_id = $_GET["delete"];
    $conn->query("DELETE FROM tasks WHERE id=$task_id AND user_id=" . $_SESSION["user_id"]);
}

// Ambil daftar tugas user
$result = $conn->query("SELECT * FROM tasks WHERE user_id=" . $_SESSION["user_id"] . " ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .task-card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .task-list li {
            transition: 0.3s;
        }
        .task-list li:hover {
            background-color: #f1f1f1;
        }
        .btn-circle {
            width: 35px;
            height: 35px;
            padding: 6px 0;
            border-radius: 50%;
            text-align: center;
            font-size: 14px;
            line-height: 1.42857;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">📌 To-Do List - <?= $_SESSION["user_name"]; ?></h2>
        <div class="d-flex justify-content-between mb-3">
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
        
        <div class="card p-4 task-card">
            <h4 class="mb-3">Tambah Tugas</h4>
            <form method="POST">
                <div class="input-group">
                    <input type="text" name="task" class="form-control" placeholder="Tambahkan tugas baru..." required>
                    <button type="submit" name="add_task" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </form>
        </div>

        <ul class="list-group mt-4 task-list">
            <?php while ($row = $result->fetch_assoc()): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="<?= $row['status'] == 'done' ? 'text-decoration-line-through text-success' : '' ?>">
                        <?= htmlspecialchars($row['task']); ?>
                    </span>
                    <div>
                        <?php if ($row['status'] == 'pending'): ?>
                            <a href="?done=<?= $row['id']; ?>" class="btn btn-success btn-circle">
                                <i class="fas fa-check"></i>
                            </a>
                        <?php endif; ?>
                        <a href="?delete=<?= $row['id']; ?>" class="btn btn-danger btn-circle">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>
