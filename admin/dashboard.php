<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

include "../koneksi.php";

// Query Statistik
$resTotal = mysqli_query($conn, "SELECT COUNT(*) as total FROM survei");
$rowTotal = mysqli_fetch_assoc($resTotal);
$totalResponden = $rowTotal['total'];

$resAvg = mysqli_query($conn, "SELECT AVG(rating) as rata_rata FROM survei");
$rowAvg = mysqli_fetch_assoc($resAvg);
$rataRata = round($rowAvg['rata_rata'], 1);

$resSatisfied = mysqli_query($conn, "SELECT COUNT(*) as puas FROM survei WHERE rating >= 4");
$rowSatisfied = mysqli_fetch_assoc($resSatisfied);
$persenKepuasan = $totalResponden > 0 ? round(($rowSatisfied['puas'] / $totalResponden) * 100) : 0;

// Query Data Tabel
$data = mysqli_query($conn, "SELECT * FROM survei ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Explore Denpasar</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Outfit:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #AEB784; 
            --primary-dark: #41431B;
            --secondary: #E3DBBB; 
            --dark: #41431B;
            --light: #F8F3E1;
            --gray: #E3DBBB;
            --text: #41431B;
            --white: #FFFFFF;
            --shadow: 0 10px 30px rgba(174, 183, 132, 0.12);
        }

        body { 
            font-family: 'Inter', sans-serif; 
            margin: 0; 
            background-color: var(--light); 
            color: var(--text);
            line-height: 1.6;
        }

        header {
            background-color: var(--white);
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        header h1 {
            font-family: 'Outfit', sans-serif;
            margin: 0;
            font-size: 1.5rem;
            color: var(--dark);
        }

        .logout-btn {
            text-decoration: none;
            background: #dc3545;
            color: white;
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: #c82333;
            transform: translateY(-2px);
        }

        .main-content {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            background: var(--white);
            padding: 2rem;
            border-radius: 16px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(174, 183, 132, 0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card i {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .stat-card h3 {
            margin: 0;
            font-size: 1rem;
            color: #666;
            font-weight: 600;
        }

        .stat-card .number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--dark);
            margin: 0.5rem 0;
            font-family: 'Outfit', sans-serif;
        }

        .stat-card p {
            margin: 0;
            font-size: 0.85rem;
            color: #888;
        }

        /* Table Section */
        .table-container {
            background: var(--white);
            border-radius: 16px;
            box-shadow: var(--shadow);
            overflow: hidden;
            border: 1px solid rgba(174, 183, 132, 0.1);
        }

        .table-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #eee;
            background: var(--white);
        }

        .table-header h2 {
            margin: 0;
            font-family: 'Outfit', sans-serif;
            font-size: 1.25rem;
            color: var(--dark);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #f8f9fa;
            text-align: left;
            padding: 1rem 2rem;
            font-weight: 600;
            color: #666;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        td {
            padding: 1rem 2rem;
            border-bottom: 1px solid #eee;
            font-size: 0.95rem;
            vertical-align: top;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background-color: #fcfcfc;
        }

        .badge-rating {
            background: var(--light);
            color: var(--dark);
            padding: 4px 10px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .badge-rating i {
            color: #ffc107;
        }

        @media (max-width: 768px) {
            .main-content { padding: 1rem; }
            .stats-grid { grid-template-columns: 1fr; }
            th, td { padding: 1rem; }
            table { display: block; overflow-x: auto; }
        }
    </style>
</head>
<body>

    <header>
        <h1>Dashboard <span>Admin</span></h1>
        <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Keluar</a>
    </header>

    <main class="main-content">
        <!-- Section Statistik -->
        <div class="stats-grid">
            <div class="stat-card">
                <i class="fas fa-users"></i>
                <h3>Total Responden</h3>
                <div class="number"><?php echo $totalResponden; ?></div>
                <p>Orang telah mengisi survei</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-star"></i>
                <h3>Rata-Rata Rating</h3>
                <div class="number"><?php echo $rataRata; ?></div>
                <p>Skala 1 - 5 bintang</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-smile"></i>
                <h3>Persentase Kepuasan</h3>
                <div class="number"><?php echo $persenKepuasan; ?>%</div>
                <p>Rating 4 & 5 dari total</p>
            </div>
        </div>

        <!-- Section Tabel -->
        <div class="table-container">
            <div class="table-header">
                <h2>Data Survei Pembeli</h2>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Produk</th>
                        <th>Rating</th>
                        <th>Saran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($data)){ ?>
                    <tr>
                        <td style="font-weight: 600;"><?php echo htmlspecialchars($row['nama']); ?></td>
                        <td><?php echo htmlspecialchars($row['kelas']); ?></td>
                        <td><?php echo htmlspecialchars($row['produk']); ?></td>
                        <td>
                            <span class="badge-rating">
                                <i class="fas fa-star"></i> <?php echo htmlspecialchars($row['rating']); ?>
                            </span>
                        </td>
                        <td style="color: #666; font-size: 0.9rem;"><?php echo nl2br(htmlspecialchars($row['saran'])); ?></td>
                    </tr>
                    <?php } ?>
                    <?php if(mysqli_num_rows($data) == 0): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 3rem; color: #999;">
                            <i class="fas fa-inbox" style="font-size: 2rem; display: block; margin-bottom: 1rem;"></i>
                            Belum ada data survei yang masuk.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>
