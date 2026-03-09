<?php
include "koneksi.php";
$data = mysqli_query($conn, "SELECT * FROM survei");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Hasil Survei</title>
    <style>
        body { font-family: 'Inter', sans-serif; padding: 20px; background-color: #f4f7f6; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        th, td { padding: 12px 15px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #007bff; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        h2 { color: #333; }
        .back-btn { display: inline-block; margin-bottom: 20px; color: #007bff; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
    <a href="index.html" class="back-btn">&larr; Kembali ke Website</a>
    <h2>Daftar Hasil Survei</h2>
    <table>
        <tr>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Produk</th>
            <th>Rating</th>
            <th>Saran</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($data)){ ?>
        <tr>
            <td><?php echo htmlspecialchars($row['nama']); ?></td>
            <td><?php echo htmlspecialchars($row['kelas']); ?></td>
            <td><?php echo htmlspecialchars($row['produk']); ?></td>
            <td><?php echo htmlspecialchars($row['rating']); ?></td>
            <td><?php echo htmlspecialchars($row['saran']); ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
