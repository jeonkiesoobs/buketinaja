<?php
@include 'koneksi.php';

// Proteksi jika koneksi bermasalah
if (!isset($conn)) {
    die("Koneksi database gagal. Periksa file koneksi.php");
}

if (isset($_POST['register'])) {
    $nama  = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $user  = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass  = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Cek apakah username atau email sudah terdaftar
    $checkUser = mysqli_query($conn, "SELECT * FROM users_new WHERE username = '$user' OR email = '$email'");
    
    if (mysqli_num_rows($checkUser) > 0) {
        $error_msg = "Username atau Email sudah digunakan!";
    } else {
        $query = "INSERT INTO users_new (nama_lengkap, username, email, password, role) 
                  VALUES ('$nama', '$user', '$email', '$pass', 'user')";
        
        if (mysqli_query($conn, $query)) {
            echo "<script>
                    alert('Registrasi Berhasil! Silakan Login.');
                    window.location='login.php';
                  </script>";
        } else {
            $error_msg = "Terjadi kesalahan sistem. Silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun | Buketin Aja</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --bg-body: #f1f5f9;
            --text-dark: #0f172a;
            --text-gray: #64748b;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }

        body {
            background: linear-gradient(135deg, #e0f2fe 0%, #f1f5f9 100%);
            display: flex; justify-content: center; align-items: center; 
            min-height: 100vh; padding: 20px;
        }

        /* Container Card */
        .reg-card {
            display: flex; width: 950px; max-width: 100%; min-height: 600px;
            background: #fff; border-radius: 30px; overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
        }

        /* Sisi Kiri: Branding (Dibalik posisinya agar beda dengan login) */
        .reg-brand {
            width: 45%; background: var(--primary);
            background: linear-gradient(135deg, #4f46e5 0%, #2563eb 100%);
            color: white; display: flex; flex-direction: column;
            justify-content: center; padding: 50px; text-align: center;
        }
        .reg-brand h1 { font-size: 2.5rem; font-weight: 800; margin-bottom: 15px; letter-spacing: -1px; }
        .reg-brand p { font-size: 1rem; opacity: 0.9; line-height: 1.6; }

        /* Sisi Kanan: Form */
        .reg-form-area {
            width: 55%; padding: 50px; display: flex;
            flex-direction: column; justify-content: center;
        }
        .reg-form-area h2 { font-size: 2rem; font-weight: 800; color: var(--text-dark); margin-bottom: 10px; }
        .subtitle { color: var(--text-gray); margin-bottom: 30px; font-size: 0.95rem; }

        .error-notif {
            background: #fef2f2; color: #b91c1c; padding: 12px; border-radius: 12px;
            font-size: 0.85rem; margin-bottom: 20px; border: 1px solid #fee2e2;
            display: flex; align-items: center; gap: 10px;
        }

        /* Form Input */
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .input-group { margin-bottom: 18px; }
        .input-group.full { grid-column: span 2; }
        
        .input-group label { display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 8px; color: var(--text-dark); }
        .input-group input {
            width: 100%; padding: 12px 16px; border: 1.5px solid #e2e8f0;
            border-radius: 12px; background: #f8fafc; outline: none; transition: 0.3s;
        }
        .input-group input:focus { border-color: var(--primary); background: #fff; box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1); }

        .btn-reg {
            width: 100%; padding: 15px; background: var(--primary); border: none;
            color: white; border-radius: 12px; font-weight: 700; font-size: 1rem;
            cursor: pointer; transition: 0.3s; margin-top: 10px;
        }
        .btn-reg:hover { background: var(--primary-dark); transform: translateY(-2px); box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2); }

        .login-link { text-align: center; margin-top: 25px; font-size: 0.9rem; color: var(--text-gray); }
        .login-link a { color: var(--primary); text-decoration: none; font-weight: 700; }

        @media (max-width: 850px) {
            .reg-card { flex-direction: column; }
            .reg-brand, .reg-form-area { width: 100%; padding: 40px; }
            .form-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <div class="reg-card">
        <div class="reg-brand">
            <i class="fas fa-user-plus fa-4x" style="margin-bottom: 20px;"></i>
            <h1>Gabung Bersama Kami.</h1>
            <p>Daftarkan akun Anda dan nikmati kemudahan memesan buket eksklusif untuk setiap momen spesial.</p>
        </div>

        <div class="reg-form-area">
            <h2>Daftar Akun</h2>
            <p class="subtitle">Silakan isi data diri Anda dengan benar.</p>

            <?php if(isset($error_msg)) : ?>
                <div class="error-notif">
                    <i class="fas fa-exclamation-triangle"></i> <?php echo $error_msg; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-grid">
                    <div class="input-group full">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" placeholder="Masukkan nama lengkap" required>
                    </div>
                    
                    <div class="input-group">
                        <label>Username</label>
                        <input type="text" name="username" placeholder="Username" required>
                    </div>

                    <div class="input-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="Alamat email aktif" required>
                    </div>

                    <div class="input-group full">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Minimal 6 karakter" required>
                    </div>
                </div>

                <button type="submit" name="register" class="btn-reg">Buat Akun Sekarang</button>
            </form>

            <p class="login-link">Sudah punya akun? <a href="login.php">Masuk di sini</a></p>
        </div>
    </div>

</body>
</html>