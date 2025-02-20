<?php
session_start();
$conn = new mysqli("localhost", "root", "", "ukklpk2025");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_input = trim($_POST["login_input"]);
    $password = $_POST["password"];

    if (empty($login_input) || empty($password)) {
        $error = "Username/Email dan password wajib diisi!";
    } else {
       
        if (filter_var($login_input, FILTER_VALIDATE_EMAIL)) {
            $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
        } else {
            $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE username = ?");
        }

        $stmt->bind_param("s", $login_input);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $name, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION["user_id"] = $id;
                $_SESSION["user_name"] = $name;
                header("Location: index.php");
                exit();
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Username atau email tidak terdaftar!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('images/valen.jpg');
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            width: 100%;
            text-align: center;
            color: white;
        }
        .login-container h3 {
            font-weight: 600;
            margin-bottom: 20px;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
        }
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.3);
            color: white;
        }
        .btn-primary {
            background: #ff416c;
            border: none;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background: #ff4b2b;
            transform: scale(1.05);
        }
        .alert {
            background: rgba(255, 0, 0, 0.7);
            border: none;
            color: white;
        }
        a {
            color: rgb(0, 251, 255);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h3><i class="fas fa-user-circle"></i> Masuk</h3>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <input type="text" name="login_input" class="form-control" placeholder="Username atau Email" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Masuk</button>
        </form>
        <p class="mt-3">Belum punya akun? <a href="register.php">Daftar</a></p>
    </div>
</body>
</html>
