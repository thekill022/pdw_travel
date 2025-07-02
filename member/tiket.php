<?php
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "Member") {
    header("Location: /tugas_pdw");
    exit();
}

include "../db/connection.php";

// Ambil data tiket berdasarkan user login
$sql = "SELECT 
    peserta.nama AS nama_peserta,
    peserta.email,
    peserta.no_hp,
    peserta.status,
    jadwal.jadwal_awal,
    jadwal.jadwal_akhir,
    paketliburan.nama
FROM peserta
JOIN users ON peserta.id = users.id
JOIN jadwal ON peserta.id_jadwal = jadwal.id_jadwal
JOIN paketliburan ON jadwal.idPaket = paketliburan.idPaket
WHERE users.username = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION["username"]);
$stmt->execute();
$result = $stmt->get_result();
$tiket = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PDW Travel - Tiket Saya</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</head>
<body class="bg-gray-100 font-sans">

<div class="flex min-h-screen">

  <!-- Sidebar -->
  <aside class="w-64 bg-white shadow-lg p-6 space-y-6">
    <h1 class="text-2xl font-bold text-blue-600 tracking-wide">PDW TRAVEL</h1>
    <nav class="space-y-4 text-gray-700">
      <a href="main.php" class="flex items-center gap-3"><i class="fas fa-suitcase-rolling"></i> Paket Travel</a>
      <a href="#" class="flex items-center gap-3 font-semibold text-blue-600"><i class="fa-solid fa-ticket"></i> Tiket</a>
      <a href="akun.php" class="flex items-center gap-3"><i class="fas fa-user"></i> Akun Saya</a>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 p-8 bg-gray-50">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
      <h2 class="text-3xl font-bold text-gray-800">🎫 Tiket Anda</h2>
      <div class="flex items-center gap-4 bg-white px-4 py-2 rounded-lg shadow border border-gray-200 max-w-xs">
  
          <div class="flex-1 min-w-0">
            <p class="text-sm font-semibold text-gray-800 truncate">
              <?php echo $_SESSION["nama"]; ?>
            </p>
            <p class="text-[10px] font-semibold text-blue-700 truncate">
              <?php echo $_SESSION["role"]; ?>
            </p>
          </div>
          <img class="w-10 h-10 rounded-full border border-blue-700" src="../assets/icons/User.jpeg" alt="User Photo" />

          <form action="../query/auth.php" method="post">
            <button name="logout" type="submit" class="bg-blue-700 text-white px-4 py-2 rounded-md hover:bg-blue-800 transition whitespace-nowrap">
              Logout
            </button>
          </form>
        </div>
    </div>

    <!-- Tiket Cards -->
    <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
      <?php if (count($tiket) > 0): ?>
        <?php foreach ($tiket as $row): ?>
          <div class="bg-white shadow-md rounded-lg p-5 border-l-4 border-blue-600">
            <h3 class="text-xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($row['nama']) ?></h3>
            <p class="text-gray-600">
  <i class="fas fa-calendar-day text-green-500 mr-1"></i>
  <?= date('d M Y, H:i', strtotime($row['jadwal_awal'])) ?> &mdash; 
  <?= date('d M Y, H:i', strtotime($row['jadwal_akhir'])) ?>
</p>

            <p class="text-gray-600"><i class="fas fa-user text-orange-500 mr-1"></i><?= htmlspecialchars($row['nama_peserta']) ?></p>
            <p class="text-gray-600"><i class="fas fa-envelope text-blue-400 mr-1"></i><?= htmlspecialchars($row['email']) ?></p>
            <p class="text-gray-600"><i class="fas fa-phone text-indigo-400 mr-1"></i><?= htmlspecialchars($row['no_hp']) ?></p>
            <p class="mt-2 text-sm">
              Status: 
              <span class="px-2 py-1 rounded text-white text-xs
                <?= $row['status'] === 'sukses' ? 'bg-green-500' : ($row['status'] === 'gagal' ? 'bg-red-500' : 'bg-yellow-500') ?>">
                <?= ucfirst($row['status']) ?>
              </span>
            </p>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-center text-gray-500 col-span-full">Belum ada tiket yang terdaftar untuk Anda.</p>
      <?php endif; ?>
    </div>
  </main>
</div>
</body>
</html>
