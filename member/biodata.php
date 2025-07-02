<?php
session_start();
if (!isset($_SESSION["username"]) || !isset($_SESSION["role"]) || $_SESSION["role"] !== "Member") {
    header("Location: /tugas_pdw");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biodata</title>
    <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
</head>
<body>
<div class="flex gap-3 justify-center items-center min-h-screen">
    <div class="p-4 md:p-5">
                        <ol class="relative border-s border-gray-200 dark:border-gray-600 ms-3.5 mb-4 md:mb-5">                  
                            <li class="mb-10 ms-8">            
                                <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-700 rounded-full -start-3.5 ring-8 ring-blue-200 dark:ring-gray-700 dark:bg-blue-700">
                                <i class="fa-solid fa-user text-white dark:text-white"></i>
                                </span>
                                <h3 class="flex items-start mb-1 text-lg font-semibold text-gray-900 dark:text-white">Menentukan Jumlah Orang</h3>
                                <time class="block mb-3 text-sm font-normal leading-none text-gray-500 dark:text-gray-400">Isikan jumlah orang yang akan berangkat</time>
                            </li>
                            <li class="mb-10 ms-8">
                                <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-700 rounded-full -start-3.5 ring-8 ring-blue-200 dark:ring-gray-700 dark:bg-blue-700">
                                    <i class="fa-solid fa-clipboard text-white dark:text-white"></i>
                                </span>
                                <h3 class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">Mengisi Biodata</h3>
                                <time class="block mb-3 text-sm font-normal leading-none text-gray-500 dark:text-gray-400">Mengisikan Data Diri</time>
                            </li>
                            <li class="ms-8">
                                <span class="absolute flex items-center justify-center w-6 h-6 bg-gray-100 rounded-full -start-3.5 ring-8 ring-white dark:ring-gray-700 dark:bg-gray-600">
                                <i class="fa-solid fa-circle-check text-gray-500"></i>
                                </span>
                                <h3 class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">Pembayaran Berhasil</h3>
                                <time class="block mb-3 text-sm font-normal leading-none text-gray-500 dark:text-gray-400">Berhasil melakukan pembayara, mendapatkan tiket</time>
                            </li>
                        </ol>
    </div>
    
      <div class="max-w-3xl max-h-[80vh] mx-auto bg-white shadow-md p-6 rounded-md w-full overflow-y-auto">
        <form action="checkout.php" method="post">
            <?php 
            if (isset($_GET["jumlah"]) && isset($_GET["jadwal"])) {
                $jumlah = (int) $_GET["jumlah"];
                $idJadwal = $_GET["jadwal"];
            } else {
                header("Location: main.php");
                exit();
            }
            for ($i=0; $i < $jumlah; $i++) : ?>
    
                <h2 class="text-2xl font-bold mb-4">Data Diri <?php echo $jumlah == 1? "" : ($i + 1); ?></h2>
                <label class="block mb-2 font-semibold">Nama Lengkap</label>
                <input type="text" name="nama[]" required class="border border-gray-300 px-3 py-2 w-full rounded-md mb-4">
    
                <label class="block mb-2 font-semibold">Email</label>
                <input type="email" name="email[]" required class="border border-gray-300 px-3 py-2 w-full rounded-md mb-4">
    
                <label class="block mb-2 font-semibold">Telepon</label>
                <input type="number" name="telepon[]" required class="border border-gray-300 px-3 py-2 w-full rounded-md mb-4">
                <?php endfor; ?>
            <input type="hidden" name="idjadwal" value="<?php echo $idJadwal ?>">
            <input type="hidden" name="jumlah" value="<?php echo $jumlah ?>">
            <button type="submit" class="bg-blue-700 text-white p-[10px] rounded-md">Submit</button>
        </form>
        <a href="main.php" class="inline-block mt-4 text-blue-600">Batalkan dan kembali</a>
      </div>
</div>

</body>
</html>