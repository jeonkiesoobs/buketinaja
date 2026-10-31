<?php
session_start();
@include 'koneksi.php'; 
$db_ok = (isset($conn) && $conn instanceof mysqli) ? true : false;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buketin Aja | Premium & Modern Gift</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #2563eb;
            --accent: #fbbf24;
            --dark: #0f172a;
            --light: #f8fafc;
            --white: #ffffff;
            --shadow: 0 20px 40px rgba(0,0,0,0.05);
        }

        * { margin:0; padding:0; box-sizing:border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: var(--light); color: var(--dark); overflow-x: hidden; }

        /* NAVBAR MODERN */
        .navbar {
            position: fixed; top: 0; width: 100%; background: rgba(255,255,255,0.8);
            backdrop-filter: blur(15px); padding: 20px 8%; display: flex;
            justify-content: space-between; align-items: center; z-index: 1000;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        .logo { font-weight: 800; font-size: 1.5rem; color: var(--dark); text-decoration: none; }
        .logo span { color: var(--primary); }
        .nav-menu a { text-decoration: none; color: var(--dark); font-weight: 600; margin-left: 30px; font-size: 0.9rem; }
        .btn-cta { background: var(--primary); color: white !important; padding: 10px 25px; border-radius: 12px; transition: 0.3s; }

        /* HERO & PROMO SECTION */
        .hero-section { padding: 120px 8% 60px; display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center; }
        
        .promo-card {
            background: linear-gradient(135deg, var(--dark) 0%, #1e293b 100%);
            border-radius: 35px; padding: 50px; color: var(--white); position: relative;
            overflow: hidden; box-shadow: 0 30px 60px rgba(0,0,0,0.2);
        }
        .promo-card::after {
            content: ''; position: absolute; top: -50px; right: -50px; width: 200px; height: 200px;
            background: var(--primary); filter: blur(80px); opacity: 0.4;
        }
        .promo-badge { background: var(--accent); color: var(--dark); padding: 5px 15px; border-radius: 50px; font-weight: 800; font-size: 0.8rem; }

        /* KATALOG */
        .catalog { padding: 60px 8%; }
        .section-title { margin-bottom: 40px; display: flex; justify-content: space-between; align-items: flex-end; }
        .section-title h2 { font-size: 2.2rem; font-weight: 800; letter-spacing: -1px; }

        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px; }
        
        .product-card {
            background: var(--white); border-radius: 30px; padding: 15px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid transparent; box-shadow: var(--shadow);
        }
        .product-card:hover { transform: translateY(-15px); border-color: var(--primary); }

        .img-wrapper { 
            width: 100%; aspect-ratio: 4/5; border-radius: 22px; 
            overflow: hidden; background: #f1f5f9; position: relative;
        }
        .img-wrapper img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
        .product-card:hover .img-wrapper img { transform: scale(1.1); }

        .price-box { margin-top: 15px; display: flex; justify-content: space-between; align-items: center; }
        .price { font-size: 1.3rem; font-weight: 800; color: var(--primary); }
        .add-cart { 
            width: 45px; height: 45px; background: var(--light); border-radius: 15px;
            display: flex; align-items: center; justify-content: center; color: var(--dark);
            text-decoration: none; transition: 0.3s;
        }
        .product-card:hover .add-cart { background: var(--primary); color: white; }

        /* MOBILE OPTIMIZATION */
        @media (max-width: 768px) {
            .hero-section { grid-template-columns: 1fr; padding-top: 100px; }
            .section-title { flex-direction: column; align-items: flex-start; gap: 10px; }
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <a href="#" class="logo">BUKETIN<span>AJA</span></a>
        <div class="nav-menu">
            <a href="#katalog">Katalog</a>
            <a href="login.php" class="btn-cta">Login / Register</a>
        </div>
    </nav>

    <header class="hero-section">
        <div data-aos="fade-right">
            <h1 style="font-size: 3.5rem; font-weight: 800; line-height: 1.1; margin-bottom: 20px;">
                Momen Indah,<br><span style="color: var(--primary);">Hadiah Mewah.</span>
            </h1>
            <p style="font-size: 1.1rem; color: #64748b; margin-bottom: 30px;">
                Koleksi buket tangan eksklusif dengan bunga pilihan untuk setiap ekspresi perasaan Anda.
            </p>
            <div style="display: flex; gap: 15px;">
                <div style="text-align: center; background: white; padding: 15px 25px; border-radius: 20px; box-shadow: var(--shadow);">
                    <h3 style="color: var(--primary);">500+</h3>
                    <p style="font-size: 0.8rem; font-weight: 700;">Pesanan</p>
                </div>
                <div style="text-align: center; background: white; padding: 15px 25px; border-radius: 20px; box-shadow: var(--shadow);">
                    <h3 style="color: var(--primary);">4.9/5</h3>
                    <p style="font-size: 0.8rem; font-weight: 700;">Rating</p>
                </div>
            </div>
        </div>

        <div class="promo-card" data-aos="zoom-in">
            <span class="promo-badge">PROMO TERBATAS</span>
            <h2 style="font-size: 3rem; margin: 20px 0 10px;">Potongan<br>Rp 50.000</h2>
            <p style="opacity: 0.8; margin-bottom: 30px;">Gunakan kode: <b>MOMENINDAH</b> untuk pembelian pertama Anda melalui website.</p>
            <a href="login.php" style="color: var(--accent); font-weight: 800; text-decoration: none;">Ambil Promo Sekarang <i class="fas fa-chevron-right"></i></a>
        </div>
    </header>

    <main class="catalog" id="katalog">
        <div class="section-title" data-aos="fade-up">
            <div>
                <p style="color: var(--primary); font-weight: 800; font-size: 0.8rem; letter-spacing: 2px;">COLLECTIONS</p>
                <h2>Katalog Buket</h2>
            </div>
            <a href="#" style="color: var(--dark); font-weight: 700; font-size: 0.9rem;">Lihat Semua <i class="fas fa-arrow-right"></i></a>
        </div>

        <div class="grid">
            <?php
            if ($db_ok) {
                $query = mysqli_query($conn, "SELECT * FROM produk_buket LIMIT 8");
                if ($query && mysqli_num_rows($query) > 0) {
                    while($row = mysqli_fetch_assoc($query)) {
                        ?>
                        <div class="product-card" data-aos="fade-up">
                            <div class="img-wrapper">
                                <img src="assets/<?php echo $row['gambar']; ?>" onerror="this.src='https://via.placeholder.com/500x650?text=Buket+Premium'">
                            </div>
                            <div style="padding: 10px 5px;">
                                <h3 style="font-weight: 800; font-size: 1.1rem;"><?php echo htmlspecialchars($row['nama_buket']); ?></h3>
                                <p style="font-size: 0.8rem; color: #64748b; margin-top: 5px;">Customized Bouquet</p>
                                <div class="price-box">
                                    <span class="price">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></span>
                                    <a href="login.php" class="add-cart">
                                        <i class="fas fa-shopping-basket"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else { echo "<p>Produk tidak ditemukan.</p>"; }
            } else { echo "<p style='color:red;'>Koneksi database bermasalah.</p>"; }
            ?>
        </div>
    </main>

    <footer style="padding: 60px 8%; text-align: center; background: var(--white); border-top: 1px solid #eee;">
        <p style="font-weight: 800; letter-spacing: 3px; opacity: 0.2;">BUKETIN AJA © 2026</p>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 1000, once: true });
    </script>
</body>
</html>