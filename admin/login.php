<?php
session_start();
include "../koneksi.php";

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn,"SELECT * FROM admin WHERE username='$username' AND password='$password'");
    $cek = mysqli_num_rows($query);

    if($cek > 0){
        $_SESSION['admin'] = true;
        header("Location: dashboard.php");
        exit;
    }else{
        $error = "Login gagal! Username atau password salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-card { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        h2 { margin-top: 0; color: #333; text-align: center; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #666; }
        input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background-color: #007bff; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; margin-top: 10px; }
        button:hover { background-color: #0056b3; }
        .error { color: #dc3545; background: #f8d7da; padding: 10px; border-radius: 6px; margin-bottom: 15px; text-align: center; font-size: 14px; }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>Login Admin</h2>
        <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>
        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button name="login">Login</button>
        </form>
    </div>
</body>
</html>
