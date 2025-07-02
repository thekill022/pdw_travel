<?php

session_start();

if (!isset($_SESSION["username"]) || !isset($_SESSION["role"]) || $_SESSION["role"] !== "Member") {
    header("Location: /tugas_pdw");
    exit();
}

include '../vendor/autoload.php'; 
include '../db/connection.php'; 

        global $conn;
        $idJadwal = $_POST["idjadwal"];
        $jumlah = (int) $_POST["jumlah"];
        $sql = "SELECT (SELECT harga FROM paketLiburan WHERE idPaket = j.idPaket) AS harga FROM jadwal j WHERE id_jadwal = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $idJadwal);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $data = 0;

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $data = $row["harga"];
            }
        } else {
            die("Harga tidak ditemukan untuk ID Jadwal: " . htmlspecialchars($idJadwal));
        }

$_SESSION['biodata'] = $_POST;

// Midtrans Config
\Midtrans\Config::$serverKey = 'YOUR_SERVER_KEY';
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

$order_id = uniqid('ORDER-');

// Data Snap
$params = [
  'transaction_details' => [
    'order_id' => $order_id,
    'gross_amount' => (float) $data * $jumlah,
  ],
  'customer_details' => [
    'first_name' => $_POST['nama'][0],
    'email' => $_POST['email'][0],
  ]
];

// Buat Snap Token
$snapToken = \Midtrans\Snap::getSnapToken($params);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mengarahkan ke Pembayaran...</title>
  <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="YOUR_CLIENT_KEY"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;600&display=swap">
  <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
  <style>
    body {
      font-family: 'Raleway', sans-serif;
    }
  </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">

  <div class="text-center p-6 bg-white shadow-md rounded-lg max-w-md">
    <div class="flex justify-center mb-4">
      <i class="fas fa-credit-card text-blue-600 text-5xl animate-pulse"></i>
    </div>
    <h2 class="text-2xl font-semibold text-gray-800 mb-2">Sedang Mengarahkan ke Pembayaran</h2>
    <p class="text-gray-600 mb-4">Mohon tunggu sebentar, Anda akan diarahkan ke halaman pembayaran Midtrans.</p>
    <div class="flex justify-center">
      <div class="w-12 h-12 border-4 border-blue-500 border-dashed rounded-full animate-spin"></div>
    </div>
  </div>

  <script>
    snap.pay('<?= $snapToken ?>', {
      onSuccess: function(result) {
        window.location.href = "success.php?order_id=<?= $order_id ?>";
      },
      onPending: function(result) {
        alert("Menunggu pembayaran.");
      },
      onError: function(result) {
        alert("Pembayaran gagal.");
      }
    });
  </script>

</body>
</html>
