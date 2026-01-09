<?php
session_start();
if (!isset($_SESSION['token'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "ID tidak ditemukan.";
    exit;
}

// Fetch Propinsi
$ch = curl_init('http://localhost:8000/api/propinsi');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response_prop = curl_exec($ch);
curl_close($ch);
$propinsiList = json_decode($response_prop, true)['data'] ?? [];

// Fetch Kota Detail
$ch = curl_init("http://localhost:8000/api/kota/$id");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response_kota = curl_exec($ch);
curl_close($ch);
$kotaData = json_decode($response_kota, true)['data'] ?? null;

if (!$kotaData) {
    echo "Data kota tidak ditemukan.";
    exit;
}

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = [
        'nama_kota' => $_POST['nama_kota'],
        'propinsi_id' => $_POST['propinsi_id'],
        '_method' => 'PUT' // Laravel understands this to treat POST as PUT
    ];

    $ch = curl_init("http://localhost:8000/api/kota/$id");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true); // Still POST, but with _method=PUT or usage of curl_setopt customrequest
    // Laravel might need this instead:
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == 200) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Gagal update kota. Code: " . $httpCode . " Response: " . $response;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Kota</title>
</head>
<body>
    <h2>Edit Kota</h2>
    <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
    <form method="POST">
        <div>
            <label>Nama Kota:</label><br>
            <input type="text" name="nama_kota" value="<?php echo htmlspecialchars($kotaData['nama_kota']); ?>" required>
        </div>
        <div>
            <label>Propinsi:</label><br>
            <select name="propinsi_id" required>
                <option value="">Pilih Propinsi</option>
                <?php foreach($propinsiList as $prop): ?>
                    <option value="<?php echo $prop['id']; ?>" <?php echo ($prop['id'] == $kotaData['propinsi_id']) ? 'selected' : ''; ?>>
                        <?php echo $prop['nama_propinsi']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <br>
        <button type="submit">Update</button>
        <a href="index.php">Batal</a>
    </form>
</body>
</html>
