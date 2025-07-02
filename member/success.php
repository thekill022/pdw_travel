<?php
session_start();

if (!isset($_SESSION["username"]) || !isset($_SESSION["role"]) || $_SESSION["role"] !== "Member") {
    header("Location: /tugas_pdw");
    exit();
}

include '../db/connection.php';

$order_id = $_GET["order_id"] ?? "UNKNOWN";

$biodata = $_SESSION['biodata'] ?? [];
$jumlah = isset($biodata["jumlah"]) ? (int) $biodata["jumlah"] : 0;
$idJadwal = isset($biodata["idjadwal"]) ? (int) $biodata["idjadwal"] : null;
$nama = $biodata["nama"] ?? [];
$email = $biodata["email"] ?? [];
$no_hp = $biodata["telepon"] ?? [];
$username = $_SESSION["username"] ?? "";

if ($username && $idJadwal && count($nama) > 0 && count($email) > 0 && count($no_hp) > 0) {
    // Ambil ID user dari tabel users
    $stmtUser = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmtUser->bind_param("s", $username);
    $stmtUser->execute();
    $resultUser = $stmtUser->get_result();
    $userData = $resultUser->fetch_assoc();
    $userId = $userData['id'] ?? null;
    $stmtUser->close();

    if ($userId) {
        // Masukkan peserta satu per satu
        $stmt = $conn->prepare("INSERT INTO peserta (nama, email, no_hp, id, id_jadwal, status) VALUES (?, ?, ?, ?, ?, 'sukses')");
        for ($i = 0; $i < $jumlah; $i++) {
            $stmt->bind_param("sssii", $nama[$i], $email[$i], $no_hp[$i], $userId, $idJadwal);
            $stmt->execute();
        }
        $stmt->close();

        unset($_SESSION['biodata']); // Bersihkan agar tidak dobel insert
    } else {
        die("User tidak ditemukan.");
    }
} else {
    die("Data peserta tidak lengkap atau tidak ditemukan.");
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pembayaran Berhasil</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Raleway', sans-serif;
    }
  </style>
</head>
<body class="bg-green-50 flex items-center justify-center min-h-screen px-4">

  <div class="bg-white p-8 rounded-lg shadow-lg max-w-lg w-full text-center">
    <div class="flex justify-center mb-6">
      <i class="fas fa-check-circle text-green-500 text-6xl animate-bounce"></i>
    </div>
    <h1 class="text-2xl md:text-3xl font-bold text-green-700 mb-2">Pembayaran Berhasil!</h1>
    <p class="text-gray-600 mb-6">Terima kasih! Pembayaran Anda telah dikonfirmasi.</p>

    <div class="bg-gray-100 p-4 rounded-md mb-6 text-left">
      <p class="text-gray-700"><strong>ID Pesanan:</strong> <span class="text-blue-600"><?= htmlspecialchars($order_id) ?></span></p>
      <p class="text-gray-700 mt-2"><strong>Status:</strong> <span class="text-green-600">Berhasil</span></p>
    </div>

    <a href="main.php" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
      Kembali ke Beranda
    </a>
  </div>

</body>
</html>