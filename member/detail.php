<?php
session_start();
if (!isset($_SESSION["username"]) || !isset($_SESSION["role"]) || $_SESSION["role"] !== "Member") {
    header("Location: /tugas_pdw");
    exit();
}

include "../db/connection.php";

if (!isset($_GET["id"])) {
    echo "ID paket tidak ditemukan.";
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET["id"]);

// Ambil data paket liburan
$queryPaket = "SELECT * FROM paketLiburan WHERE idPaket = '$id'";
$resultPaket = mysqli_query($conn, $queryPaket);

if (!$resultPaket || mysqli_num_rows($resultPaket) == 0) {
    echo "Paket tidak ditemukan.";
    exit();
}

$paket = mysqli_fetch_assoc($resultPaket);

// Ambil jadwal yang sesuai dengan paket
$queryJadwal = "SELECT * FROM jadwal WHERE idPaket = '$id'";
$resultJadwal = mysqli_query($conn, $queryJadwal);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Detail Paket - <?php echo $paket["nama"]; ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

  <div class="mx-auto bg-white overflow-hidden">
    <img src="../<?php echo $paket["path"]; ?>" alt="<?php echo $paket["nama"]; ?>" class="w-full h-96 object-cover">

    <div class="p-6 space-y-4">
      <h1 class="text-3xl font-bold text-gray-800"><?php echo $paket["nama"]; ?></h1>
      <p class="text-blue-600 font-bold text-xl">Rp <?php echo number_format($paket["harga"], 0, ',', '.'); ?></p>
      
      <div class="text-gray-700">
        <h2 class="text-lg font-semibold mb-2">Deskripsi:</h2>
        <p><?php echo nl2br($paket["deskripsi"]); ?></p>
      </div>

      <?php if (mysqli_num_rows($resultJadwal) > 0): ?>
        <div class="text-gray-700">
          <h2 class="text-lg font-semibold mb-2 mt-6">Jadwal Keberangkatan:</h2>
          <div class="grid grid-cols-4">
            <?php while ($jadwal = mysqli_fetch_assoc($resultJadwal)): ?>
                <button class="border-2 border-blue-700 text-blue-700 p-[10px] hover:bg-blue-700 hover:text-white rounded-md">
                    <a href="jumlah.php?jadwal=<?php echo $jadwal["id_jadwal"] ?>">
                        <?php echo date("d M Y", strtotime($jadwal["jadwal_awal"])) . " - " . date("d M Y", strtotime($jadwal["jadwal_akhir"])); ?>
                    </a>
                </button>
            <?php endwhile; ?>
          </div>
        </div>
      <?php else: ?>
        <p class="text-gray-500 italic">Belum ada jadwal tersedia untuk paket ini.</p>
      <?php endif; ?>

      <div class="flex gap-4 mt-6">
        <a href="main.php" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-md">Kembali</a>
      </div>
    </div>
  </div>

</body>
</html>
