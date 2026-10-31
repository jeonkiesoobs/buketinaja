<?php
session_start();
// Menggunakan @ untuk menyembunyikan error sistem yang berantakan
@include 'koneksi.php';

// Cek apakah koneksi tersedia
if (!isset($conn)) {
    die("<div style='text-align:center; padding:50px; font-family:sans-serif;'>
            <h2>Koneksi Gagal</h2>
            <p>File <b>koneksi.php</b> tidak ditemukan atau variabel <b>\$conn</b> salah.</p>
         </div>");
}

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Ambil data user berdasarkan username
    $result = mysqli_query($conn, "SELECT * FROM users_new WHERE username = '$username'");
    
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Verifikasi password (database harus menggunakan password_hash)
        if (password_verify($password, $row['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['role']   = $row['role'];
            $_SESSION['nama']   = $row['nama_lengkap'];
            $_SESSION['id']     = $row['id'];

            // Pengalihan cerdas
            if ($row['role'] == 'admin') {
                header("Location: admin/admin_dashboard.php");
            } else {
                header("Location: user/user_dashboard.php");
            }
            exit;
        }
    }
    $error = true;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Buketin Aja</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #2563eb;
            --bg: #f8fafc;
            --text: #0f172a;
            --card: #ffffff;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }

        body {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            display: flex; justify-content: center; align-items: center; 
            min-height: 100vh; padding: 20px;
        }

        /* Container Login */
        .login-box {
            display: flex; width: 950px; max-width: 100%; min-height: 550px; 
            background: var(--card); border-radius: 30px; overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
        }

        /* Sisi Kiri (Gambar/Branding) */
        .brand-side {
            width: 50%; background: var(--primary);
            background: linear-gradient(45deg, #1e40af, #3b82f6);
            color: white; display: flex; flex-direction: column;
            justify-content: center; padding: 60px; position: relative;
        }
        .brand-side h1 { font-size: 3rem; font-weight: 800; line-height: 1.1; margin-bottom: 20px; letter-spacing: -2px; }
        .brand-side p { font-size: 1.1rem; opacity: 0.8; line-height: 1.6; }

        /* Sisi Kanan (Form) */
        .form-side { 
            width: 50%; padding: 60px; display: flex; 
            flex-direction: column; justify-content: center;
        }
        .form-side h2 { font-size: 2.2rem; font-weight: 800; color: var(--text); margin-bottom: 10px; }
        .form-side p.subtitle { color: #64748b; margin-bottom: 35px; }

        /* Notifikasi Error */
        .error-msg {
            background: #fef2f2; color: #b91c1c; padding: 12px; border-radius: 12px;
            font-size: 0.85rem; margin-bottom: 20px; border: 1px solid #fee2e2;
            display: flex; align-items: center; gap: 10px;
        }

        /* Input */
        .input-wrap { margin-bottom: 20px; }
        .input-wrap label { display: block; font-size: 0.85rem; font-weight: 700; margin-bottom: 8px; color: var(--text); }
        .field { position: relative; }
        .field input {
            width: 100%; padding: 14px 18px; border: 2px solid #e2e8f0;
            border-radius: 15px; outline: none; transition: 0.3s; font-size: 0.95rem;
        }
        .field input:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1); }
        .field i { position: absolute; right: 18px; top: 50%; transform: translateY(-50%); color: #94a3b8; cursor: pointer; }

        .btn-login {
            width: 100%; padding: 16px; background: var(--primary); border: none;
            color: white; border-radius: 15px; font-weight: 700; font-size: 1rem;
            cursor: pointer; transition: 0.3s; margin-top: 10px;
        }
        .btn-login:hover { background: #1d4ed8; transform: translateY(-2px); box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2); }

        .footer-link { text-align: center; margin-top: 30px; font-size: 0.9rem; color: #64748b; }
        .footer-link a { color: var(--primary); text-decoration: none; font-weight: 700; }

        @media (max-width: 900px) {
            .login-box { flex-direction: column; }
            .brand-side, .form-side { width: 100%; padding: 40px; }
            .brand-side h1 { font-size: 2rem; }
        }
    </style>
</head>
<body>

    <div class="login-box">
        <div class="brand-side">
            <i class="fas fa-gift fa-3x" style="margin-bottom: 30px;"></i>
            <h1>Rayakan<br>Momen Terbaik.</h1>
            <p>Masuk ke portal Buketin Aja untuk mulai memesan buket impian Anda dengan kualitas terbaik.</p>
        </div>

        <div class="form-side">
            <h2>Selamat Datang</h2>
            <p class="subtitle">Gunakan akun Anda untuk melanjutkan.</p>

            <?php if(isset($error)) : ?>
                <div class="error-msg">
                    <i class="fas fa-circle-exclamation"></i> Username atau password salah!
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="input-wrap">
                    <label>Username</label>
                    <div class="field">
                        <input type="text" name="username" placeholder="Masukkan username" required>
                    </div>
                </div>

                <div class="input-wrap">
                    <label>Password</label>
                    <div class="field">
                        <input type="password" name="password" id="pass" placeholder="••••••••" required>
                        <i class="fas fa-eye-slash" id="toggle"></i>
                    </div>
                </div>

                <button type="submit" name="login" class="btn-login">Masuk ke Dashboard</button>
            </form>

            <p class="footer-link">Belum punya akun? <a href="register.php">Daftar Akun Baru</a></p>
        </div>
    </div>

    <script>
        const toggle = document.querySelector('#toggle');
        const passInput = document.querySelector('#pass');

        toggle.addEventListener('click', function() {
            const type = passInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>