<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM riwayat WHERE user_id = '$user_id' ORDER BY completed_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('images/valen.jpg');
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .history-container {
            background-image: url('images/valen.png');
            color: black;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.3);
            max-width: 850px;
            width: 100%;
            backdrop-filter: blur(10px);
        }
        .history-container h2 {
            font-weight: 600;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        }
        .btn-back {
            display: flex;
            align-items: center;
            gap: 5px;
            transition: all 0.3s ease;
        }
        .btn-back:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        .table thead {
            background-color: #007bff;
            color: white;
        }
        .table tbody tr:nth-child(odd) {
            background-color: #f8f9fa;
        }
        .table tbody tr:hover {
            background-color: #e9ecef;
            transition: 0.3s;
        }
    </style>
</head>
<body>
    <div class="history-container">
        <h2 class="text-center text-white"><i class="fas fa-history"></i> Riwayat Tugas</h2>
        <a href="profil.php" class="btn btn-primary mb-3 btn-back">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tugas</th>
                        <th>Selesai Pada</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td class="text-start"><?= htmlspecialchars($row['task']); ?></td>
                            <td><?= date("d M Y, H:i", strtotime($row['completed_at'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
