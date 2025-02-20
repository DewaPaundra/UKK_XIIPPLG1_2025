<?php
include 'connect.php';

$id = $_GET['id'] ?? 0;
$query = "SELECT * FROM tasks WHERE id = $id";
$result = mysqli_query($conn, $query);
$task = mysqli_fetch_assoc($result);

$category_query = "SELECT * FROM categories";
$category_result = mysqli_query($conn, $category_query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task_text = $_POST['task'];
    $category_id = $_POST['category_id'];
    $status = $_POST['status'];

    $update_query = "UPDATE tasks SET task='$task_text', category_id='$category_id', status='$status' WHERE id=$id";

    if (mysqli_query($conn, $update_query)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-image: url('images/valen.jpg');
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .card {
            background-image: url('images/valen.jpg');
            border-radius: 12px;
            padding: 25px;
            width: 360px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            font-size: 1.4rem;
            font-weight: 600;
            text-align: center;
            color: white; /* Warna teks judul diubah menjadi putih */
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #d1d5db;
            padding: 10px;
            font-size: 1rem;
            color: #333;
        }
        .form-control:focus, .form-select:focus {
            border-color: #2563eb;
            box-shadow: none;
        }
        label {
            font-weight: 500;
            color: white;
        }
        .btn {
            border-radius: 8px;
            font-weight: 600;
            padding: 10px;
            font-size: 1rem;
            text-align: center;
        }
        .btn-primary {
            background: #2563eb;
            border: none;
            color: white;
        }
        .btn-primary:hover {
            background: #1d4ed8;
        }
        .btn-secondary {
            background: #d1d5db;
            border: none;
            color: #333;
        }
        .btn-secondary:hover {
            background: #9ca3af;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <i class="fas fa-edit"></i> Edit Tugas
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label text-white">Tugas</label>
                    <input type="text" class="form-control" name="task" value="<?= htmlspecialchars($task['task']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label text-white">Kategori</label>
                    <select class="form-select" name="category_id" required>
                        <?php while ($category = mysqli_fetch_assoc($category_result)) : ?>
                            <option value="<?= $category['id'] ?>" <?= ($category['id'] == $task['category_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category['category']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label text-white">Status</label>
                    <select class="form-select" name="status">
                        <option value="not complete" <?= ($task['status'] == 'not complete') ? 'selected' : '' ?>>Belum Selesai</option>
                        <option value="complete" <?= ($task['status'] == 'complete') ? 'selected' : '' ?>>Selesai</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-save"></i> Simpan Perubahan</button>
                <a href="index.php" class="btn btn-secondary w-100 mt-2"><i class="fas fa-times"></i> Batal</a>
            </form>
        </div>
    </div>
</body>
</html>
