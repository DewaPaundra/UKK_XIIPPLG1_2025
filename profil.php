<?php
session_start();

$user = [
    'nama' => 'Paundra Dewa',
    'email' => 'paundra@gmail.com',
    'foto' => 'images/home.jpg',
    'bio' => 'Pengembang aplikasi To-Do List dengan Vue.js dan PHP.',
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('images/paundra.png');
        }
        .profile-container {
            max-width: 500px;
            margin: auto;
            background: rgb(151, 211, 0);
            color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        .profile-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #ffff;
        }
        .btn-custom {
            margin-top: 10px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="profile-container">
            <img src="<?php echo $user['foto']; ?>" alt="Foto Profil" class="profile-img">
            <h2 class="mt-3"> <?php echo $user['nama']; ?> </h2>
            <p class="text-muted"> <?php echo $user['email']; ?> </p>
            <p> <?php echo $user['bio']; ?> </p>
            
            <a href="riwayat.php" class="btn btn-primary btn-custom">Riwayat Tugas</a>
            <a href="index.php" class="btn btn-danger btn-custom">BackToDashboard</a>
        </div>
    </div>
</body>
</html>
