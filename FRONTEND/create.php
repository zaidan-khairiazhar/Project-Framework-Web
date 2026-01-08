<?php
session_start();
if (!isset($_SESSION['token'])) {
    header("Location: login.php");
    exit;
}

// Fetch Propinsi for Dropdown
$ch = curl_init('http://localhost:8000/api/propinsi');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response_prop = curl_exec($ch);
curl_close($ch);
$propinsiList = json_decode($response_prop, true)['data'] ?? [];

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = [
        'nama_kota' => $_POST['nama_kota'],
        'propinsi_id' => $_POST['propinsi_id']
    ];

    $ch = curl_init('http://localhost:8000/api/kota');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == 201) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Gagal menambah kota. Code: " . $httpCode;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Kota</title>
</head>
<body>
    <h2>Tambah Kota</h2>
    <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
    <form method="POST">
        <div>
            <label>Nama Kota:</label><br>
            <input type="text" name="nama_kota" required>
        </div>
        <div>
            <label>Propinsi:</label><br>
            <select name="propinsi_id" required>
                <option value="">Pilih Propinsi</option>
                <?php foreach($propinsiList as $prop): ?>
                    <option value="<?php echo $prop['id']; ?>"><?php echo $prop['propinsi']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <br>
        <button type="submit">Simpan</button>
        <a href="index.php">Batal</a>
    </form>
</body>
</html>
