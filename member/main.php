<?php
session_start();
if (!isset($_SESSION["username"]) || !isset($_SESSION["role"]) || $_SESSION["role"] !== "Member") {
    header("Location: /tugas_pdw");
    exit();
}
include "../db/connection.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PDW Travel - Paket Wisata</title>
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
        <a href="#" class="flex items-center gap-3 font-semibold text-blue-600"><i class="fas fa-suitcase-rolling"></i> Paket Travel</a>
        <a href="tiket.php" class="flex items-center gap-3"><i class="fa-solid fa-ticket"></i>Tiket</a>
        <a href="akun.php" class="flex items-center gap-3"><i class="fas fa-user"></i> Akun Saya</a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 bg-gray-50">
      
      <!-- Header -->
      <div class="flex justify-between items-center mb-8">
        <div>
          <h2 class="text-3xl font-bold text-gray-800">Selamat Datang, <?php echo $_SESSION["nama"] ?> 👋</h2>
          <p class="text-gray-500">Temukan paket perjalanan terbaik untuk Anda!</p>
        </div>

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

      <!-- Paket Travel -->
      <section>
        <h3 class="text-xl font-semibold mb-6 text-gray-700">Paket Travel Unggulan</h3>
        
        <!-- Search -->
        <form class="mb-3" action="main.php" method="get">
          <input type="text" value="<?php echo (isset($_GET["key"]) ? $_GET["key"] : ''); ?>" name="key" placeholder="Cari paket..." class="border px-4 py-1 rounded-lg shadow-sm" />
          <button id="search" class="bg-blue-700 text-white px-3 py-1 rounded-md" type="submit">Cari</button>
        </form>

        <!-- List Paket -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <?php
          include '../db/connection.php';
          global $conn;

          if (isset($_GET['key'])) {
              $key = mysqli_real_escape_string($conn, $_GET["key"]);
              $query = "SELECT * FROM paketLiburan WHERE nama LIKE '%$key%'";
          } else {
              $query = "SELECT * FROM paketLiburan";
          }
          $result = mysqli_query($conn, $query);

          if ($result && mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                  echo '
                  <div class="bg-white rounded-lg shadow-md overflow-hidden">
                      <img src="../' . $row['path'] .'" alt="'. $row["nama"] .'" class="w-full h-48 object-cover">
                      <div class="p-4">
                        <h4 class="text-lg font-bold text-gray-800">'. $row["nama"] .'</h4>
                        <p class="text-blue-600 font-bold">Rp ' . number_format($row["harga"], 0, ',', '.') . '</p>
                        <div class="bg-blue-600 text-center rounded-md mt-4">
                          <a href="detail.php?id='.$row["idPaket"].'" class="block w-full text-white py-2 rounded hover:bg-blue-700">Lihat Detail</a>
                        </div>
                      </div>
                  </div>';
              }
          } else {
              echo '<p class="text-gray-500">Belum ada data paket liburan yang tersedia.</p>';
          }

          mysqli_close($conn);
          ?>
        </div>
      </section>
    </main>
  </div>

  <script src="../js/main.js"></script>
</body>
</html>
