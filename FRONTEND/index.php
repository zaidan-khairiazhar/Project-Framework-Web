<?php
session_start();
if (!isset($_SESSION['token'])) {
    header("Location: login.php");
    exit;
}

$start = microtime(true);
// Fetch Data from API
$ch = curl_init('http://localhost:8000/api/kota');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$end = microtime(true);
$duration = $end - $start;

$data = json_decode($response, true);
$kotaList = $data['data'] ?? [];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kota</title>
    <!-- Simple CSS for Table -->
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn { padding: 5px 10px; text-decoration: none; color: white; border-radius: 3px; }
        .btn-add { background-color: green; }
        .btn-edit { background-color: orange; }
        .btn-delete { background-color: red; }
    </style>
</head>
<body>
    <h2>Daftar Kota</h2>
    <p>Selamat datang, <?php echo htmlspecialchars($_SESSION['user']['name'] ?? 'User'); ?></p>
    <a href="create.php" class="btn btn-add">Tambah Kota</a>
    <a href="logout.php" class="btn" style="background-color: #333; float:right;">Logout</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Kota</th>
                <th>Propinsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($kotaList)): ?>
                <?php foreach ($kotaList as $kota): ?>
                <tr>
                    <td><?php echo $kota['id']; ?></td>
                    <td><?php echo htmlspecialchars($kota['nama_kota']); ?></td>
                    <td><?php echo htmlspecialchars($kota['propinsi']['nama_propinsi'] ?? '-'); ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $kota['id']; ?>" class="btn btn-edit">Edit</a>
                        <a href="delete.php?id=<?php echo $kota['id']; ?>" class="btn btn-delete" onclick="return confirm('Yakin hapus?');">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4">Tidak ada data kota.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <p><small>Load time: <?php echo number_format($duration, 4); ?> sec</small></p>
</body>
</html>
