<?php
session_start();
if (!isset($_SESSION["username"]) || !isset($_SESSION["role"]) || $_SESSION["role"] != "Admin") {
    header("Location: /tugas_pdw");
    exit();
}

if (isset($_GET["status"]) && $_GET["status"] == "gagal") {
    echo "<script>alert('gagal mengubah data')</script>";
}

include '../db/connection.php';
$filter = $_GET['paket'] ?? '';

if ($filter !== '') {
    global $conn;
    $query = "SELECT * FROM vw_berangkat WHERE nama_paket LIKE ?";
    $stmt = $conn->prepare($query);
    $like = "%" . $filter . "%";
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $query = "SELECT * FROM vw_berangkat";
    $result = mysqli_query($conn, $query);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paket Liburan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</head>
<body>

    <!-- navbar -->
<?php include '../components/navbar.php' ?>

<section class="min-h-screen grid grid-cols-1 md:grid-cols-[auto,1fr]">

  <!-- Tombol Toggle Sidebar (Hanya muncul di layar kecil) -->
  <button data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar" aria-controls="sidebar-multi-level-sidebar" type="button"
    class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
    <span class="sr-only">Open sidebar</span>
    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
      <path clip-rule="evenodd" fill-rule="evenodd"
        d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
      </path>
    </svg>
  </button>

    <!-- Sidebar -->
  <?php 
    include '../components/sidebar.php';
    sidebar($member = "user.php", $paket="paket.php",$jadwal="jadwal.php", $keberangkatan="#");
  ?>
  
  <!-- Main Content -->
<div class="p-6">
  <h2 class="text-2xl font-bold text-gray-700 mb-4">📅 Daftar Keberangkatan</h2>

  <form method="GET" class="mb-4 flex items-center gap-2">
  <label for="paket" class="text-sm text-gray-700">Filter Paket:</label>
  <input type="text" id="paket" name="paket" value="<?= htmlspecialchars($filter) ?>" 
         class="border border-gray-300 rounded px-2 py-1 text-sm" placeholder="Contoh: Bali">
  <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700 text-sm">Filter</button>
  <a href="?" class="text-sm text-blue-500 hover:underline ml-2">Reset</a>
</form>

  <div class="overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-600 bg-white shadow rounded-lg">
      <thead class="text-xs text-gray-700 uppercase bg-gray-100">
        <tr>
          <th class="px-4 py-3 text-center">No</th>
          <th class="px-4 py-3 text-center">Nama</th>
          <th class="px-4 py-3 text-center">Paket</th>
          <th class="px-4 py-3 text-center">Tanggal Berangkat</th>
          <th class="px-4 py-3 text-center">Status</th>
          <th class="px-4 py-3 text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) :
        ?>
        <tr class="border-b hover:bg-gray-50">
          <td class="px-4 py-3"><?= $no++ ?></td>
          <td class="px-4 py-3"><?= htmlspecialchars($row['nama_peserta']) ?></td>
          <td class="px-4 py-3"><?= htmlspecialchars($row['nama_paket']) ?></td>
          <td class="px-4 py-3"><?= htmlspecialchars($row['jadwal']) ?></td>
          <td class="px-4 py-3">
            <span class="px-2 py-1 rounded text-white 
              <?= $row['status'] == 'sukses' ? 'bg-green-500' : ($row['status'] == 'sukses' ? 'bg-blue-500' : 'bg-yellow-500') ?>">
              <?= $row['status'] == 'sukses' ? "Berangkat" : "Batal Berangkat"; ?>
            </span>
          </td>
          <td class="px-4 py-3">
            <form action="../query/update_status.php" method="POST" class="flex gap-2">
              <input type="hidden" name="id" value="<?= $row['id_peserta'] ?>">
              <select name="status" class="border rounded px-2 py-1 text-sm">
                <option value="sukses">Akan Berangkat</option>
                <option value="gagal">Batal Berangkat</option>
              </select>
              <button type="submit" name="ubah" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 text-sm">Ubah</button>
            </form>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>