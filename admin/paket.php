<?php
session_start();
if (!isset($_SESSION["username"]) || !isset($_SESSION["role"]) || $_SESSION["role"] == "Member") {
    header("Location: /tugas_pdw");
    exit();
}

if (isset($_GET["type"]) && $_GET["type"] == "false") {
    echo "<script>alert('Ekstensi foto tidak diizinkan')</script>";
} 
else if(isset($_GET["fail"]) && $_GET["fail"] == "true") {
    echo "<script>alert('Gagal mengupload file')</script>";
}

?>

<!-- create table -->
 <?php
    include "../db/dbHelper.php";
    paketTable();
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan</title>
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
    sidebar($member = "user.php", $paket="#", $jadwal="jadwal.php" ,$keberangkatan="berangkat.php");
  ?>

  <!-- Main Content -->
  <main class="w-full flex flex-col min-h-screen bg-white dark:bg-gray-900 p-6">
    <h1 class="text-2xl font-bold mb-6">Manajemen Paket</h1>


        <!-- buat form -->
        <div>

            <h2 class="text-lg font-bold mb-1">Tambahkan Paket Liburan</h2>

            <form class="p-4 md:p-5" action="../query/paket_crud.php" method="post" enctype="multipart/form-data">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Paket</label>
                        <input type="text" name="nama" id="nama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Tulis nama paket" required="">
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="harga" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Harga</label>
                        <input type="number" name="harga" id="harga" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Rp.100000" required="">
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="foto" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Foto</label>
                        <input id="foto" name="foto" type="file" class="file:bg-blue-700 file:rounded-md rounded-md">
                    </div>
                    <div class="col-span-2">
                        <label for="deskripsi" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi Paket</label>
                        <textarea id="deskripsi" name="deskripsi" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Tulis deskripsi produk disini"></textarea>                    
                    </div>
                </div>
                <button name="add" type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                    Tambah Paket
                </button>
            </form>

        </div>

    
    <h2 class="text-lg font-bold mb-1">Lihat Data</h2>
    <div class="my-3 grid grid-cols-8">
      <input type="text" id="username" class="border border-gray-200 rounded-md p-[5px] col-span-3 focus:ring-1" placeholder="Ketikkan Destinasi...">
      <button id="cari" class="bg-blue-600 text-white px-4 py-1 rounded-md mx-1 col-span-1">Cari</button>
    </div>

    <!-- card destinasi -->
<div id="card" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
<?php
    include '../db/connection.php';
    global $conn;

    $query = "SELECT * FROM paketLiburan";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '
                <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <img class="rounded-t-lg w-full h-48 object-cover" src="../' . $row["path"] . '" alt="Foto Paket" />
                    <div class="p-5">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">' . htmlspecialchars($row["nama"]) . '</h5>
                        
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400 line-clamp-3">' . htmlspecialchars($row["deskripsi"]) . '</p>

                        <p class="text-blue-600 font-semibold mb-3">Rp ' . number_format($row["harga"], 0, ',', '.') . '</p>

                        <div class="flex gap-2">
                            <button data-id="' . $row["idPaket"] .'" data-nama="' . $row["nama"] .'" data-harga="' . $row["harga"] .'" data-deskripsi="' . $row["deskripsi"] .'" class="edit px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">Edit</button>
                            <button data-id="' . $row["idPaket"] .'" class="delete px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">Delete</button>
                        </div>
                    </div>
                </div>';
        }
    } else {
        echo '<p class="text-gray-500 dark:text-gray-300">Belum ada data paket liburan yang tersedia.</p>';
    }

    mysqli_close($conn);
?>
    </div>

    
    <?php include "../components/footer.php" ?>
  </main>

</section>


<!-- edit modal -->

<div id="modal-edit" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Edit Paket
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="modal-edit">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                    <input type="hidden" name="id" id="idEd">
                    <div class="col-span-2">
                        <label for="namaEd" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Paket</label>
                        <input type="text" name="nama" id="namaEd" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Tulis nama paket" required>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="hargaEd" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Harga</label>
                        <input type="number" name="harga" id="hargaEd" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Rp.100000" required>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label for="fotoEd" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Foto (Abaikan Jika Tidak Ingin Mengganti Foto)</label>
                        <input id="fotoEd" name="foto" type="file" class="file:bg-blue-700 file:rounded-md rounded-md">
                    </div>
                    <div class="col-span-2">
                        <label for="deskripsiEd" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi Paket</label>
                        <textarea id="deskripsiEd" name="deskripsi" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Tulis deskripsi produk disini" required></textarea>                    
                    </div>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button id="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                <button data-modal-hide="modal-edit" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Decline</button>
            </div>
        </div>
    </div>
</div>

<!-- delete modal -->
<div id="deleteModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Hapus Paket
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
              <h1>Apakah Anda Yakin ingin Menghapus Paket?</h1>
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
<script src="../js/paket.js"></script>

</body>
</html>