<?php
session_start();
if (!isset($_SESSION["username"]) || !isset($_SESSION["role"]) || $_SESSION["role"] == "Member") {
    header("Location: /tugas_pdw");
    exit();
}

include "../db/dbHelper.php";
jadwalTable();

if (isset($_GET["fail"]) && $_GET["fail"] == "true") {
    echo "<script>alert('Gagal Menambahkan Data, Silahkan coba lagi')</script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal</title>
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
    sidebar($member = "user.php", $paket="paket.php", $jadwal="#", $keberangkatan="berangkat.php");
  ?>

  <!-- Main Content -->
  <main class="w-full flex flex-col min-h-screen bg-white dark:bg-gray-900 p-6">
    <h1 class="text-2xl font-bold mb-6">Jadwal Keberangkatan</h1>

    <form class="grid gap-4 mb-4 grid-cols-2" method="post" action="http://localhost:8080/tugas_pdw/query/jadwal_crud.php">
        <div class="col-span-2">
            <label for="destinasi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Paket</label>
                <select id="destinasi" name="id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                    <?php
                        include '../db/connection.php';
                        global $conn;
        
                        $paket = "SELECT idPaket, nama FROM paketliburan";
                        $hasil = mysqli_query($conn, $paket);
        
                        if ($hasil && mysqli_num_rows($hasil) > 0) {
                            while ($row = mysqli_fetch_assoc($hasil)) :?>
                                <option value="<?php echo $row["idPaket"] ?>"><?php echo $row["nama"] ?></option>
                            <?php endwhile;
                        } else {
                            echo '<p class="text-gray-500 dark:text-gray-300">Belum ada data Flash Sale.</p>';
                        }
                            ?>
                        </select>
        </div>
        <div class="grid grid-cols-2 gap-4 col-span-2">
            <div>
                <label for="mulai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Keberangkatan</label>
                <input type="date" name="mulai" id="mulai" required placeholder="Tanggal Keberangkatan" class="input-class w-full border-2 border-gray-200 p-[10px] rounded-md" required>
            </div>
            <div class="w-full">
                <label for="selesai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Kepulangan</label>
                <input type="date" name="selesai" id="selesai" required placeholder="Tanggal Kepulangan" class="input-class w-full border-2 border-gray-200 p-[10px] rounded-md" required>
            </div>
        </div>
        <button type="submit" name="add" class="bg-blue-700 text-white p-[10px] rounded-md col-span-2">Submit</button>
    </form>

    </div>

    <div>
    <h2 class="text-lg font-bold mb-6">Jadwal</h2>

      <table class="min-w-full border border-gray-300 text-sm text-left">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-2">Destinasi</th>
            <th class="px-4 py-2">Keberangkatan</th>
            <th class="px-4 py-2 text-center">Kepulangan</th>
            <th class="px-4 py-2 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody id="userData">

        <?php
include '../db/connection.php';

$sql = "SELECT j.id_jadwal, p.nama AS destinasi, j.jadwal_awal, j.jadwal_akhir
        FROM jadwal j
        JOIN paketLiburan p ON j.idPaket = p.idPaket
        ORDER BY j.jadwal_awal ASC";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '
        <tr class="border-b">
            <td class="px-4 py-2">' . htmlspecialchars($row["destinasi"]) . '</td>
            <td class="px-4 py-2">' . htmlspecialchars($row["jadwal_awal"]) . '</td>
            <td class="px-4 py-2 text-center">' . htmlspecialchars($row["jadwal_akhir"]) . '</td>
            <td class="px-4 py-2 text-center">
                <button class="delete px-2 py-1 bg-red-500 text-white rounded" data-id="' . $row["id_jadwal"] . '">Delete</button>
            </td>
        </tr>';
    }
} else {
    echo '<tr><td colspan="4" class="text-center py-4 text-gray-500">Belum ada data jadwal.</td></tr>';
}
?>


        </tbody>
      </table>

    </div>
    
    <?php include "../components/footer.php" ?>

  </main>
</section>

<!-- delete modal -->
<div id="deleteModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Hapus Jadwal
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="deleteModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
              <input type="hidden" id="idDel">
              <h1>Apakah Anda Yakin ingin Menghapus Jadwal?</h1>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
            <button id="postDelete" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Yakin</button>
            <button data-modal-hide="deleteModal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Batalkan</button>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="../js/jadwal.js"></script>

</body>
</html>